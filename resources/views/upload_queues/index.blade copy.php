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

        <main class="flex-1 overflow-y-auto bg-slate-50/50">
            <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-10 border-b border-slate-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-18 items-center py-4">
                        <div class="flex items-center gap-8">
                            <a href="{{ route('albums.index') }}" class="flex items-center gap-2 group">
                                <div class="bg-indigo-600 p-1.5 rounded-lg transition-transform group-hover:scale-110">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <span class="text-slate-900 font-black text-xl tracking-tight">SmartSorter<span class="text-indigo-600">AI</span></span>
                            </a>
                            <div class="hidden md:flex items-center bg-slate-100 p-1 rounded-xl">
                                <a href="{{ route('albums.index') }}" class="px-4 py-1.5 text-sm font-medium text-slate-500 hover:text-slate-900 transition-all">Albums</a>
                                <a href="#" class="px-4 py-1.5 text-sm font-bold bg-white text-indigo-600 shadow-sm rounded-lg">Queue</a>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <button class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v1m6 0H9"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Processing Queue</h1>
                        <p class="text-slate-500 mt-2">Monitor AI analysis and file organization in real-time.</p>
                    </div>
                    <a href="{{ route('upload_queues.create') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Upload New File
                    </a>
                </div>

                @if(session('message'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-bold">{{ session('message') }}</span>
                </div>
                @endif

                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100">
                                    <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">File Details</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Target Album</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">AI Status</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Added</th>
                                    <th class="px-8 py-5 text-right text-xs font-bold text-slate-400 uppercase tracking-widest">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($queues as $queue)
                                <tr class="group hover:bg-slate-50/80 transition-colors duration-150">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 mr-4 group-hover:bg-white group-hover:shadow-sm transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-900">{{ $queue->original_filename }}</div>
                                                <div class="text-xs text-slate-400 mt-0.5 font-medium">{{ Str::limit($queue->file_path, 35) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <a href="{{ route('albums.show', $queue->album_id) }}" class="inline-flex items-center px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold hover:bg-indigo-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                                            </svg>
                                            {{ $queue->album->album_name }}
                                        </a>
                                    </td>
                                    <td class="px-8 py-6">
                                        @if($queue->status->value === 'PENDING')
                                        <span class="flex items-center text-xs font-bold text-amber-600">
                                            <span class="h-2 w-2 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                                            In Queue
                                        </span>
                                        @elseif($queue->status->value === 'PROCESSING')
                                        <span class="flex items-center text-xs font-bold text-blue-600">
                                            <svg class="animate-spin -ml-1 mr-2 h-3 w-3 text-blue-600" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Analyzing...
                                        </span>
                                        @else
                                        <span class="flex items-center text-xs font-bold text-rose-600">
                                            <span class="h-2 w-2 rounded-full bg-rose-500 mr-2"></span>
                                            Failed
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 text-sm font-medium text-slate-500 uppercase text-[10px] tracking-tight">
                                        {{ $queue->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('upload_queues.edit', $queue) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('upload_queues.destroy', $queue) }}" method="POST" class="inline-block" onsubmit="return confirm('Cancel this upload?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-300 mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 font-medium">Your processing queue is clear.</p>
                                        <a href="{{ route('upload_queues.create') }}" class="mt-4 inline-block text-sm font-bold text-indigo-600 hover:text-indigo-700">Upload something now &rarr;</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-8">
                    {{ $queues->links() }}
                </div>
            </section>
        </main>

        <main class="flex-1 overflow-y-auto bg-slate-50/50">
            <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-10 border-b border-slate-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                </div>
            </nav>

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

                            @if($queue->status->value === 'PENDING')
                            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center">
                                <span class="bg-white/90 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-slate-900 shadow-xl">In Queue</span>
                            </div>
                            @elseif($queue->status->value === 'PROCESSING')
                            <div class="absolute inset-0 bg-indigo-600/20 backdrop-blur-[4px] flex flex-col items-center justify-center">
                                <div class="relative h-12 w-12">
                                    <svg class="animate-spin h-12 w-12 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <span class="mt-3 text-white text-[10px] font-black uppercase tracking-widest drop-shadow-md">AI Analyzing</span>
                            </div>
                            @elseif($queue->status->value === 'FAILED')
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