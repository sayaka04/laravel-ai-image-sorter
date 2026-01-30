<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Queue Item</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Manage Queue Item</h2>
            <p class="mt-2 text-center text-sm text-gray-600">{{ $uploadQueue->original_filename }}</p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form action="{{ route('upload_queues.update', $uploadQueue) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Processing Status</label>
                        <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md border">
                            @foreach($statuses as $status)
                            <option value="{{ $status->value }}" {{ $uploadQueue->status->value == $status->value ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-gray-500">
                            Manually change status if the AI processor gets stuck or fails.
                        </p>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('upload_queues.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                        <button type="submit" class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>