<?php

namespace App\Http\Controllers\Table;

use App\Enums\UploadStatus;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\UploadQueue;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $query = Album::where('user_id', $request->user()->id)
            ->withCount(['categories', 'uploadQueues'])->orderBy('created_at', 'asc');

        // Search Filter
        $query->when($request->filled('search'), function ($q) use ($request) {
            $q->where('album_name', 'like', '%' . $request->search . '%');
        });

        // Date Filters
        $query->when($request->filled('from'), function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->from);
        });

        $query->when($request->filled('to'), function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->to);
        });

        $albums = $query->latest()->paginate(20)->withQueryString();

        $albums->getCollection()->transform(function ($album) {

            $storageService = new StorageService();
            $folderSize = $storageService->getFolderInfo('users/' . Auth::id() . "/upload_sorted/" . $album->album_name, 'local');

            $album->folderSize = $folderSize;
            return $album;
        });

        return view('albums.index', [
            'albums' => $albums,
            'title'  => 'SmartSorter AI - Albums',
            'header_name' => 'Albums',
        ]);
    }

    public function create()
    {
        return view('albums.create', [
            'title'  => 'SmartSorter AI - Albums',
            'header_name' => 'Create Album',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'album_name' => [
                'required',
                'string',
                'max:255',
                // Strict regex for valid folder names
                'regex:/^[^\\/?%*:|"<>\.]+$/',
                // COMPOSITE UNIQUE CHECK: Enforce unique name per user
                Rule::unique('albums', 'album_name')->where(function ($query) use ($request) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();


        // 2. Create Folder on Disk
        $path = 'users/' . Auth::id() . '/upload_sorted/' . $validated['album_name'];

        Storage::disk('local')->makeDirectory($path);

        if (Storage::disk('local')->makeDirectory($path)) {
            Album::create($validated);
        } else {
            return redirect()->back()->with([
                'error' => "Something went wrong with creating this directory!"
            ]);
        }

        return redirect()->back()->with([
            'success' => "Album created successfully!"
        ]);
    }

    public function show(Request $request, Album $album)
    {
        // Security: Ensure user owns the album
        if ($album->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }

        // Start Query on the Categories Relationship
        $query = $album->categories()->orderBy('created_at', 'asc');

        // Search Filter
        $query->when($request->filled('search'), function ($q) use ($request) {
            $q->where('category_name', 'like', '%' . $request->search . '%');
        });

        // Date Filters
        $query->when($request->filled('from'), function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->from);
        });

        $query->when($request->filled('to'), function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->to);
        });

        // Pagination
        $categories = $query->latest()->paginate(20)->withQueryString();

        $categories->getCollection()->transform(function ($category) {

            $storageService = new StorageService();
            $folderSize = $storageService->getFolderInfo('users/' . Auth::id() . '/upload_sorted/' . $category->album->album_name . '/' . $category->category_name, 'local');

            $category->folderSize = $folderSize;
            return $category;
        });

        return view('albums.show', [
            'album' => $album,
            'categories' => $categories, // Pass the paginated variable
            'title'   => 'SmartSorter AI - Album Details',
            'header_name' => 'Album: ' . $album->album_name,
        ]);
    }


    public function edit(Album $album)
    {
        return view('albums.edit', [
            'album' => $album,
            'header_name' => 'Edit Album: ' . $album->album_name,
        ]);
    }


    public function update(Request $request, Album $album)
    {
        // Authorization check
        if ($album->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'album_name' => [
                'required',
                'string',
                'max:255',
                // Strict regex for valid folder names
                'regex:/^[^\\/?%*:|"<>\.]+$/',

                // COMPOSITE UNIQUE CHECK

                // COMPOSITE UNIQUE CHECK: Enforce unique name per user
                Rule::unique('albums', 'album_name')
                    ->where(function ($query) use ($request) {
                        return $query->where('user_id', $request->user()->id);
                    })->ignore($album->id),
            ],
            'description' => 'nullable|string|max:1000',
        ]);

        $oldPath = 'users/' . Auth::id() . '/upload_sorted/' . $album->album_name;
        $newPath = 'users/' . Auth::id() . '/upload_sorted/' . $validated['album_name'];
        $storageService = new StorageService();

        if ($storageService->renameFolder($oldPath, $newPath)) {
            $album->update($validated);
        } else {
            return redirect()->back()->with([
                'error' => "Something went wrong with updating this directory!"
            ]);
        }

        return redirect()->back()->with([
            'success' => "Update Successful!"
        ]);
    }

    public function destroy(Album $album)
    {
        if ($album->user_id !== request()->user()->id) {
            abort(403);
        }

        $hasOngoingQueue = UploadQueue::where('album_id', $album->id)
            ->whereIn('status', [
                UploadStatus::IMAGE_PROCESSING,
                UploadStatus::FINAL_PROCESSING,
            ])
            ->exists();

        if ($hasOngoingQueue) {
            return redirect()->back()->with('warning', 'Can\'t delete this folder while it still has ongoing queues');
        }

        // The DB 'ON DELETE CASCADE' handles the children (categories/files),
        // but we should manually delete physical files if they exist (advanced logic).
        // For now, we just delete the record.
        $albumPath = 'users/' . Auth::id() . '/upload_sorted/' . $album->album_name;

        if (Storage::disk('local')->exists($albumPath)) {
            Storage::disk('local')->deleteDirectory($albumPath);

            $album->delete();
        }

        return redirect()->route('albums.index')->with('success', 'Album deleted successfully!');
    }
}
