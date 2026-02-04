<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SmartSorter AI'}}</title>

    @include('partials.assets')

</head>

<body class="bg-gray-50 flex h-screen overflow-hidden">

    @include('partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        @include('partials.navbar')

        <main class="flex-1 overflow-y-auto p-6">

            <section>


                <div class="bg-white shadow border-b border-gray-200">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                        <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                            <a href="{{ route('albums.index') }}" class="hover:text-gray-900">Albums</a>
                            <span>/</span>
                            <a href="{{ route('albums.show', $category->album_id) }}" class="hover:text-gray-900">{{ $category->album->album_name }}</a>
                            <span>/</span>
                            <span class="text-gray-900 font-medium">{{ $category->category_name }}</span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $category->category_name }}</h1>
                        <p class="text-sm text-gray-500 mt-1">
                            Rules: {{ $category->ai_rules ?? 'Standard sorting' }}
                        </p>
                        <a href="{{ route('download.folder', $category->album->album_name . '/' . $category->category_name) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/20 text-indigo-300 hover:text-indigo-200 text-xs font-medium rounded transition-all whitespace-nowrap decoration-none">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Download Category ZIP
                        </a>
                    </div>
                </div>

                <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @forelse($category->files as $file)
                        <div class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">

                            <div class="aspect-w-10 aspect-h-7 bg-gray-200 w-full overflow-hidden">
                                <div class="w-full h-32 flex items-center justify-center text-gray-400">
                                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="p-3">
                                <p class="text-sm font-medium text-gray-900 truncate" title="{{ $file->file_name }}">
                                    {{ $file->file_name }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                    {{ $file->summary ?? 'AI Processing...' }}
                                </p>
                                <a href="{{ route('files.show', $file) }}" class="absolute inset-0 focus:outline-none">
                                    <span class="sr-only">View file details</span>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-12 text-gray-500">
                            <svg class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p>No files in this category yet.</p>
                        </div>
                        @endforelse
                    </div>

                </div>

            </section>

        </main>

    </div>

</body>

</html>