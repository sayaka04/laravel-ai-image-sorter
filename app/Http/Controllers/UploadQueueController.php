<?php

namespace App\Http\Controllers;

use App\Models\UploadQueue;
use App\Models\Album;
use App\Enums\UploadStatus;
use App\AI\AIConfig;
use App\Jobs\ProcessImageAiVisionJob;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\info;

class UploadQueueController extends AIConfig
{

    public function index(Request $request)
    {
        $queues = UploadQueue::whereHas('album', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })
            ->with('album')
            ->orderByRaw(
                "FIELD(status, ?, ?, ?, ?, ?)",
                [
                    UploadStatus::PENDING->value,
                    UploadStatus::IMAGE_PROCESSING->value,
                    UploadStatus::FINAL_PROCESSING->value,
                    UploadStatus::FAILED->value,
                    UploadStatus::COMPLETED->value,
                ]
            )
            ->latest()
            ->paginate(20);

        return view('upload_queues.index', [
            'queues' => $queues,
            'title' => 'SmartSorter AI - Queues',
            'header_name' => 'Queues\\Create',
        ]);
    }


    public function create(Request $request)
    {
        // Allow pre-selecting an album via URL ?album_id=X
        $selectedAlbumId = $request->album_id;
        $albums = $request->user()->albums; // For the dropdown

        return view('upload_queues.create', [
            'albums' => $albums,
            'selectedAlbumId' => $selectedAlbumId,
            'title'   => 'SmartSorter AI - Queues',
            'header_name' => 'Queues\Create',
        ]);
    }
    public function store(Request $request)
    {
        // 1. Validation: Expect 'images' as an array
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'images'   => 'required|array',
            'images.*' => 'required|file|mimes:jpg,jpeg,png,webp|max:10240', // Max 10MB per file
        ]);

        // 2. Security: Verify ownership once before starting
        $album = $request->user()->albums()->find($request->album_id);
        if (!$album) {
            abort(403, 'Unauthorized access to this album.');
        }

        // 3. Process & Store
        DB::transaction(function () use ($request, $album) {
            $userId = $request->user()->id;
            $files = $request->file('images');

            foreach ($files as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->store("users/{$userId}/upload_queues", 'public');

                $upload_queue = UploadQueue::create([
                    'album_id'          => $album->id,
                    'file_path'         => $path,
                    'original_filename' => $originalName,
                    'status'            => UploadStatus::PENDING->value,
                ]);

                $upload_queue->load('album.user');

                $categories = Category::where('album_id', $request->album_id)
                    ->select(['id', 'category_name', 'ai_rules'])
                    ->get();
                $categoryContext = $categories->map(function ($cat) {
                    return "- ID {$cat->id}: \"{$cat->category_name}\" (Rules: " . ($cat->ai_rules ?? 'General sorting') . ")";
                })->implode("\n");

                $model = $this->getVisionModel();
                $prompt = $this->getVisionPrompt();
                $base64Image = base64_encode(file_get_contents($file->getRealPath()));
                $cacheKey = 'ai_sort_' . $request->user()->id . '_' . md5($file->getClientOriginalName() . microtime());

                Log::info('model: ' . $model);
                Log::info('prompt: ' . $prompt);
                Log::info('base64Image: ' . $base64Image);
                Log::info('cacheKey: ' . $cacheKey);
                Log::info('categoryContext: ' . $categoryContext);


                ProcessImageAiVisionJob::dispatch($model, $prompt, $base64Image, $categoryContext, $upload_queue, $cacheKey)
                    ->onQueue('vision');
            }
        });

        // 4. Redirect with a count-aware message
        $count = count($request->file('images'));
        return redirect()->route('upload_queues.index')
            ->with([
                'message' => 'Successfully queued ' . $count . ' files for AI processing.',
                'title'   => 'SmartSorter AI - Albums',
                'header_name' => 'Albums',
            ]);
    }

    public function show(UploadQueue $uploadQueue)
    {
        // Security check
        if ($uploadQueue->album->user_id !== request()->user()->id) {
            abort(403);
        }

        return view('upload_queues.show', compact('uploadQueue'));
    }

    public function edit(UploadQueue $uploadQueue)
    {
        if ($uploadQueue->album->user_id !== request()->user()->id) {
            abort(403);
        }

        // We pass the Enum cases to the view for the dropdown
        $statuses = UploadStatus::cases();

        return view('upload_queues.edit', compact('uploadQueue', 'statuses'));
    }

    public function update(Request $request, UploadQueue $uploadQueue)
    {
        if ($uploadQueue->album->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:PENDING,PROCESSING,FAILED'
        ]);

        $uploadQueue->update(['status' => $validated['status']]);

        return redirect()->route('upload-queues.index')
            ->with('message', 'Queue status updated.');
    }

    public function destroy(UploadQueue $uploadQueue)
    {
        if ($uploadQueue->album->user_id !== request()->user()->id) {
            abort(403);
        }

        // Remove the physical file
        if (Storage::exists($uploadQueue->file_path)) {
            Storage::delete($uploadQueue->file_path);
        }

        $uploadQueue->delete();

        return redirect()->back()
            ->with('message', 'Item removed from queue.');
    }
}
