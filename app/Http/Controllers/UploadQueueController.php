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
        $query = UploadQueue::whereHas('album', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->with('album');

        // Filter by Filename (Search)
        $query->when($request->filled('search'), function ($q) use ($request) {
            $q->where('original_filename', 'like', '%' . $request->search . '%');
        });

        // Filter by Album ID
        $query->when($request->filled('album_id'), function ($q) use ($request) {
            $q->where('album_id', $request->album_id);
        });

        // Filter by Status
        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        $queues = $query->orderByRaw(
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
            ->paginate(20)
            ->withQueryString();

        // Fetch user's albums for the dropdown filter
        $albums = \App\Models\Album::where('user_id', $request->user()->id)->orderBy('album_name')->get();

        return view('upload_queues.index', [
            'queues' => $queues,
            'albums' => $albums,
            'title' => 'SmartSorter AI - Queues',
            'header_name' => 'Queues',
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
            'header_name' => 'Queues/Create',
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

            // Optimization: Fetch categories once outside the loop
            $categories = Category::where('album_id', $request->album_id)
                ->select(['id', 'category_name', 'ai_rules'])
                ->get();

            $categoryContext = $categories->map(function ($cat) {
                return "- ID {$cat->id}: \"{$cat->category_name}\" (Rules: " . ($cat->ai_rules ?? 'General sorting') . ")";
            })->implode("\n");

            foreach ($files as $file) {
                $originalName = $file->getClientOriginalName();
                // Store file on 'public' disk
                $path = $file->store("users/{$userId}/upload_queues", 'public');

                $upload_queue = UploadQueue::create([
                    'album_id'          => $album->id,
                    'file_path'         => $path,
                    'original_filename' => $originalName,
                    'status'            => UploadStatus::PENDING->value,
                ]);

                // We do not need to load relations here, the Job will handle what it needs.

                $model = $this->getVisionModel();
                $prompt = $this->getVisionPrompt();
                $cacheKey = 'ai_sort_' . $request->user()->id . '_' . md5($file->getClientOriginalName() . microtime());

                // Logging only metadata now (safe)
                Log::info("Queueing File: {$originalName} | ID: {$upload_queue->id}");

                // Dispatch WITHOUT the base64 string
                ProcessImageAiVisionJob::dispatch(
                    $model,
                    $prompt,
                    $categoryContext,
                    $upload_queue,
                    $cacheKey
                )->onQueue('vision');
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

        return view('upload_queues.show', [
            'uploadQueue' => $uploadQueue,
            'title'   => 'SmartSorter AI - Queue Details',
            'header_name' => 'Queue Details',
        ]);
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
