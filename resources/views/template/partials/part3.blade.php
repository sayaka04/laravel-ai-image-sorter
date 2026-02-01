<div class="mt-6 w-full bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-sm">

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-800 text-left">

            <thead class="bg-slate-950/50 text-xs uppercase font-mono text-slate-500 font-medium tracking-wider">
                <tr>
                    <th scope="col" class="px-6 py-4 w-[40%] min-w-[200px]">File Details</th>
                    <th scope="col" class="px-6 py-4 w-[30%] min-w-[200px]">AI Progress</th>
                    <th scope="col" class="px-6 py-4 hidden md:table-cell whitespace-nowrap">Status</th>
                    <th scope="col" class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-800 bg-slate-900 text-sm">

                <tr class="group hover:bg-slate-800/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded bg-slate-800 border border-slate-700 flex items-center justify-center shrink-0 text-slate-400 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-medium text-white truncate max-w-[150px] sm:max-w-xs">image_dump_004.png</div>
                                <div class="text-xs text-ai-accent font-mono mt-0.5">Target: January Album</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 align-middle">
                        <div class="w-full max-w-xs">
                            <div class="flex justify-between mb-1.5">
                                <span class="text-[10px] font-mono text-slate-400 uppercase tracking-tight">Analyzing Content...</span>
                                <span class="text-[10px] font-mono text-white">75%</span>
                            </div>
                            <div class="w-full bg-slate-950 rounded-full h-1.5 border border-slate-800 overflow-hidden">
                                <div class="bg-ai-accent h-1.5 rounded-full animate-[pulse_2s_cubic-bezier(0.4,0,0.6,1)_infinite]" style="width: 75%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell align-middle">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 animate-bounce">
                            Processing
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right align-middle whitespace-nowrap">
                        <button class="text-slate-500 hover:text-red-400 transition-colors text-xs font-bold font-mono uppercase tracking-wide px-2 py-1 hover:bg-slate-800 rounded">
                            Cancel
                        </button>
                    </td>
                </tr>

                <tr class="group hover:bg-slate-800/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded bg-slate-800 border border-slate-700 flex items-center justify-center shrink-0 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-medium text-white truncate max-w-[150px] sm:max-w-xs">scan_receipt_99.jpg</div>
                                <div class="text-xs text-slate-500 font-mono mt-0.5">Target: Expenses</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 align-middle">
                        <div class="w-full max-w-xs">
                            <div class="flex justify-between mb-1.5">
                                <span class="text-[10px] font-mono text-slate-600 uppercase tracking-tight">Waiting in queue</span>
                                <span class="text-[10px] font-mono text-slate-600">0%</span>
                            </div>
                            <div class="w-full bg-slate-950 rounded-full h-1.5 border border-slate-800">
                                <div class="bg-slate-700 h-1.5 rounded-full" style="width: 0%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell align-middle">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-slate-800 text-slate-400 border border-slate-700">
                            Pending
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right align-middle whitespace-nowrap">
                        <button class="text-slate-500 hover:text-red-400 transition-colors text-xs font-bold font-mono uppercase tracking-wide px-2 py-1 hover:bg-slate-800 rounded">
                            Cancel
                        </button>
                    </td>
                </tr>

                <tr class="group hover:bg-slate-800/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded bg-slate-800 border border-slate-700 flex items-center justify-center shrink-0 text-slate-400 group-hover:text-emerald-400 group-hover:border-emerald-500/30 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-medium text-white truncate max-w-[150px] sm:max-w-xs">avatar_new.png</div>
                                <div class="text-xs text-slate-500 font-mono mt-0.5">Target: Profile Pics</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 align-middle">
                        <div class="w-full max-w-xs">
                            <div class="flex justify-between mb-1.5">
                                <span class="text-[10px] font-mono text-emerald-500 uppercase tracking-tight">Complete</span>
                                <span class="text-[10px] font-mono text-emerald-500">100%</span>
                            </div>
                            <div class="w-full bg-slate-950 rounded-full h-1.5 border border-slate-800">
                                <div class="bg-emerald-500 h-1.5 rounded-full shadow-[0_0_10px_-2px_rgba(16,185,129,0.5)]" style="width: 100%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell align-middle">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            Done
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right align-middle whitespace-nowrap">
                        <button class="text-slate-500 hover:text-white transition-colors text-xs font-bold font-mono uppercase tracking-wide px-2 py-1 hover:bg-slate-800 rounded">
                            Archive
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>