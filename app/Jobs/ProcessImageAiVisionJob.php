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
use Illuminate\Support\Facades\Storage; // Added Storage Facade

class ProcessImageAiVisionJob extends AIConfig implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $model;
    public string $prompt;
    // public string $base64Image; // Removed: We don't want this in the payload
    public string $categories;
    public UploadQueue $uploadQueue;
    public string $cacheKey;

    public $tries = 3;
    public $timeout = 1000;

    // Updated Constructor: Removed $base64Image
    public function __construct(string $model, string $prompt, string $categories, UploadQueue $uploadQueue, string $cacheKey)
    {
        $this->model = $model;
        $this->prompt = $prompt;
        $this->categories = $categories;
        $this->uploadQueue = $uploadQueue;
        $this->cacheKey = $cacheKey;
    }

    public function handle(): void
    {
        try {
            // 1. Mark as image processing
            $this->updateStatus(UploadStatus::IMAGE_PROCESSING);

            // 1.5. NEW: Read the file from storage and Encode to Base64
            // We use the 'public' disk because that is where the controller stored it.
            if (!Storage::disk('public')->exists($this->uploadQueue->file_path)) {
                throw new \Exception("File not found at path: " . $this->uploadQueue->file_path);
            }

            $imageContents = Storage::disk('public')->get($this->uploadQueue->file_path);
            $base64Image = base64_encode($imageContents);

            // 2. The HTTP Call
            $response = Http::timeout(1000)->post('http://localhost:11434/api/chat', [
                'model'    => $this->model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $this->prompt,
                        'images' => [
                            $base64Image // Use the locally generated variable
                        ]
                    ]
                ],
                'stream' => false,
            ]);

            // 3. Process Result
            if ($response->failed()) {
                throw new \Exception('AI Server Error: ' . $response->body());
            }

            $visionData = json_encode($response->json(), JSON_PRETTY_PRINT);
            $this->cacheResult($visionData);

            // 4. Prepare next step (AIConfig logic)
            $this->setTextPrompt($this->categories, $visionData);
            $prompt = $this->getTextPrompt();
            $model = $this->getTextModel();

            // Log for debugging
            $this->logTextModelConfig($model, $prompt, $visionData, $this->categories);

            // 5. Dispatch the text processing job
            ProcessImageAiTextJob::dispatch(
                $model,
                $prompt,
                $this->uploadQueue,
                $this->cacheKey . '2nd'
            )->onQueue('text');
        } catch (\Exception $e) {
            $this->reportError($e);
            // We do not re-throw here if we want to mark it as failed gracefully in 'failed()'
            // But throwing it ensures Laravel's retry logic kicks in.
            throw $e;
        }
    }

    public function failed(\Exception $exception)
    {
        $this->reportError($exception, 'Job failed permanently');
        $this->uploadQueue->update(['status' => UploadStatus::FAILED->value]);
    }

    /*
    |--------------------------------------------------------------------------
    | Private Helper Methods
    |--------------------------------------------------------------------------
    */
    private function updateStatus(UploadStatus $status): void
    {
        $this->uploadQueue->update(['status' => $status->value]);

        Log::info('ProcessImageAiVisionJob running for UploadQueue ID: ' . $this->uploadQueue->id);
    }

    private function cacheResult(string $data): void
    {
        Cache::put($this->cacheKey, $data, now()->addMinutes(30));
    }

    private function logTextModelConfig($model, $prompt, $visionData, $categories): void
    {
        Log::info('Text Model Config Prepared:');
        Log::info('Model: ' . $model);
        // Truncate logs to avoid spamming massive strings
        Log::info('Prompt Preview: ' . substr($prompt, 0, 100) . '...');
        Log::info('Vision Data Preview: ' . substr($visionData, 0, 100) . '...');
    }

    private function reportError(\Exception $e, string $title = 'ProcessImageAiVisionJob failed'): void
    {
        Log::error($title . ': ' . $e->getMessage());

        Cache::put(
            $this->cacheKey,
            json_encode(['error' => true, 'message' => $e->getMessage()], JSON_PRETTY_PRINT),
            now()->addMinutes(30)
        );
    }
}
