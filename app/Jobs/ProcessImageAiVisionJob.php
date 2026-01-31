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

class ProcessImageAiVisionJob extends AIConfig implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $model;
    public string $prompt;
    public string $base64Image;
    public string $categories;
    public UploadQueue $uploadQueue;
    public string $cacheKey;

    public $tries = 3;
    public $timeout = 1000;

    public function __construct(string $model, string $prompt, string $base64Image, string $categories, UploadQueue $uploadQueue, string $cacheKey)
    {
        $this->model = $model;
        $this->prompt = $prompt;
        $this->base64Image = $base64Image;
        $this->categories = $categories;
        $this->uploadQueue = $uploadQueue;
        $this->cacheKey = $cacheKey;
    }






    public function handle(): void
    {
        try {

            // 1. Mark as image processing indicating the vision step
            $this->updateStatus(UploadStatus::IMAGE_PROCESSING);

            // 2. The HTTP Call (Kept as requested)
            $response = Http::timeout(1000)->post('http://localhost:11434/api/chat', [
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

            // 3. Process Result
            $visionData = json_encode($response->json(), JSON_PRETTY_PRINT);
            $this->cacheResult($visionData);

            // 4. Prepare next step (AIConfig logic)
            // Prepare text model and prompt based on vision data
            $this->setTextPrompt($this->categories, $visionData); // use vision data to set prompt for text AI model
            $prompt = $this->getTextPrompt(); // get the prepared prompt as a result of setTextPrompt call
            $model = $this->getTextModel(); // get the text AI model to use

            // log for debugging
            $this->logTextModelConfig($model, $prompt, $visionData, $this->categories);

            // 5. Finally, dispatch the text processing job to categorize the image and move it to the right folder
            ProcessImageAiTextJob::dispatch(
                $model,
                $prompt,
                $this->uploadQueue,
                $this->cacheKey . '2nd'
            )->onQueue('text');

            // End of try block
        } catch (\Exception $e) {
            $this->reportError($e);
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
    |
    | SEPARATION OF CONCERNS
    | These methods are used internally within the job to keep the code organized
    | and maintainable.
    |
    */
    private function updateStatus(UploadStatus $status): void
    {
        $this->uploadQueue->update(['status' => $status->value]);

        Log::info('RunLLMVisionJob started for UploadQueue ID: ' . $this->uploadQueue->id);
        Log::info(' UploadQueue: ' . $this->uploadQueue);
    }

    private function cacheResult(string $data): void
    {
        Cache::put($this->cacheKey, $data, now()->addMinutes(30));
    }

    private function logTextModelConfig($model, $prompt, $visionData, $categories): void
    {
        Log::info('model: ' . $model);
        Log::info('prompt: ' . $prompt);
        Log::info('visionData: ' . $visionData);
        Log::info('categories: ' . $categories);
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
