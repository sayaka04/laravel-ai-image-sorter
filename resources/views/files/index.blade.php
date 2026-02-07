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
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-1 bg-ai-accent shadow-[0_0_10px_var(--neon-primary)] rounded-full"></div>
                                <h1 class="text-3xl font-light text-white tracking-tight">Files</h1>
                            </div>
                            <p class="text-sm text-slate-500 mt-1">This is the list of all your image files along with their album associations.</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">

                            <a href="{{ route('albums.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-ai-accent hover:bg-indigo-500 text-white text-xs font-medium rounded shadow-[0_0_15px_-5px_rgba(99,102,241,0.5)] transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add New Album
                            </a>
                        </div>
                    </div>

                    <div class="h-px w-full bg-slate-800"></div>

                    <form action="{{ route('files.index') }}" method="GET">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">

                                <div class="relative group w-full sm:w-64">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-slate-600 group-focus-within:text-ai-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="w-full bg-slate-900 border border-slate-800 focus:border-ai-accent text-slate-300 text-sm rounded block pl-10 py-2 placeholder-slate-600 transition-all focus:outline-none"
                                        placeholder="Search files...">
                                </div>

                                <select name="album_id" onchange="this.form.submit()"
                                    class="w-full sm:w-auto bg-slate-900 border border-slate-800 focus:border-ai-accent text-slate-300 text-sm rounded block pl-3 pr-8 py-2 focus:outline-none cursor-pointer">
                                    <option value="">All Albums</option>
                                    @foreach($albums as $album)
                                    <option value="{{ $album->id }}" {{ request('album_id') == $album->id ? 'selected' : '' }}>
                                        {{ $album->album_name }}
                                    </option>
                                    @endforeach
                                </select>

                                <select name="category_id" onchange="this.form.submit()"
                                    class="w-full sm:w-auto bg-slate-900 border border-slate-800 focus:border-ai-accent text-slate-300 text-sm rounded block pl-3 pr-8 py-2 focus:outline-none cursor-pointer">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                <div class="relative w-full sm:w-auto">
                                    <label class="absolute -top-2 left-2 bg-slate-950 px-1 text-[10px] text-slate-500 font-mono">FROM</label>
                                    <input type="date" name="from" value="{{ request('from') }}"
                                        class="w-full sm:w-auto bg-slate-900 border border-slate-800 text-slate-300 text-xs rounded px-3 py-2 font-mono focus:border-ai-accent focus:outline-none">
                                </div>
                                <span class="text-slate-600">-</span>
                                <div class="relative w-full sm:w-auto">
                                    <label class="absolute -top-2 left-2 bg-slate-950 px-1 text-[10px] text-slate-500 font-mono">TO</label>
                                    <input type="date" name="to" value="{{ request('to') }}"
                                        class="w-full sm:w-auto bg-slate-900 border border-slate-800 text-slate-300 text-xs rounded px-3 py-2 font-mono focus:border-ai-accent focus:outline-none">
                                </div>
                                <button type="submit" class="bg-slate-800 p-2 rounded hover:bg-slate-700 transition-colors">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @if(request()->anyFilled(['search', 'album_id', 'category_id', 'from', 'to']))
                        <div class="mt-2 text-right">
                            <a href="{{ route('files.index') }}" class="text-[10px] uppercase tracking-widest text-slate-500 hover:text-white transition-colors">Clear All Filters</a>
                        </div>
                        @endif
                    </form>
                </div>
            </section>

            <main class="flex-1 mb-10">
                <section class="bg-slate-950 mb-10">

                    <div class="space-y-6">

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($files as $file)
                            <div class="group bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-slate-700 transition-all">
                                <div class="aspect-video bg-slate-950 flex items-center justify-center relative overflow-hidden">

                                    {{-- REPLACEMENT START: Replaced SVG icon with Image tag --}}

                                    <a href="{{ route('files.show', $file) }}" class="block w-full h-full">
                                        <img
                                            src="{{ route('getFile', ['filePath' => $file->file_path]) }}"
                                            alt="{{ $file->file_name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </a>

                                    {{-- REPLACEMENT END --}}

                                    <div class="absolute top-2 right-2 px-2 py-1 bg-slate-900/80 backdrop-blur-md rounded text-[9px] font-mono text-slate-400 border border-slate-800 uppercase">
                                        {{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}
                                    </div>
                                </div>

                                <div class="p-4 space-y-3">
                                    <div>
                                        <h4 class="text-slate-200 text-sm font-medium truncate">{{ $file->file_name }}</h4>
                                        <p class="text-[10px] text-slate-500 font-mono mt-1 uppercase tracking-tight">Album: {{ $file->category->album->album_name }}</p>
                                    </div>

                                    <div class="flex items-center justify-between pt-2 border-t border-slate-800/50">
                                        <span class="text-[10px] text-ai-accent font-bold uppercase tracking-widest">{{ $file->category->category_name}}</span>
                                        <span class="text-[9px] text-slate-600 font-mono">{{ $file->created_at->diffForHumans() }}</span>
                                    </div>

                                    <div class="flex gap-2 pt-1">
                                        <a
                                            href="{{ route('getFile', ['filePath' => $file->file_path]) }}"
                                            download="{{ $file->file_name }}"
                                            class="flex-1 py-2 bg-white hover:bg-slate-200 text-slate-900 rounded text-[10px] font-bold uppercase tracking-tighter transition-all text-center">
                                            Download
                                        </a>


                                        <form action="{{ route('files.destroy', $file) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this? This cannot be undone.')"
                                                class="w-full py-2 bg-slate-800 hover:bg-red-900/40 text-slate-300 hover:text-red-200 rounded text-[10px] font-bold uppercase tracking-tighter transition-all text-center">
                                                Delete
                                            </button>
                                        </form>


                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </section>
            </main>

            {{ $files->links('partials.pagination') }}

        </div>

    </div>

</body>

</html>