<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Edit Category
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                        <div class="mt-1">
                            <input type="text" name="category_name" id="category_name"
                                value="{{ old('category_name', $category->category_name) }}" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="ai_rules" class="block text-sm font-medium text-gray-700">AI Rules</label>
                        <div class="mt-1">
                            <textarea id="ai_rules" name="ai_rules" rows="4"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('ai_rules', $category->ai_rules) }}</textarea>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Updating rules won't move existing files, but will affect future uploads.
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('albums.show', $category->album_id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            &larr; Back to Album
                        </a>

                        <div class="flex space-x-3">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category and all files inside?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                            Delete Category
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

</html>