<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SmartSorter AI'}}</title>

    @include('partials.assets')

</head>

<body class="flex h-screen overflow-hidden bg-slate-950 text-slate-400 font-sans">

    @include('partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        @include('partials.navbar')

        <div class="flex-1 min-h-0 flex flex-col gap-6 p-4 md:p-6 lg:p-8 overflow-y-auto w-full">

            <section>
                <div class="flex flex-col gap-4 shrink-0">

                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-light text-white tracking-tight">Albums</h1>
                            <p class="text-sm text-slate-500 mt-1">Manage and organize your image collections</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">

                            <a href="{{ route('albums.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-ai-accent hover:bg-indigo-500 text-white text-xs font-medium rounded shadow-[0_0_15px_-5px_rgba(99,102,241,0.5)] transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add New Album
                            </a>

                            <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-900 border border-slate-700 hover:border-slate-500 text-white text-xs font-medium rounded transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add New Category
                            </a>

                            <a href="{{ route('upload_queues.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-900 border border-slate-700 hover:border-slate-500 text-white text-xs font-medium rounded transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Upload to Queue
                            </a>
                        </div>
                    </div>

                    <div class="h-px w-full bg-slate-800"></div>

                    <form action="{{ route('albums.index') }}" method="GET">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                            <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                                <div class="relative group w-full sm:w-64">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-slate-600 group-focus-within:text-ai-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="w-full bg-slate-900 border border-slate-800 focus:border-ai-accent text-slate-300 text-sm rounded block pl-10 py-2 placeholder-slate-600 transition-all focus:outline-none focus:ring-1 focus:ring-ai-accent/50"
                                        placeholder="Search album name...">
                                </div>

                                <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded text-xs transition-all">
                                    Apply Filters
                                </button>

                                @if(request()->anyFilled(['search', 'from', 'to']))
                                <a href="{{ route('albums.index') }}" class="text-slate-500 hover:text-white text-xs flex items-center">Clear</a>
                                @endif
                            </div>

                            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                <div class="relative w-full sm:w-auto">
                                    <label class="absolute -top-2 left-2 bg-slate-950 px-1 text-[10px] text-slate-500 font-mono">FROM</label>
                                    <input type="date" name="from" value="{{ request('from') }}"
                                        class="w-full sm:w-auto bg-slate-900 border border-slate-800 text-slate-300 text-xs rounded px-3 py-2 font-mono uppercase focus:border-ai-accent focus:outline-none">
                                </div>
                                <span class="text-slate-600">-</span>
                                <div class="relative w-full sm:w-auto">
                                    <label class="absolute -top-2 left-2 bg-slate-950 px-1 text-[10px] text-slate-500 font-mono">TO</label>
                                    <input type="date" name="to" value="{{ request('to') }}"
                                        class="w-full sm:w-auto bg-slate-900 border border-slate-800 text-slate-300 text-xs rounded px-3 py-2 font-mono uppercase focus:border-ai-accent focus:outline-none">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </section>

            <main class="flex-1 p-5">
                <section class="p-6 bg-slate-950">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                        <div class="group relative flex flex-col pt-10">
                            <a href="{{ route('albums.create') }}" class="flex-grow flex items-center justify-center border-2 border-dashed border-slate-800 rounded-xl hover:border-indigo-500/50 hover:bg-slate-900/40 transition-all cursor-pointer min-h-[400px]">
                                <div class="text-center p-12">
                                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-slate-700 transition-all duration-300">
                                        <svg class="w-8 h-8 text-slate-500 group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs group-hover:text-indigo-300 transition-colors">
                                        Create New Album
                                    </p>
                                </div>
                            </a>
                        </div>

                        @foreach($albums as $album)
                        <div class="group relative">
                            <div class="absolute top-0 left-0 w-32 h-10 bg-slate-800 border-t border-x border-slate-700 rounded-t-lg z-0 transition-all group-hover:bg-slate-700"></div>

                            <div class="relative z-10 mt-10 bg-slate-900 border border-slate-700 rounded-xl rounded-tl-none p-6 shadow-2xl transition-all duration-300 group-hover:translate-y-[-4px] group-hover:border-indigo-500/50">

                                <div class="flex justify-between items-start mb-6">
                                    <div>
                                        <h3 class="text-white font-bold text-lg tracking-tight">{{ $album->album_name }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.8)]"></div>
                                            <p class="text-[10px] text-slate-500 font-mono uppercase tracking-widest">{{ $album->updated_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] bg-slate-800 text-slate-400 px-2 py-1 rounded font-mono">Folder</span>
                                </div>

                                <a href="{{ route('albums.show', $album->id) }}" class="block relative h-44 w-full mb-6 flex items-center justify-center bg-slate-950/60 rounded-lg border border-slate-800 overflow-hidden cursor-pointer">
                                    <div class="absolute inset-0 opacity-5 bg-[grid-white_20px]"></div>

                                    <div class="relative w-28 h-20 mt-4">
                                        <div class="absolute inset-0 bg-slate-500 rounded-sm border border-white/10 transform translate-x-4 -translate-y-8 -rotate-12 group-hover:-translate-y-12 group-hover:-rotate-15 transition-all duration-500 overflow-hidden shadow-lg">
                                            <div class="w-full h-full bg-gradient-to-br from-indigo-900 to-slate-800 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c0 1.1.9-2 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="absolute inset-0 bg-slate-400 rounded-sm border border-white/10 transform -translate-x-4 -translate-y-6 rotate-6 group-hover:-translate-y-10 group-hover:rotate-12 transition-all duration-500 delay-75 overflow-hidden shadow-lg">
                                            <div class="w-full h-full bg-gradient-to-br from-purple-900 to-slate-800"></div>
                                        </div>
                                        <div class="absolute inset-0 bg-slate-200 rounded-sm border-2 border-white transform -translate-y-4 group-hover:-translate-y-8 transition-all duration-500 delay-150 overflow-hidden shadow-2xl">
                                            <div class="w-full h-full bg-slate-800 flex flex-col">
                                                <div class="flex-grow bg-indigo-500/20 flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <div class="h-3 bg-white w-full"></div>
                                            </div>
                                        </div>
                                        <div class="absolute inset-x-[-8px] bottom-[-12px] h-16 bg-slate-800 rounded-md shadow-[0_-4px_10px_rgba(0,0,0,0.5)] border-t border-slate-600 flex items-center px-3">
                                            <div class="w-full h-1.5 bg-slate-900/50 rounded-full overflow-hidden">
                                                <div class="w-2/3 h-full bg-indigo-500"></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <div class="grid grid-cols-3 gap-4 mb-6">
                                    <div class="bg-slate-950/50 p-3 rounded-lg border border-slate-800 text-center">
                                        <p class="text-[9px] text-slate-500 uppercase font-black mb-1">Sub Folders</p>
                                        <p class="text-lg text-white font-mono leading-none">0 <span class="text-[10px] text-indigo-400">DIR</span></p>
                                    </div>
                                    <div class="bg-slate-950/50 p-3 rounded-lg border border-slate-800 text-center">
                                        <p class="text-[9px] text-slate-500 uppercase font-black mb-1">Files</p>
                                        <p class="text-lg text-white font-mono leading-none">{{ $album->images_count ?? 0 }} <span class="text-[10px] text-indigo-400">IMG</span></p>
                                    </div>
                                    <div class="bg-slate-950/50 p-3 rounded-lg border border-slate-800 text-center">
                                        <p class="text-[9px] text-slate-500 uppercase font-black mb-1">Size</p>
                                        <p class="text-lg text-white font-mono leading-none">-- <span class="text-[10px] text-indigo-400">MB</span></p>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <button class="flex-1 bg-transparent hover:bg-red-900/20 text-slate-400 hover:text-red-400 text-[11px] font-bold py-2 rounded border border-slate-700 hover:border-red-900 transition-all uppercase tracking-widest">
                                        Delete
                                    </button>

                                    <a href="{{ route('albums.show', $album->id) }}" class="flex-[1.5] bg-indigo-600 hover:bg-indigo-500 text-white text-[11px] font-bold py-2 rounded transition-all shadow-lg shadow-indigo-900/40 uppercase tracking-widest text-center">
                                        Open Album
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </section>
            </main>

            @include('partials.pagination')

        </div>

    </div>

</body>

</html>