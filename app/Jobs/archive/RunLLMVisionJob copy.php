<?php

namespace App\Jobs;

use App\AI\AIConfig;
use App\Enums\UploadStatus;
use App\Models\UploadQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RunLLMVisionJob extends AIConfig implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $model;
    public string $prompt;
    public string $base64Image;
    public string $categories;
    public UploadQueue $upload_queue;
    public string $cacheKey;

    public $tries = 3;
    public $timeout = 1000;

    public function __construct(string $model, string $prompt, string $base64Image, string $categories, UploadQueue $upload_queue, string $cacheKey)
    {
        $this->model = $model;
        $this->prompt = $prompt;
        $this->base64Image = $base64Image;
        $this->categories = $categories;
        $this->upload_queue = $upload_queue;
        $this->cacheKey = $cacheKey;
    }






    public function handle(): void
    {
        try {

            UploadQueue::where('id', $this->upload_queue->id)
                ->update(['status' => UploadStatus::IMAGE_PROCESSING->value]);
            Log::info('RunLLMVisionJob started for UploadQueue ID: ' . $this->upload_queue->id);
            Log::info(' UploadQueue: ' . $this->upload_queue);


            $response = Http::timeout(1000)
                ->post('http://localhost:11434/api/chat', [
                    'model'  => $this->model, //llava:7b , qwen3-vl:8b
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $this->prompt,
                            'images' => [
                                $this->base64Image
                            ]

                        ]
                    ],
                    'stream' => false,
                ]);


            $visionData = json_encode($response->json(), JSON_PRETTY_PRINT);
            $categories = $this->categories;
            $this->setTextPrompt($categories, $visionData);

            $model = $this->getTextModel();
            $prompt = $this->getTextPrompt();

            Log::info('model: ' . $model);
            Log::info('prompt: ' . $prompt);
            Log::info('visionData: ' . $visionData);
            Log::info('categories: ' . $categories);

            RunLLMTextJob::dispatch($model, $prompt, $this->upload_queue, $this->cacheKey . '2nd')->onQueue('text');


            Cache::put(
                $this->cacheKey,
                json_encode($response->json(), JSON_PRETTY_PRINT),
                now()->addMinutes(30)
            );
        } catch (\Exception $e) {
            Log::error('RunLLMTextJob failed: ' . $e->getMessage());

            Cache::put(
                $this->cacheKey,
                json_encode(['error' => true, 'message' => $e->getMessage()], JSON_PRETTY_PRINT),
                now()->addMinutes(30)
            );

            throw $e;
        }
    }

    public function failed(\Exception $exception)
    {
        Cache::put(
            $this->cacheKey,
            json_encode(['error' => true, 'message' => 'Job failed permanently: ' . $exception->getMessage()], JSON_PRETTY_PRINT),
            now()->addMinutes(60)
        );
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

    private function reportError(\Exception $e, string $title = 'RunLLMTextJob failed'): void
    {
        Log::error("{$title}: " . $e->getMessage());

        Cache::put(
            $this->cacheKey,
            json_encode(['error' => true, 'message' => $e->getMessage()], JSON_PRETTY_PRINT),
            now()->addMinutes(30)
        );
    }
}
