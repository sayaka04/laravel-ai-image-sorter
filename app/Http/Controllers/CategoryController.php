<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Album;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Start with categories belonging to the user's albums
        $query = Category::whereHas('album', function ($q) use ($request) {
            $q->where('user_id', $request->user()->id);
        })->orderBy('created_at', 'asc');

        // Filter by Search (Category Name or AI Rules)
        $query->when($request->filled('search'), function ($q) use ($request) {
            $q->where(function ($sq) use ($request) {
                $sq->where('category_name', 'like', '%' . $request->search . '%')
                    ->orWhere('ai_rules', 'like', '%' . $request->search . '%');
            });
        });

        // Filter by Album
        $query->when($request->filled('album_id'), function ($q) use ($request) {
            $q->where('album_id', $request->album_id);
        });

        $categories = $query->with('album')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        // Fetch user's albums for the filter dropdown
        $albums = \App\Models\Album::where('user_id', $request->user()->id)
            ->orderBy('album_name')
            ->get();

        return view('categories.index', [
            'categories' => $categories,
            'albums' => $albums,
            'title'   => 'SmartSorter AI - Categories',
            'header_name' => 'Categories',
        ]);
    }

    public function create(Request $request)
    {
        // Optional: Pre-select album if passed in URL
        $selectedAlbumId = $request->album_id;

        // You might want to pass all albums for the dropdown
        $albums = $request->user()->albums;

        return view('categories.create', [
            'albums' => $albums,
            'selectedAlbumId' => $selectedAlbumId,
            'title'   => 'SmartSorter AI - Create Category',
            'header_name' => 'Categories/Create',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:albums,id',
            'category_name' => 'required|string|max:255',
            'ai_rules' => 'nullable|string',
        ]);

        // Security: Ensure user owns the album
        $userOwnsAlbum = $request->user()->albums()->where('id', $validated['album_id'])->exists();
        if (!$userOwnsAlbum) {
            abort(403, 'You do not own this album');
        }

        Category::create($validated);

        // FIX 2: Redirect instead of returning JSON
        return redirect()->route('categories.index')
            ->with('message', 'Category created successfully!');
    }

    // In App\Http\Controllers\CategoryController.php

    public function show(Request $request, Category $category)
    {
        // Security check (ensure user owns the album this category belongs to)
        if ($category->album->user_id !== $request->user()->id) {
            abort(403);
        }

        // 1. Start the query on the category's files
        $query = $category->files()->orderBy('created_at', 'asc');

        // 2. Apply Search Filter
        $query->when($request->filled('search'), function ($q) use ($request) {
            $q->where('file_name', 'like', '%' . $request->search . '%');
        });

        // 3. Apply Date Filters
        $query->when($request->filled('from'), function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->from);
        });

        $query->when($request->filled('to'), function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->to);
        });

        // 4. Paginate results
        $files = $query->latest()->paginate(20)->withQueryString();

        return view('categories.show', [
            'category' => $category,
            'files' => $files, // Pass the paginated files separately
            'title' => 'Category: ' . $category->category_name,
        ]);
    }

    public function edit(Category $category)
    {
        if ($category->album->user_id !== request()->user()->id) {
            abort(403);
        }

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if ($category->album->user_id !== request()->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'category_name' => 'sometimes|string|max:255',
            'ai_rules' => 'nullable|string',
        ]);

        $category->update($validated);

        // FIX 3: Redirect back to the album or category list
        return redirect()->route('categories.index')
            ->with('message', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        if ($category->album->user_id !== request()->user()->id) {
            abort(403);
        }

        $category->delete();

        // FIX 4: Redirect back
        return redirect()->route('categories.index')
            ->with('message', 'Category deleted');
    }
}
