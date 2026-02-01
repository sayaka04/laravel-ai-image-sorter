<div class="space-y-6">
    <div class="flex flex-wrap items-center gap-3 bg-slate-900/50 p-4 rounded-xl border border-slate-800">
        <div class="relative flex-1 min-w-[200px]">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-xs rounded-md pl-10 pr-4 py-2.5 outline-none focus:border-ai-accent" placeholder="Search files...">
        </div>

        <div class="relative group">
            <select class="bg-slate-950 border border-slate-800 text-slate-300 text-[11px] rounded-md pl-4 pr-10 py-2.5 outline-none appearance-none cursor-pointer focus:border-ai-accent">
                <option>Filter by Album</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>

        <div class="relative group">
            <select class="bg-slate-950 border border-slate-800 text-slate-300 text-[11px] rounded-md pl-4 pr-10 py-2.5 outline-none appearance-none cursor-pointer focus:border-ai-accent">
                <option>Category</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>

        <div class="flex items-center bg-slate-950 border border-slate-800 rounded-md px-2">
            <input type="text" class="bg-transparent text-[11px] text-slate-400 w-20 py-2.5 outline-none text-center" placeholder="From">
            <span class="text-slate-700 px-1">/</span>
            <input type="text" class="bg-transparent text-[11px] text-slate-400 w-20 py-2.5 outline-none text-center" placeholder="To">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="group bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-slate-700 transition-all">
            <div class="aspect-video bg-slate-950 flex items-center justify-center relative overflow-hidden">
                <div class="text-slate-800 group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="absolute top-2 right-2 px-2 py-1 bg-slate-900/80 backdrop-blur-md rounded text-[9px] font-mono text-slate-400 border border-slate-800 uppercase">PNG</div>
            </div>

            <div class="p-4 space-y-3">
                <div>
                    <h4 class="text-slate-200 text-sm font-medium truncate">IMG_2025_001.png</h4>
                    <p class="text-[10px] text-slate-500 font-mono mt-1 uppercase tracking-tight">Album: January Dump</p>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-slate-800/50">
                    <span class="text-[10px] text-ai-accent font-bold uppercase tracking-widest">Receipts</span>
                    <span class="text-[9px] text-slate-600 font-mono">2025-01-24</span>
                </div>

                <div class="flex gap-2 pt-1">
                    <button class="flex-1 py-2 bg-white hover:bg-slate-200 text-slate-900 rounded text-[10px] font-bold uppercase tracking-tighter transition-all">
                        View
                    </button>
                    <button class="flex-1 py-2 bg-slate-800 hover:bg-red-900/40 text-slate-300 hover:text-red-200 rounded text-[10px] font-bold uppercase tracking-tighter transition-all">
                        Delete
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="space-y-6">
    <div class="flex flex-wrap items-center gap-4 bg-slate-900/50 p-4 rounded-xl border border-slate-800">
        <div class="relative flex-1 min-w-[240px]">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-xs rounded-md pl-10 pr-4 py-2.5 outline-none focus:border-ai-accent" placeholder="Search files...">
        </div>

        <div class="relative group min-w-[160px]">
            <select class="w-full bg-slate-950 border border-slate-800 text-slate-300 text-[11px] rounded-md px-4 py-2.5 outline-none appearance-none cursor-pointer focus:border-ai-accent">
                <option>Filter by Album</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500 group-hover:text-white">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>

        <div class="relative group min-w-[140px]">
            <select class="w-full bg-slate-950 border border-slate-800 text-slate-300 text-[11px] rounded-md px-4 py-2.5 outline-none appearance-none cursor-pointer focus:border-ai-accent">
                <option>Category</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500 group-hover:text-white">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>

        <div class="flex items-center bg-slate-950 border border-slate-800 rounded-md px-1">
            <input type="text" class="bg-transparent text-[11px] text-slate-400 w-20 py-2.5 outline-none text-center" placeholder="From">
            <span class="text-slate-800 font-bold px-1">/</span>
            <input type="text" class="bg-transparent text-[11px] text-slate-400 w-20 py-2.5 outline-none text-center" placeholder="To">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-sm hover:border-slate-700 transition-colors">
            <div class="aspect-video bg-slate-950 flex items-center justify-center relative border-b border-slate-800/50">
                <div class="text-slate-800">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="absolute top-3 left-3 px-2 py-0.5 bg-black/40 backdrop-blur-md border border-white/10 rounded text-[9px] font-mono text-slate-300 uppercase">PNG</div>
            </div>

            <div class="p-5 space-y-4">
                <div class="flex justify-between items-start">
                    <div class="max-w-[70%]">
                        <h4 class="text-slate-100 text-sm font-medium truncate">receipt_001.png</h4>
                        <p class="text-[10px] text-slate-500 font-mono mt-0.5 uppercase tracking-tight truncate">Album: January Dump</p>
                    </div>
                    <span class="px-2 py-1 bg-indigo-500/10 border border-indigo-500/30 rounded text-[10px] font-bold text-indigo-400 uppercase tracking-wider shadow-sm shadow-indigo-500/5">
                        Receipt
                    </span>
                </div>

                <div class="flex items-center justify-between text-[10px] font-mono text-slate-600 border-t border-slate-800/50 pt-3">
                    <span>2.4 MB</span>
                    <span>2025-01-24</span>
                </div>

                <div class="flex gap-2">
                    <button class="flex-1 py-2 bg-white hover:bg-slate-200 text-slate-900 rounded text-[10px] font-bold uppercase tracking-widest transition-all">
                        View
                    </button>
                    <button class="flex-1 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[10px] font-bold uppercase tracking-widest transition-all">
                        Delete
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>