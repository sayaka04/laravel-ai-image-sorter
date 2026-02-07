<?php

namespace App\Http\Controllers\Table;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Album;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $selectedAlbumId = $request->album_id;

        $albums = $request->user()->albums;

        return view('categories.create', [
            'albums' => $albums,
            'selectedAlbumId' => $selectedAlbumId,
            'title'   => 'SmartSorter AI - Create Category',
            'header_name' => 'Create Category',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:albums,id',
            'category_name' => [
                'required',
                'string',
                'max:255',
                // Strict regex for valid folder names
                'regex:/^[^\\/?%*:|"<>\.]+$/',

                // COMPOSITE UNIQUE CHECK: Enforce unique name per user
                Rule::unique('categories', 'category_name')
                    ->where(function ($query) use ($request) {
                        return $query->where('album_id', $request->album_id);
                    }),
            ],
            'ai_rules' => 'nullable|string',
        ]);

        // Security: Ensure user owns the album
        $userOwnsAlbum = $request->user()->albums()->where('id', $validated['album_id'])->exists();
        if (!$userOwnsAlbum) {
            abort(403, 'You do not own this album');
        }

        $album = Album::find($validated['album_id']);
        $path = 'users/' . $request->user()->id . '/upload_sorted/' . $album->album_name . '/' . $validated['category_name'];

        if (Storage::disk('local')->makeDirectory($path)) {
            Category::create($validated);
        } else {
            return redirect()->back()->with([
                'error' => "Something went wrong with creating this directory!"
            ]);
        }

        return redirect()->back()->with([
            'success' => "Category created successfully!"
        ]);
    }

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
            'header_name' => 'Category: ' . $category->category_name,
        ]);
    }

    public function edit(Category $category)
    {
        if ($category->album->user_id !== request()->user()->id) {
            abort(403);
        }

        return view('categories.edit', [
            'category' => $category,
            'header_name' => 'Edit Category: ' . $category->category_name,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        if ($category->album->user_id !== request()->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:255',

                // Strict regex for valid folder names
                'regex:/^[^\\/?%*:|"<>\.]+$/',

                // COMPOSITE UNIQUE CHECK: Enforce unique name per user
                Rule::unique('categories', 'category_name')
                    ->where(function ($query) use ($category) {
                        return $query->where('album_id', $category->album->id);
                    })->ignore($category->id),
            ],
            'ai_rules' => 'nullable|string',
        ]);



        $oldPath = 'users/' . Auth::id() . '/upload_sorted/' . $category->album->album_name . '/' . $category->category_name;
        $newPath = 'users/' . Auth::id() . '/upload_sorted/' . $category->album->album_name . '/' . $validated['category_name'];

        $storageService = new StorageService();

        if ($storageService->renameFolder($oldPath, $newPath)) {
            $category->update($validated);
        } else {
            return redirect()->back()->with([
                'error' => "Something went wrong with updating this category directory!"
            ]);
        }

        return redirect()->back()->with([
            'success' => "Update Successful!"
        ]);
    }

    public function destroy(Category $category)
    {
        if ($category->album->user_id !== request()->user()->id) {
            abort(403);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('message', 'Category deleted');
    }
}
