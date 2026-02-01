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
                            <h1 class="text-2xl md:text-3xl font-light text-white tracking-tight">Queues</h1>
                            <p class="text-sm text-slate-500 mt-1">This is the queue of images to be sorted</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">

                            <a href="{{ route('upload_queues.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-ai-accent hover:bg-indigo-500 text-white text-xs font-medium rounded shadow-[0_0_15px_-5px_rgba(99,102,241,0.5)] transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Upload to Queue
                            </a>

                            <a href="{{ route('albums.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-900 border border-slate-700 hover:border-slate-500 text-white text-xs font-medium rounded transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add New Album
                            </a>

                        </div>
                    </div>

                    <div class="h-px w-full bg-slate-800"></div>

                    <form action="{{ route('upload_queues.index') }}" method="GET">
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
                                        placeholder="Search filename...">
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

                                <select name="status" onchange="this.form.submit()"
                                    class="w-full sm:w-auto bg-slate-900 border border-slate-800 focus:border-ai-accent text-slate-300 text-sm rounded block pl-3 pr-8 py-2 focus:outline-none transition-all cursor-pointer">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="image_processing" {{ request('status') == 'image_processing' ? 'selected' : '' }}>Image Processing</option>
                                    <option value="final_processing" {{ request('status') == 'final_processing' ? 'selected' : '' }}>Final Processing</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>

                                @if(request()->anyFilled(['search', 'album_id', 'status']))
                                <a href="{{ route('upload_queues.index') }}" class="text-slate-500 hover:text-white text-xs flex items-center px-2">Clear Filters</a>
                                @endif
                            </div>

                            <button type="submit" class="hidden">Search</button>

                        </div>
                    </form>
                </div>
            </section>

            <main class="flex-1 p-5">
                <section class="p-6 bg-slate-950">



                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                        @foreach($queues as $queue)

                        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 flex flex-col items-center text-center space-y-5 shadow-lg">
                            <div class="w-full text-left">
                                <h4 class="text-white font-medium text-sm"> {{ $queue->original_filename }}</h4>
                                <p class="text-[11px] text-slate-500 font-mono mt-0.5 uppercase"> {{ Str::limit($queue->album->album_name, 25) }}</p>
                            </div>


                            @if($queue->status->value === 'pending')
                            <div class="relative h-24 w-24 flex items-center justify-center">
                                <svg class="w-full h-full -rotate-90">
                                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="6" fill="transparent" class="text-slate-950" />
                                </svg>
                                <span class="absolute text-lg font-bold text-white font-mono">0%</span>
                            </div>
                            @elseif($queue->status->value === 'image_processing')
                            <div class="relative h-24 w-24 flex items-center justify-center">
                                <svg class="w-full h-full -rotate-90">
                                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="6" fill="transparent" class="text-slate-950" />
                                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="6" fill="transparent"
                                        class="animate-spin origin-center text-ai-accent"
                                        stroke-dasharray="251.2"
                                        stroke-dashoffset="167.5" />
                                </svg>
                                <span class="absolute text-lg font-bold text-white font-mono">33%</span>
                            </div>
                            @elseif($queue->status->value === 'final_processing')
                            <div class="relative h-24 w-24 flex items-center justify-center">
                                <svg class="w-full h-full -rotate-90">
                                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="6" fill="transparent" class="text-slate-950" />
                                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="6" fill="transparent"
                                        class="animate-spin origin-center text-ai-accent"
                                        stroke-dasharray="251.2"
                                        stroke-dashoffset="83.7" />
                                </svg>
                                <span class="absolute text-lg font-bold text-white font-mono">67%</span>
                            </div>
                            @elseif($queue->status->value === 'completed')
                            <div class="relative h-24 w-24 flex items-center justify-center">
                                <svg class="w-full h-full -rotate-90">
                                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="6" fill="transparent" class="text-slate-950" />
                                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="6" fill="transparent"
                                        class="animate-pulse text-ai-accent"
                                        stroke-dasharray="251.2"
                                        stroke-dashoffset="0" />
                                </svg>
                                <span class="absolute text-lg font-bold text-white font-mono">100%</span>
                            </div>
                            @elseif($queue->status->value === 'failed')

                            @endif

                            <div class="flex items-center gap-4 text-[10px] font-mono text-slate-500 uppercase tracking-tighter">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.6)]"></div>
                                    {{ $queue->status }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <div class="w-2 h-2 rounded-full bg-slate-700"></div>
                                    {{ $queue->created_at->diffForHumans() }}
                                </div>
                            </div>

                            <button class="w-full py-2 bg-slate-800 hover:bg-red-900/30 text-slate-300 hover:text-red-200 border border-slate-700 hover:border-red-900/50 rounded-md text-[10px] font-bold uppercase tracking-widest transition-all">
                                Cancel
                            </button>
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