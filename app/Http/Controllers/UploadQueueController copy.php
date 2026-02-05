<?php

namespace App\Http\Controllers;

use App\Models\UploadQueue;
use App\Models\Album;
use App\Enums\UploadStatus;
use App\Jobs\RunLLMTextJob;
use App\Jobs\RunLLMVisionJob;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UploadQueueController extends Controller
{
    public function index(Request $request)
    {
        // Get queues only for the logged-in user's albums
        $queues = UploadQueue::whereHas('album', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })
            ->with('album') // Eager load album to show names in the view
            ->orderByRaw("FIELD(status, 'PENDING', 'PROCESSING', 'FAILED')")
            ->latest()
            ->paginate(20);

        return view('upload_queues.index', [
            'queues' => $queues,
            'title'   => 'SmartSorter AI - Queues',
            'header_name' => 'Queues\Create',
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

                // Generate a secure, user-namespaced path
                $path = $file->store("users/{$userId}/upload_queues", 'local');

                // Create record in the database
                UploadQueue::create([
                    'album_id'          => $album->id,
                    'file_path'         => $path,
                    'original_filename' => $originalName,
                    'status'            => UploadStatus::PENDING,
                ]);

                $categories = Category::where('album_id', $request->album_id)
                    ->select(['id', 'category_name', 'ai_rules'])
                    ->get();

                // 2. Build a context string for the AI
                // This tells the AI exactly what buckets are available.
                $categoryContext = $categories->map(function ($cat) {
                    return "- ID {$cat->id}: \"{$cat->category_name}\" (Rules: " . ($cat->ai_rules ?? 'General sorting') . ")";
                })->implode("\n");


                Log::info($categoryContext);
                // 3. Define the Master Prompt
                // We use a Heredoc for clean formatting. We instruct the model to handle "messy" data.
                //                 $prompt = <<<EOT
                // You are SmartSorter AI, an expert archivist and personal assistant. 
                // Your task is to analyze the attached image (screenshot, receipt, letter, photo, or messy note) and produce **STRICT JSON ONLY** output—no explanations, no markdown, no extra text, no emojis.

                // ### AVAILABLE CATEGORIES:
                // {$categoryContext}
                // - ID 0: "Uncategorized" (Use only if it strictly fits none of the above)

                // ### TASKS:
                // 1. Analyze the image: extract all visible text (OCR) and interpret visual context (logos, layout, handwriting).
                // 2. Categorize: select the **single best Category ID** from the list above.
                // 3. Reason: give a concise reason in one sentence.
                // 4. Action Engine: based on the content, determine the next best action (e.g., reminder, calendar event, transcribe, archive, urgent).

                // ### RESPONSE FORMAT (EXACT JSON, NO EXTRA TEXT):
                // {
                //   "category_id": 0,
                //   "confidence_score": 0,
                //   "summary": "Short descriptive title of the file",
                //   "reasoning": "One-sentence explanation for the category choice",
                //   "extracted_data": {
                //     "date": null,
                //     "amount": null,
                //     "sender": null
                //   },
                //   "suggested_action": {
                //     "type": "archive",
                //     "label": "Short label",
                //     "detail": "Description of the recommended action"
                //   }
                // }

                // ⚠️ IMPORTANT: Respond **strictly in JSON**. Do not include any text outside of the JSON object.
                // EOT;
                $prompt = <<<EOT
You are an expert image analyst. Analyze the attached image thoroughly. 
Include:
- OCR text (all visible text)
- Objects, logos, or handwritten notes
- Layout and context
- Any other visual clues

Do not summarize, categorize, or suggest actions. Respond **only with detailed observations**.

EOT;





                // 4. Generate a unique cache key to prevent duplicate processing
                $cacheKey = 'ai_sort_' . $request->user()->id . '_' . md5($file->getClientOriginalName() . microtime());

                $base64Image = base64_encode(file_get_contents($file->getRealPath()));
                Log::info('base64Image: ' . $base64Image);

                // 5. Dispatch the Job
                // We pass the image path and the constructed prompt.
                // Ideally, pass the $uploadQueue->id so the Job can update the database record directly.
                RunLLMVisionJob::dispatch('qwen3-vl:4b', $prompt, $base64Image, $cacheKey, $categoryContext);
                // Veteran Tip: This is where you would dispatch 
                // a Job to process the AI sorting per file.
                // ProcessImageSorting::dispatch($queueItem);
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
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'album_id' => 'required|exists:albums,id',
    //         'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // Max 10MB
    //     ]);

    //     // Security: Ensure user owns the album
    //     $userOwnsAlbum = $request->user()->albums()->where('id', $request->album_id)->exists();
    //     if (!$userOwnsAlbum) abort(403, 'Unauthorized');

    //     DB::transaction(function () use ($request) {
    //         $file = $request->file('file');
    //         $originalName = $file->getClientOriginalName();

    //         // Store file safely in 'local' storage
    //         // $path = $file->store('uploads/queues');
    //         $path = $file->store('users/' . $request->user()->id . '/upload_queues', 'public');


    //         UploadQueue::create([
    //             'album_id' => $request->album_id,
    //             'file_path' => $path,
    //             'original_filename' => $originalName,
    //             'status' => UploadStatus::PENDING,
    //         ]);
    //     });

    //     // Redirect back to the Album so the user can see it was added
    //     return redirect()->route('albums.show', $request->album_id)
    //         ->with('message', 'File added to processing queue.');
    // }

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
