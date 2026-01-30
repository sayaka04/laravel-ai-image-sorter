<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        // Best Practice: Pagination prevents crashing on large datasets
        // 'withCount' is efficient for showing "Album (50 items)"
        $albums = Album::where('user_id', $request->user()->id)
            ->withCount(['categories', 'uploadQueues'])
            ->latest()
            ->paginate(20);

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
            'header_name' => 'Albums/Create',
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

        Storage::disk('public')->makeDirectory('users/' . $request->user()->id . '/' . $album->album_name);

        return redirect()
            ->route('albums.show', $album)
            ->with([
                'success' => 'Album created successfully',
                'title'   => 'SmartSorter AI - Albums',
                'header_name' => 'Albums',
            ]);
    }

    public function show(Album $album)
    {
        // Security: Ensure user owns the album (Policy is better, but this is robust)
        if ($album->user_id !== request()->user()->id) {
            abort(403, 'Unauthorized');
        }

        // Eager load categories for the detailed view
        $album->load('categories');
        return view('albums.show', compact('album'));
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
