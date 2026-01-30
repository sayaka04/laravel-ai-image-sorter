<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Details - {{ $uploadQueue->original_filename }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('upload_queues.index') }}" class="text-gray-500 hover:text-gray-900 flex items-center gap-2">
                    &larr; <span class="text-sm font-medium">Back to Queue</span>
                </a>
                <span class="text-lg font-bold text-gray-900">File Details</span>
                <div></div>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $uploadQueue->original_filename }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Uploaded {{ $uploadQueue->created_at->format('M d, Y h:i A') }}
                    </p>
                </div>
                <div>
                    @if($uploadQueue->status->value === 'PENDING')
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                    @elseif($uploadQueue->status->value === 'PROCESSING')
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Processing</span>
                    @else
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                    @endif
                </div>
            </div>

            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Target Album</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <a href="{{ route('albums.show', $uploadQueue->album_id) }}" class="text-indigo-600 hover:underline">
                                {{ $uploadQueue->album->album_name }}
                            </a>
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Storage Path</dt>
                        <dd class="mt-1 text-sm text-mono text-gray-600 sm:mt-0 sm:col-span-2 break-all">
                            {{ $uploadQueue->file_path }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Error Logs</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 italic text-gray-400">
                            No errors recorded.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('upload_queues.edit', $uploadQueue) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Edit Status
            </a>

            <form action="{{ route('upload_queues.destroy', $uploadQueue) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this queue item? The file will be removed.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                    Delete File
                </button>
            </form>
        </div>

    </div>
</body>

</html>