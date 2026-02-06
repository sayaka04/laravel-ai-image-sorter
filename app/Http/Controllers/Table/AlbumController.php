<?php

namespace App\Http\Controllers\Table;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


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
            'album_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Automatically assign the logged-in user
        $album = $request->user()->albums()->create($validated);

        Storage::disk('local')->makeDirectory('users/' . $request->user()->id . '/upload_sorted/' . $album->album_name);

        return redirect()
            ->route('albums.show', $album)
            ->with([
                'success' => 'Album created successfully',
                'title'   => 'SmartSorter AI - Albums',
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

        return view('albums.show', [
            'album' => $album,
            'categories' => $categories, // Pass the paginated variable
            'title'   => 'SmartSorter AI - Album Details',
            'header_name' => 'Album: ' . $album->album_name,
        ]);
    }

    public function update(Request $request, Album $album)
    {
        if ($album->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'album_name' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $album->update($validated);

        return response()->json(['message' => 'Album updated', 'data' => $album]);
    }

    public function destroy(Album $album)
    {
        if ($album->user_id !== request()->user()->id) {
            abort(403);
        }

        // The DB 'ON DELETE CASCADE' handles the children (categories/files),
        // but we should manually delete physical files if they exist (advanced logic).
        // For now, we just delete the record.
        $album->delete();

        return response()->json(['message' => 'Album deleted']);
    }
}
