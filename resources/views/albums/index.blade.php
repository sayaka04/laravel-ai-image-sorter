<!DOCTYPE html>
<html lang="en">

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

            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-12">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Your Collections</h1>
                        <p class="text-slate-500 mt-2 text-lg">Manage your photo dumps and document streams with ease.</p>
                    </div>
                    <a href="{{ route('albums.create') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 hover:shadow-lg hover:shadow-indigo-200 transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-2 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Album
                    </a>
                </div>

                @if(session('message'))
                <div class="mb-8 flex items-center p-4 text-emerald-800 bg-emerald-50/50 border border-emerald-100 rounded-2xl backdrop-blur-sm" role="alert">
                    <div class="p-1 bg-emerald-100 rounded-full mr-3">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('message') }}</span>
                </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($albums as $album)
                    <div class="group relative bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/60 transition-all duration-300 flex flex-col h-full overflow-hidden">

                        <div class="p-8 flex-grow">
                            <div class="flex justify-between items-start mb-6">
                                <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>

                                <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <form action="{{ route('albums.destroy', $album) }}" method="POST" onsubmit="return confirm('Delete this album?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors duration-200 truncate">
                                {{ $album->album_name }}
                            </h3>

                            <p class="mt-3 text-slate-500 text-sm leading-relaxed line-clamp-2">
                                {{ $album->description ?? 'No description provided for this collection.' }}
                            </p>

                            <div class="mt-6 flex items-center gap-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Files</span>
                                    <span class="text-lg font-bold text-slate-700">{{ $album->files_count ?? 0 }}</span>
                                </div>
                                <div class="h-8 w-px bg-slate-100"></div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Categories</span>
                                    <span class="text-lg font-bold text-slate-700">{{ $album->categories_count ?? 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-50 flex justify-between items-center">
                            <span class="text-xs font-medium text-slate-400 italic">
                                {{ $album->updated_at->diffForHumans() }}
                            </span>

                            <a href="{{ route('albums.show', $album) }}"
                                class="inline-flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-700">
                                View Album
                                <svg class="ml-1 w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-24 bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
                        <div class="bg-white p-6 rounded-3xl shadow-sm mb-4">
                            <svg class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Archive is empty</h3>
                        <p class="text-slate-500 mt-2">Ready to organize your media? Start here.</p>
                        <a href="{{ route('albums.create') }}" class="mt-8 px-8 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition-colors">
                            Initialize First Album
                        </a>
                    </div>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $albums->links() }}
                </div>
            </section>

        </main>

    </div>

</body>

</html>