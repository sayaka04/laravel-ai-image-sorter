<?php

namespace App\Jobs;

use App\Enums\UploadStatus;
use App\Models\Category;
use App\Models\UploadQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessImageAiTextJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $model;
    public string $prompt;
    public UploadQueue $uploadQueue;
    public string $cacheKey;

    public $tries = 3;
    public $timeout = 1000;

    public function __construct(string $model, string $prompt, UploadQueue $uploadQueue, string $cacheKey)
    {
        $this->model = $model;
        $this->prompt = $prompt;
        $this->uploadQueue = $uploadQueue;
        $this->cacheKey = $cacheKey;
    }

    public function handle(): void
    {
        try {
            // 1. Update status to reflect the final stage: AI-driven image classification and storage.
            $this->updateStatus(UploadStatus::FINAL_PROCESSING);

            // 2. Call AI for category classification that returns nested JSON.
            $response = Http::timeout($this->timeout)->post('http://127.0.0.1:11434/api/generate', [
                'model' => $this->model,
                'prompt' => $this->prompt,
                'stream' => false,
            ]);

            $rawJson = $response->json();
            $prettyResponse = json_encode($rawJson, JSON_PRETTY_PRINT);

            // 3. Cache results and update status to completed
            $this->finalizeQueueStatus($prettyResponse);

            // 4. Parse the nested JSON response
            $innerJson = $rawJson['response'] ?? '{}';
            $inner = json_decode($innerJson, true);

            // 5. Find the Category the AI actually chose
            $category = Category::findOrFail($inner['category_id']);
            Log::info('Image categorized under Category ID: ' . $category->id . ' Name: ' . $category->category_name);

            // 6. Move image to its permanent home
            $this->transferImageToCategoryFolder($category, $innerJson);
        } catch (\Exception $e) {
            $this->reportError($e);
            throw $e;
        }
    }

    /**
     * Handle permanent failure
     */
    public function failed(\Exception $exception)
    {
        $this->reportError($exception, 'Job failed permanently');
        $this->uploadQueue->update(['status' => UploadStatus::FAILED->value]);
    }



    /*
    |--------------------------------------------------------------------------
    | Private Helper Methods
    |--------------------------------------------------------------------------
    |
    | SEPARATION OF CONCERNS
    | These methods are used internally within the job to keep the code organized
    | and maintainable.
    |
    */
    private function updateStatus(UploadStatus $status): void
    {
        $this->uploadQueue->update(['status' => $status->value]);
    }

    private function finalizeQueueStatus(string $prettyResponse): void
    {
        Cache::put($this->cacheKey, $prettyResponse, now()->addMinutes(30));
        $this->updateStatus(UploadStatus::COMPLETED);
        Log::info("LLM Response Cached for Key: {$this->cacheKey}");
        Log::info('ProcessImageAiTextJob response: ' . $prettyResponse);
    }

    private function transferImageToCategoryFolder(Category $category, string $innerJson): void
    {
        $user = $this->uploadQueue->album->user;
        $album = $this->uploadQueue->album;

        // BUG FIX: Use the category name provided by the AI/Method argument
        $categoryName = $category->category_name;

        $destinationPath = "users/{$user->id}/{$album->album_name}/{$categoryName}";

        if (!Storage::disk('public')->exists($destinationPath)) {
            Storage::disk('public')->makeDirectory($destinationPath);
        }

        $newFilename = now()->format('Y-m-d') . '_' . basename($this->uploadQueue->original_filename);
        $from = $this->uploadQueue->file_path;
        $to = "{$destinationPath}/{$newFilename}";

        if (Storage::disk('public')->copy($from, $to)) {
            \App\Models\File::create([
                'file_name' => $newFilename,
                'file_path' => $to,
                'category_id' => $category->id,
                'raw_ai_response' => $innerJson,
            ]);

            Storage::disk('public')->delete($from);
            Log::info("File archived to: {$to}");
        }
    }

    private function reportError(\Exception $e, string $title = 'RunLLMVisionJob failed'): void
    {
        Log::error($title . ': ' . $e->getMessage());

        Cache::put(
            $this->cacheKey,
            json_encode(['error' => true, 'message' => $e->getMessage()], JSON_PRETTY_PRINT),
            now()->addMinutes(30)
        );
    }
}
