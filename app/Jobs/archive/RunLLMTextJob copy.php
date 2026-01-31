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

class RunLLMTextJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $model;
    public string $prompt;
    public UploadQueue $upload_queue;
    public string $cacheKey;

    public $tries = 3;
    public $timeout = 1000;

    public function __construct(string $model, string $prompt, UploadQueue $upload_queue, string $cacheKey)
    {
        $this->model = $model;
        $this->prompt = $prompt;
        $this->upload_queue = $upload_queue;
        $this->cacheKey = $cacheKey;
    }

    public function handle(): void
    {
        try {

            UploadQueue::where('id', $this->upload_queue->id)
                ->update(['status' => UploadStatus::FINAL_PROCESSING->value]);

            $response = Http::timeout(1000)->post(
                'http://127.0.0.1:11434/api/generate',
                [
                    'model' => $this->model,
                    'prompt' => $this->prompt,
                    'stream' => false,
                ]
            );
            $prettyResponse = json_encode($response->json(), JSON_PRETTY_PRINT);
            Log::info("LLM JSON Handler Response Cached:\n" . $prettyResponse);

            Cache::put(
                $this->cacheKey,
                json_encode($response->json(), JSON_PRETTY_PRINT),
                now()->addMinutes(30)
            );

            UploadQueue::where('id', $this->upload_queue->id)
                ->update(['status' => UploadStatus::COMPLETED->value]);

            $cachedResponse = $prettyResponse;

            $outer = json_decode($cachedResponse, true); // now it's an array

            $innerJson = $outer['response']; // this is a JSON string
            $inner = json_decode($innerJson, true); // now this is the actual data array

            // Log the main fields
            Log::info('LLM Response Summary', [
                'category_id'      => $inner['category_id'],
                'confidence_score' => $inner['confidence_score'],
                'reasoning'        => $inner['reasoning'],
                'summary'          => $inner['summary'],
            ]);

            // Log the extracted data
            Log::info('LLM Extracted Data', [
                'date'   => $inner['extracted_data']['date'],
                'amount' => $inner['extracted_data']['amount'],
                'sender' => $inner['extracted_data']['sender'],
            ]);

            // Log the suggested action
            Log::info('LLM Suggested Action', [
                'type'   => $inner['suggested_action']['type'],
                'label'  => $inner['suggested_action']['label'],
                'detail' => $inner['suggested_action']['detail'],
            ]);

            $category = Category::where('id', $inner['category_id'])->first();

            Log::info($this->upload_queue->file_path . " \n|\n " . "users/{$this->upload_queue->album->user->id}/{$this->upload_queue->album->album_name}/{$category->category_name}/" . now()->format('Y-m-d') . "_" . "{$this->upload_queue->original_filename}");


            $path = "users/{$this->upload_queue->album->user->id}/{$this->upload_queue->album->album_name}/{$category->category_name}";

            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

            // Storage::copy($this->upload_queue->file_path, "users/{$this->upload_queue->album->user->id}/{$this->upload_queue->album->album_name}");
            // Storage::disk('public')->copy(
            //     $this->upload_queue->file_path,
            //     "users/{$this->upload_queue->album->user->id}/{$this->upload_queue->album->album_name}/{$category->category_name}/" . now()->format('Y-m-d')
            //         . "_" . basename($this->upload_queue->original_filename)
            // );

            $from = $this->upload_queue->file_path;

            $to = "users/{$this->upload_queue->album->user->id}/{$this->upload_queue->album->album_name}/{$category->category_name}/"
                . now()->format('Y-m-d')
                . '_' . basename($this->upload_queue->original_filename);



            if (Storage::disk('public')->copy($from, $to)) {
                \App\Models\File::create(
                    [
                        'file_name' => now()->format('Y-m-d') . '_' . $this->upload_queue->original_filename,
                        'file_path' => $to,
                        'category_id' => $category->id,
                        'raw_ai_response' => $innerJson,
                    ]
                );
                Storage::disk('public')->delete($from);
            }





            // $categoryId      = $inner['category_id'];         // 3
            // $confidenceScore = $inner['confidence_score'];   // 1
            // $reasoning       = $inner['reasoning'];
            // $summary         = $inner['summary'];

            // $date   = $inner['extracted_data']['date'];       // null
            // $amount = $inner['extracted_data']['amount'];     // null
            // $sender = $inner['extracted_data']['sender'];     // null

            // $actionType   = $inner['suggested_action']['type'];   // archive
            // $actionLabel  = $inner['suggested_action']['label'];  // ""
            // $actionDetail = $inner['suggested_action']['detail']; // ""




            // Log::info("LLM Response Cached:\n" . $prettyResponse);
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
}
