<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Categories</h2>
            <p class="text-[11px] text-slate-500 font-mono uppercase mt-1">AI Logic & Destination Management</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative">
                <input type="text" class="bg-slate-900 border border-slate-800 text-slate-200 text-xs rounded-md pl-9 pr-4 py-2.5 outline-none focus:border-ai-accent w-64" placeholder="Search Categories...">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
            </div>

            <div class="relative group">
                <select class="bg-slate-900 border border-slate-800 text-slate-400 text-[11px] font-bold uppercase tracking-wider rounded-md pl-4 pr-10 py-2.5 outline-none appearance-none cursor-pointer focus:border-ai-accent">
                    <option>Filter by Album</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500 group-hover:text-white transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-2xl">
        <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-slate-950/50 border-b border-slate-800 text-[10px] font-mono uppercase text-slate-500 tracking-[0.2em]">
            <div class="col-span-3">Category</div>
            <div class="col-span-2">Attached Album</div>
            <div class="col-span-5">AI Sorting Rules</div>
            <div class="col-span-2 text-right">Actions</div>
        </div>

        <div class="grid grid-cols-12 gap-4 px-6 py-5 border-b border-slate-800/40 hover:bg-slate-800/20 transition-colors items-center">
            <div class="col-span-3 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-indigo-500/10 border border-indigo-500/30 flex items-center justify-center text-indigo-400 font-bold text-sm shadow-sm">S</div>
                <div>
                    <h4 class="text-slate-100 text-sm font-medium">Screenshots</h4>
                    <p class="text-[9px] text-slate-600 font-mono uppercase">ID: 4X8K</p>
                </div>
            </div>
            <div class="col-span-2">
                <span class="text-xs text-slate-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    January
                </span>
            </div>
            <div class="col-span-5">
                <div class="bg-slate-950/50 border border-slate-800/50 rounded-md px-4 py-2.5">
                    <p class="text-[11px] text-slate-400 italic leading-relaxed truncate">"if it is a phone screenshot or clearly a screenshot or print screen"</p>
                </div>
            </div>
            <div class="col-span-2 text-right">
                <button class="px-5 py-1.5 bg-white hover:bg-slate-200 text-slate-900 rounded text-[10px] font-bold uppercase tracking-widest transition-all shadow-sm">
                    Details
                </button>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 px-6 py-5 border-b border-slate-800/40 hover:bg-slate-800/20 transition-colors items-center">
            <div class="col-span-3 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-bold text-sm shadow-sm">A</div>
                <div>
                    <h4 class="text-slate-100 text-sm font-medium">Animals</h4>
                    <p class="text-[9px] text-slate-600 font-mono uppercase">ID: 9L3Z</p>
                </div>
            </div>
            <div class="col-span-2">
                <span class="text-xs text-slate-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    January
                </span>
            </div>
            <div class="col-span-5">
                <div class="bg-slate-950/50 border border-slate-800/50 rounded-md px-4 py-2.5">
                    <p class="text-[11px] text-slate-400 italic leading-relaxed truncate">"if its realistic or truly just animal spoken as a fact, (more drawings)"</p>
                </div>
            </div>
            <div class="col-span-2 text-right">
                <button class="px-5 py-1.5 bg-white hover:bg-slate-200 text-slate-900 rounded text-[10px] font-bold uppercase tracking-widest transition-all shadow-sm">
                    Details
                </button>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-center gap-2 pt-4">
        <button class="w-8 h-8 flex items-center justify-center rounded border border-slate-800 text-slate-500 hover:bg-slate-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button class="w-8 h-8 flex items-center justify-center rounded bg-ai-accent text-white text-xs font-bold shadow-lg shadow-ai-accent/20">1</button>
        <button class="w-8 h-8 flex items-center justify-center rounded border border-slate-800 text-slate-400 text-xs font-medium hover:bg-slate-800 transition-colors">2</button>
        <button class="w-8 h-8 flex items-center justify-center rounded border border-slate-800 text-slate-400 text-xs font-medium hover:bg-slate-800 transition-colors">3</button>
        <span class="text-slate-700 px-2 font-bold">...</span>
        <button class="w-8 h-8 flex items-center justify-center rounded border border-slate-800 text-slate-400 text-xs font-medium hover:bg-slate-800 transition-colors">8</button>
        <button class="w-8 h-8 flex items-center justify-center rounded border border-slate-800 text-slate-500 hover:bg-slate-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>
</div>