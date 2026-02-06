<?php

namespace App\Http\Controllers\Table;

use App\Http\Controllers\Controller;

use App\Models\File;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $query = File::query()->whereHas('category.album', function ($q) use ($request) {
            $q->where('user_id', $request->user()->id);
        });

        // Search by Filename
        $query->when($request->filled('search'), function ($q) use ($request) {
            $q->where('file_name', 'like', '%' . $request->search . '%');
        });

        // Filter by Album
        $query->when($request->filled('album_id'), function ($q) use ($request) {
            $q->whereHas('category', function ($sq) use ($request) {
                $sq->where('album_id', $request->album_id);
            });
        });

        // Filter by Category
        $query->when($request->filled('category_id'), function ($q) use ($request) {
            $q->where('category_id', $request->category_id);
        });

        // Date Filters
        $query->when($request->filled('from'), function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->from);
        });

        $query->when($request->filled('to'), function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->to);
        });

        $files = $query->with('category.album')->latest()->paginate(20)->withQueryString();

        // Data for Filter Dropdowns
        $albums = \App\Models\Album::where('user_id', $request->user()->id)->orderBy('album_name')->get();

        // Optional: Filter categories based on selected album if applicable
        $categories = \App\Models\Category::whereHas('album', function ($q) use ($request) {
            $q->where('user_id', $request->user()->id);
            if ($request->filled('album_id')) {
                $q->where('id', $request->album_id);
            }
        })->orderBy('category_name')->get();

        return view('files.index', [
            'files' => $files,
            'albums' => $albums,
            'categories' => $categories,
            'title'   => 'SmartSorter AI - Files',
            'header_name' => 'Files',
        ]);
    }

    // "Create" is typically handled by the UploadQueue/AI Worker, 
    // but here is a manual entry method if needed.
    public function create()
    {
        // Get all categories belonging to the user's albums
        $categories = Category::whereHas('album', function ($q) {
            $q->where('user_id', request()->user()->id);
        })->with('album')->get();

        return view('files.create', [
            'categories' => $categories,
            'title'   => 'SmartSorter AI - Create File',
            'header_name' => 'Add File',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'file_name' => 'required|string|max:255',
            'file_path' => 'required|string',
            'raw_ai_response' => 'nullable|array',
        ]);

        // Security Check
        $category = Category::findOrFail($validated['category_id']);
        if ($category->album->user_id !== $request->user()->id) {
            abort(403);
        }

        $file = File::create($validated);

        return redirect()->route('categories.show', $category->id)
            ->with('message', 'File record created manually.');
    }

    public function show(File $file)
    {
        // Security Check
        if ($file->category->album->user_id !== request()->user()->id) {
            abort(403);
        }

        return view('files.show', [
            'file' => $file,
            'header_name' => 'File: ' . $file->file_name,
        ]);
    }

    public function edit(File $file)
    {
        if ($file->category->album->user_id !== request()->user()->id) {
            abort(403);
        }

        return view('files.edit', compact('file'));
    }

    public function update(Request $request, File $file)
    {
        if ($file->category->album->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'file_name' => 'sometimes|string|max:255',
            'summary' => 'nullable|string', // Added summary editing
        ]);

        $file->update($validated);

        return redirect()->route('files.show', $file)
            ->with('message', 'File details updated.');
    }

    public function destroy(File $file)
    {
        if ($file->category->album->user_id !== request()->user()->id) {
            abort(403);
        }

        $categoryId = $file->category_id;

        // Delete physical file
        if (Storage::exists($file->file_path)) {
            Storage::delete($file->file_path);
        }

        $file->delete();

        return redirect()->route('categories.show', $categoryId)
            ->with('message', 'File deleted permanently.');
    }
}
