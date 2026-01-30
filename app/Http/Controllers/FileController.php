<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $query = File::query();

        // Filter by category if provided
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);

            // Security: Ensure the category belongs to the user
            $category = Category::find($request->category_id);
            if ($category && $category->album->user_id !== $request->user()->id) {
                abort(403);
            }
        } else {
            // Otherwise show all files belonging to user's albums
            $query->whereHas('category.album', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            });
        }

        // FIX: Assign pagination result to variable
        $files = $query->with('category.album')->latest()->paginate(20);

        return view('files.index', compact('files'));
    }

    // "Create" is typically handled by the UploadQueue/AI Worker, 
    // but here is a manual entry method if needed.
    public function create()
    {
        // Get all categories belonging to the user's albums
        $categories = Category::whereHas('album', function ($q) {
            $q->where('user_id', request()->user()->id);
        })->with('album')->get();

        return view('files.create', compact('categories'));
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

        return view('files.show', compact('file'));
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
