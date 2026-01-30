<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $album->album_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('albums.index') }}" class="text-gray-500 hover:text-gray-900 flex items-center gap-2">
                    &larr; <span class="text-sm font-medium">Back to Albums</span>
                </a>
                <span class="text-lg font-bold text-gray-900">{{ $album->album_name }}</span>
                <div></div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="bg-white shadow rounded-lg p-6 mb-8 border border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Context</h1>
            <div class="bg-indigo-50 rounded-md p-4 text-indigo-800 text-sm border border-indigo-100">
                <strong>AI Instructions:</strong> {{ $album->description ?? 'No specific context provided.' }}
            </div>
            <div class="mt-6 flex space-x-3">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Upload Files
                </button>
                <button class="bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 font-medium py-2 px-4 rounded shadow">
                    Create Category
                </button>
            </div>
        </div>

        <div class="relative py-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="px-3 bg-gray-50 text-lg font-medium text-gray-900">
                    Smart Categories
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">

            @forelse($album->categories as $category)
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:border-indigo-300 transition cursor-pointer">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 truncate">
                                {{ $category->category_name }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                0 items </p>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-400">
                        {{ Str::limit($category->ai_rules, 40) }}
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View Files &rarr;</a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-10">
                <p class="text-gray-500 mb-4">No categories created yet.</p>
                <p class="text-sm text-gray-400">Once you upload files, the AI will auto-create these for you.</p>
            </div>
            @endforelse

        </div>

    </div>

</body>

</html>