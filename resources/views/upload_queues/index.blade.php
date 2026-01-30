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

            <div class="flex justify-between h-18 items-center py-4">
                <div class="flex items-center gap-8">
                    <a href="{{ route('albums.index') }}" class="flex items-center gap-2 group">
                        <div class="bg-indigo-600 p-1.5 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <span class="text-slate-900 font-black text-xl tracking-tight">SmartSorter<span class="text-indigo-600">AI</span></span>
                    </a>
                </div>
                <a href="{{ route('upload_queues.create') }}" class="bg-slate-900 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-600 transition-all shadow-lg shadow-slate-200">
                    + Upload
                </a>
            </div>

            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="mb-10">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Active Queue</h1>
                    <p class="text-slate-500 mt-1">Images currently being processed by the AI engine.</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @forelse($queues as $queue)
                    <div class="group relative bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-xl">

                        <div class="aspect-square relative overflow-hidden bg-slate-100">
                            @if($queue->file_path)
                            <img src="{{ Storage::url($queue->file_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Queue Item">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path>
                                </svg>
                            </div>
                            @endif

                            @if($queue->status->value === 'pending')
                            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center">
                                <span class="bg-white/90 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-slate-900 shadow-xl">In Queue</span>
                            </div>
                            @elseif($queue->status->value === 'image_processing')
                            <div class="absolute inset-0 bg-indigo-600/20 backdrop-blur-[4px] flex flex-col items-center justify-center">
                                <div class="relative h-12 w-12">
                                    <svg class="animate-spin h-12 w-12 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <span class="mt-3 text-white text-[10px] font-black uppercase tracking-widest drop-shadow-md">AI Analyzing</span>
                            </div>
                            @elseif($queue->status->value === 'failed')
                            <div class="absolute inset-0 bg-rose-500/60 backdrop-blur-sm flex items-center justify-center">
                                <span class="bg-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-rose-600">Error</span>
                            </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h3 class="text-sm font-bold text-slate-900 truncate mb-1" title="{{ $queue->original_filename }}">
                                {{ $queue->original_filename }}
                            </h3>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">
                                    {{ $queue->created_at->diffForHumans(null, true) }}
                                </span>
                                <a href="{{ route('albums.show', $queue->album_id) }}" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 transition-colors uppercase tracking-tight">
                                    {{ Str::limit($queue->album->album_name, 12) }}
                                </a>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-50 flex justify-between items-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <a href="{{ route('upload_queues.edit', $queue) }}" class="text-xs font-bold text-slate-400 hover:text-slate-600">Edit</a>
                                <form action="{{ route('upload_queues.destroy', $queue) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-bold text-rose-400 hover:text-rose-600">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-20 bg-white rounded-[3rem] border-2 border-dashed border-slate-100 flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-slate-400 font-bold">No active uploads</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $queues->links() }}
                </div>
            </section>
        </main>

    </div>

</body>

</html>