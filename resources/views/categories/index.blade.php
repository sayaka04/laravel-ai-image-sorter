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
                            <h1 class="text-2xl md:text-3xl font-light text-white tracking-tight">Categories</h1>
                            <p class="text-sm text-slate-500 mt-1">Categories are where the sorted images are sorted accordingly.</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">

                            <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-ai-accent hover:bg-indigo-500 text-white text-xs font-medium rounded shadow-[0_0_15px_-5px_rgba(99,102,241,0.5)] transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add New Category
                            </a>

                        </div>
                    </div>

                    <div class="h-px w-full bg-slate-800"></div>

                    <form action="{{ route('categories.index') }}" method="GET">
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
                                        placeholder="Search categories...">
                                </div>

                                <select name="album_id" onchange="this.form.submit()"
                                    class="w-full sm:w-auto bg-slate-900 border border-slate-800 focus:border-ai-accent text-slate-300 text-sm rounded block pl-3 pr-8 py-2 focus:outline-none transition-all cursor-pointer">
                                    <option value="">All Albums</option>
                                    @foreach($albums as $album)
                                    <option value="{{ $album->id }}" {{ request('album_id') == $album->id ? 'selected' : '' }}>
                                        {{ $album->album_name }}
                                    </option>
                                    @endforeach
                                </select>

                                @if(request()->anyFilled(['search', 'album_id']))
                                <a href="{{ route('categories.index') }}" class="text-slate-500 hover:text-white text-xs flex items-center px-2">Clear Filters</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <main class="flex-1 p-5">
                <section class="p-6 bg-slate-950">
                    <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-2xl">
                        <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-slate-950/50 border-b border-slate-800 text-[10px] font-mono uppercase text-slate-500 tracking-[0.2em]">
                            <div class="col-span-3">Category</div>
                            <div class="col-span-2">Attached Album</div>
                            <div class="col-span-5">AI Sorting Rules</div>
                            <div class="col-span-2 text-right">Actions</div>
                        </div>

                        @foreach($categories as $category)
                        <div class="grid grid-cols-12 gap-4 px-6 py-5 border-b border-slate-800/40 hover:bg-slate-800/20 transition-colors items-center">
                            <div class="col-span-3 flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-ai-accent/10 border border-ai-accent/30 flex items-center justify-center text-ai-accent font-bold text-sm shadow-sm">
                                    {{ strtoupper(substr($category->category_name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="text-slate-100 text-sm font-medium">{{ $category->category_name }}</h4>
                                    <p class="text-[9px] text-slate-600 font-mono uppercase">ID: {{ $category->id }}</p>
                                </div>
                            </div>

                            <div class="col-span-2">
                                <span class="text-xs text-slate-400 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                    {{ $category->album->album_name }}
                                </span>
                            </div>

                            <div class="col-span-5">
                                <div class="bg-slate-950/50 border border-slate-800/50 rounded-md px-4 py-2.5">
                                    <p class="text-[11px] text-slate-400 italic leading-relaxed truncate" title="{{ $category->ai_rules }}">
                                        "{{ $category->ai_rules ?? 'No specific rules set for this category.' }}"
                                    </p>
                                </div>
                            </div>

                            <div class="col-span-2 text-right">
                                <a href="{{ route('categories.show', $category) }}" class="inline-block px-5 py-1.5 bg-white hover:bg-slate-200 text-slate-900 rounded text-[10px] font-bold uppercase tracking-widest transition-all shadow-sm">
                                    Details
                                </a>
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