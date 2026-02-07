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
                            <div class="flex items-center space-x-2 text-[10px] font-mono text-slate-500 mb-4 uppercase tracking-widest">
                                <a href="{{ route('albums.index') }}" class="hover:text-ai-accent transition-colors">Albums</a>
                                <span class="text-slate-700">/</span>
                                <a href="{{ route('albums.show', $category->album_id) }}" class="hover:text-ai-accent transition-colors">{{ $category->album->album_name }}</a>
                                <span class="text-slate-700">/</span>
                                <span class="text-ai-accent border-b border-ai-accent/30 pb-0.5">{{ $category->category_name }}</span>
                            </div>

                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-1 bg-ai-accent shadow-[0_0_10px_var(--neon-primary)] rounded-full"></div>
                                    <h1 class="text-3xl font-light text-white tracking-tight">{{ $category->category_name }}</h1>
                                </div>
                                <p class="text-xs text-slate-500 mt-1 pl-4 border-l border-slate-800 ml-0.5">
                                    <span class="text-slate-400 font-mono uppercase text-[10px]">Sorting Rules:</span>
                                    {{ $category->ai_rules ?? 'Standard sorting' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-ai-accent hover:bg-indigo-500 text-white text-xs font-medium rounded shadow-[0_0_15px_-5px_rgba(99,102,241,0.5)] transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                                Edit Category
                            </a>
                            <a href="{{ route('download.folder', 'upload_sorted/'.$category->album->album_name . '/' . $category->category_name) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-medium rounded border border-slate-700 transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Download ZIP
                            </a>
                        </div>
                    </div>

                    <div class="h-px w-full bg-slate-800"></div>

                    <form action="{{ route('categories.show', $category->id) }}" method="GET">
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
                                        placeholder="Search in this category...">
                                </div>
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

                        @if(request()->anyFilled(['search', 'from', 'to']))
                        <div class="mt-2 text-right">
                            <a href="{{ route('categories.show', $category->id) }}" class="text-[10px] uppercase tracking-widest text-slate-500 hover:text-white transition-colors">Clear All Filters</a>
                        </div>
                        @endif
                    </form>

                </div>
            </section>

            <main class="flex-1 mb-10">
                <section class="bg-slate-950 mb-10">
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @forelse($files as $file)
                            <div class="group relative flex flex-col h-full bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-ai-accent/50 transition-all duration-300 hover:shadow-[0_0_20px_-5px_rgba(99,102,241,0.15)] hover:-translate-y-1">

                                <a href="{{ route('files.show', $file) }}" class="relative block w-full h-48 md:h-56 bg-slate-950 border-b border-slate-800/50 overflow-hidden shrink-0 cursor-pointer">
                                    <img src="{{ route('getFile', ['filePath' => $file->file_path]) }}"
                                        alt="{{ $file->file_name }}"
                                        class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100">

                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </a>

                                <div class="p-4 flex flex-col gap-2 flex-1 relative">
                                    <div class="flex justify-between items-start gap-2">
                                        <p class="text-sm font-medium text-slate-300 truncate w-full group-hover:text-white transition-colors" title="{{ $file->file_name }}">
                                            {{ $file->file_name }}
                                        </p>
                                        <div class="shrink-0 mt-1.5 h-1.5 w-1.5 rounded-full bg-slate-700 group-hover:bg-ai-accent group-hover:shadow-[0_0_5px_var(--neon-primary)] transition-all"></div>
                                    </div>

                                    <p class="text-[10px] text-slate-500 line-clamp-2 leading-relaxed">
                                        {{ $file->summary ?? 'AI processing pending...' }}
                                    </p>

                                    <div class="mt-auto pt-2 flex items-center justify-between border-t border-slate-800/50">
                                        <span class="text-[9px] text-slate-600 font-mono">{{ $file->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-full flex flex-col items-center justify-center py-16 px-4 border border-dashed border-slate-800 rounded-2xl bg-slate-900/50">
                                <div class="h-14 w-14 rounded-full bg-slate-800/50 flex items-center justify-center mb-4 ring-1 ring-slate-700/50">
                                    <svg class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-slate-400 font-medium text-sm">No files found</p>
                                @if(request()->anyFilled(['search', 'from', 'to']))
                                <p class="text-slate-600 text-xs mt-1">Try adjusting your filters.</p>
                                @else
                                <p class="text-slate-600 text-xs mt-1">This category is currently empty.</p>
                                @endif
                            </div>
                            @endforelse
                        </div>
                    </div>
                </section>
            </main>

            {{ $files->links('partials.pagination') }}

        </div>
    </div>
</body>

</html>