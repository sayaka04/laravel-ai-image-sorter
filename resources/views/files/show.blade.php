<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $file->file_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white shadow-sm border-b border-gray-200 p-4">
        <div class="max-w-7xl mx-auto flex text-sm text-gray-500 gap-2">
            <a href="{{ route('albums.index') }}" class="hover:text-gray-900">Home</a> /
            <a href="{{ route('albums.show', $file->category->album_id) }}" class="hover:text-gray-900">{{ $file->category->album->album_name }}</a> /
            <a href="{{ route('categories.show', $file->category_id) }}" class="hover:text-gray-900">{{ $file->category->category_name }}</a> /
            <span class="text-gray-900 font-medium">File Details</span>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8">

        <div>
            <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-200 mb-6">
                <div class="bg-gray-200 h-64 flex items-center justify-center">
                    <span class="text-gray-500 font-medium">[ File Preview Placeholder ]</span>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $file->file_name }}</h1>
                    <p class="mt-2 text-sm text-gray-600">{{ $file->summary ?? 'No AI summary generated yet.' }}</p>

                    <div class="mt-6 flex gap-3">
                        <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Download
                        </a>
                        <a href="{{ route('files.edit', $file) }}" class="inline-flex items-center px-4 py-2 border border-indigo-600 shadow-sm text-sm font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                            Edit Details
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-red-800">Danger Zone</h3>
                <div class="mt-2 flex justify-between items-center">
                    <p class="text-xs text-red-600">Permanently delete this file?</p>
                    <form action="{{ route('files.destroy', $file) }}" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-gray-900 text-gray-100 shadow sm:rounded-lg overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-700 flex justify-between items-center">
                    <h3 class="text-sm font-medium text-white">Raw AI Analysis</h3>
                    <span class="text-xs bg-gray-700 px-2 py-1 rounded">JSON</span>
                </div>
                <div class="p-4 bg-gray-800 font-mono text-xs overflow-auto h-96">
                    @if($file->raw_ai_response)
                    <pre>{{ json_encode($file->raw_ai_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                    @else
                    <span class="text-gray-500">// No raw data available</span>
                    @endif
                </div>
            </div>
        </div>

    </div>
</body>

</html>