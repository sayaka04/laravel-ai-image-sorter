<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manually Add File</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Manually Add File Record
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                (Normally handled by the Upload Queue)
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form action="{{ route('files.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="category_id" name="category_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->album->album_name }} > {{ $category->category_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="file_name" class="block text-sm font-medium text-gray-700">File Name</label>
                        <div class="mt-1">
                            <input type="text" name="file_name" id="file_name" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="e.g. invoice_january.pdf">
                        </div>
                    </div>

                    <div>
                        <label for="file_path" class="block text-sm font-medium text-gray-700">Internal Storage Path</label>
                        <div class="mt-1">
                            <input type="text" name="file_path" id="file_path" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="uploads/sorted/invoice_january.pdf">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">This must match the actual file location on disk.</p>
                    </div>

                    <div>
                        <label for="summary" class="block text-sm font-medium text-gray-700">Summary (Optional)</label>
                        <div class="mt-1">
                            <textarea id="summary" name="summary" rows="3" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('files.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>