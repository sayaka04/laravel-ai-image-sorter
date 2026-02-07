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

        <main class="flex-1 p-5 overflow-y-auto mb-10">

            <section class="bg-slate-950">
                <div class="w-full flex flex-col gap-6">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <div class="lg:col-span-2 relative group overflow-hidden rounded-2xl bg-slate-900 border border-slate-800 p-6 hover:border-ai-accent/30 transition-all duration-500">
                            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>

                            <div class="relative z-10 flex flex-col justify-between h-full gap-4">
                                <div class="flex justify-between items-end">
                                    <div>
                                        <h3 class="text-white font-medium text-lg tracking-tight flex items-center gap-2">
                                            <svg class="w-5 h-5 text-ai-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            Storage Usage
                                        </h3>
                                        <p class="text-[11px] text-slate-400 font-mono uppercase tracking-widest mt-1">Storage Limit: <span class="text-white font-bold">{{ $max_storage_mb }} MB</span></p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-3xl font-mono font-light text-white">{{ $folderSize['size_human'] }} <span class="text-sm text-slate-500 font-bold">Used</span></span>
                                    </div>
                                </div>

                                <div class="relative w-full">
                                    <div class="relative w-full z-10">
                                        <div class="animate-pulse h-10 w-full bg-slate-950 rounded-lg border border-slate-700 p-1">

                                            <div class="h-full rounded-md bg-emerald-500 relative flex items-center justify-end overflow-hidden transition-all duration-1000"
                                                style="width: {{$percent_used}}%; background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(0,0,0,0.1) 10px, rgba(0,0,0,0.1) 20px);">

                                                <span class="mr-3 text-slate-900 font-bold font-mono text-xs tracking-wider opacity-80">{{ $percent_used }}% USED</span>

                                                <div class="absolute right-0 top-0 bottom-0 w-1 bg-white shadow-[0_0_20px_white]"></div>
                                            </div>

                                        </div>

                                        <div class="flex justify-between mt-1 px-1">
                                            <div class="w-px h-2 bg-slate-800"></div>
                                            <div class="w-px h-2 bg-slate-800"></div>
                                            <div class="w-px h-2 bg-slate-800"></div>
                                            <div class="w-px h-2 bg-slate-800"></div>
                                            <div class="w-px h-2 bg-slate-800"></div>
                                            <div class="w-px h-2 bg-slate-800"></div>
                                            <div class="w-px h-2 bg-slate-800"></div>
                                            <div class="w-px h-2 bg-slate-800"></div>
                                            <div class="w-px h-2 bg-slate-800"></div>
                                            <div class="w-px h-2 bg-slate-800"></div>
                                            <div class="w-px h-2 bg-slate-800"></div>
                                        </div>
                                    </div>

                                    <div class="flex justify-between mt-2 text-[10px] font-mono font-bold uppercase text-slate-500">
                                        <span>0 MB</span>
                                        <span class="text-ai-accent">{{ $percent_used }}% Used | {{ $folderSize['size_human'] }}</span>
                                        <span>{{ $max_storage_mb }} MB (Max)</span>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative rounded-2xl bg-slate-900 border border-slate-800 p-6 flex flex-col justify-center items-center text-center hover:border-slate-600 transition-colors">
                            <h3 class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em] mb-2">Total Files</h3>
                            <div class="text-5xl font-mono font-light text-white tracking-tighter">
                                {{ number_format($folderSize['total_files']) }}
                            </div>
                            <p class="text-[10px] text-ai-accent mt-3 font-mono flex items-center gap-1 bg-ai-accent/10 px-2 py-1 rounded border border-ai-accent/20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                </svg>
                                Files Stored
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-slate-950/50 border border-slate-800 rounded-xl p-4 flex items-center justify-between group hover:border-ai-accent/30 transition-all">
                            <div>
                                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Active Queues</p>
                                <p class="text-xl text-white font-mono mt-0.5 group-hover:text-ai-accent transition-colors">{{ $queues_count }}</p>
                            </div>
                            <div class="h-8 w-8 rounded bg-slate-900 border border-slate-800 flex items-center justify-center text-ai-accent">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-ai-accent opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-ai-accent"></span>
                                </span>
                            </div>
                        </div>

                        <div class="bg-slate-950/50 border border-slate-800 rounded-xl p-4 flex items-center justify-between group hover:border-slate-700 transition-all">
                            <div>
                                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Albums</p>
                                <p class="text-xl text-white font-mono mt-0.5">{{ $albums_count }}</p>
                            </div>
                            <div class="h-8 w-8 rounded bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-600 group-hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-slate-950/50 border border-slate-800 rounded-xl p-4 flex items-center justify-between group hover:border-slate-700 transition-all">
                            <div>
                                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Categories</p>
                                <p class="text-xl text-white font-mono mt-0.5">{{ $categories_count }}</p>
                            </div>
                            <div class="h-8 w-8 rounded bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-600 group-hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-slate-950/50 border border-slate-800 rounded-xl p-4 flex items-center justify-between group hover:border-slate-700 transition-all">
                            <div>
                                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Sorted Files</p>
                                <p class="text-xl text-white font-mono mt-0.5">{{ $files_count }}</p>
                            </div>
                            <div class="h-8 w-8 rounded bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-600 group-hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                        </div>

                    </div>



                    <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden flex flex-col shadow-2xl">
                        <div class="p-5 border-b border-slate-800 bg-slate-950/30 flex justify-between items-center">
                            <div>
                                <h3 class="text-white font-medium text-sm uppercase tracking-wider flex items-center gap-2">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-ai-accent opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-ai-accent"></span>
                                    </span>
                                    Live Processing Queue
                                </h3>
                            </div>
                            <button class="text-[10px] font-bold uppercase text-slate-500 hover:text-white transition-colors bg-slate-800 px-3 py-1 rounded hover:bg-slate-700">View Full Log</button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-[10px] uppercase text-slate-500 font-mono bg-slate-950/50 border-b border-slate-800">
                                        <th class="px-6 py-3 font-medium tracking-wider w-[40%]">File Input</th>
                                        <th class="px-6 py-3 font-medium tracking-wider w-[40%]">Status</th>
                                        <th class="px-6 py-3 font-medium tracking-wider text-right w-[20%]">Time</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-slate-800">
                                    @foreach($queues->take(3) as $queue)
                                    <tr class="group hover:bg-slate-800/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-500">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <span class="font-mono text-xs text-slate-300">{{ $queue->original_filename}}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($queue->status === \App\Enums\UploadStatus::IMAGE_PROCESSING)
                                            <div class="flex flex-col gap-1.5">
                                                <div class="flex items-center gap-2">
                                                    <svg class="animate-spin h-3 w-3 text-ai-accent" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    <span class="text-[10px] font-bold uppercase tracking-wider text-ai-accent animate-pulse">Image Processing</span>
                                                </div>
                                                <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden">
                                                    <div class="h-full bg-ai-accent w-[33%] shadow-[0_0_10px_var(--neon-primary)]"></div>
                                                </div>
                                            </div>
                                            @elseif($queue->status === \App\Enums\UploadStatus::FINAL_PROCESSING)
                                            <div class="flex flex-col gap-1.5">
                                                <div class="flex items-center gap-2">
                                                    <svg class="animate-spin h-3 w-3 text-ai-accent" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    <span class="text-[10px] font-bold uppercase tracking-wider text-ai-accent animate-pulse">Final Processing</span>
                                                </div>
                                                <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden">
                                                    <div class="h-full bg-ai-accent w-[67%] shadow-[0_0_10px_var(--neon-primary)]"></div>
                                                </div>
                                            </div>
                                            {{$queue->status}}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="font-mono text-xs text-slate-400">{{ $queue->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                @if($queues->count() > 3)
                                <tfoot class="border-t border-slate-800 bg-slate-950/80 cursor-pointer hover:bg-slate-900 transition-colors">
                                    <tr>
                                        <td colspan="3" class="px-6 py-3 text-center">
                                            <div class="flex items-center justify-center gap-2 text-xs text-slate-400 font-mono">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-slate-500 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-slate-500"></span>
                                                </span>
                                                <span class="font-bold text-white">+ {{ $queues->count() - 3 }} More Files</span>
                                                <span class="opacity-70">waiting in queue...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </section>

        </main>
        <br><br>

    </div>

</body>

</html>