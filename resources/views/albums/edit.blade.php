<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album - {{ $album->album_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Edit Album
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                <a href="{{ route('albums.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    &larr; Cancel and go back
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">

                <form action="{{ route('albums.update', $album) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') <div>
                        <label for="album_name" class="block text-sm font-medium text-gray-700">
                            Album Name
                        </label>
                        <div class="mt-1">
                            <input id="album_name" name="album_name" type="text" required
                                value="{{ old('album_name', $album->album_name) }}"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        @error('album_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Context (for AI)
                        </label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="4"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $album->description) }}</textarea>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Updating this helps the AI understand how to sort future files.
                        </p>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('albums.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                        <button type="submit" class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>