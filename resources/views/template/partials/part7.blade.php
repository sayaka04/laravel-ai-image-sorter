<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h2 class="text-2xl font-bold text-white tracking-tight">Queues</h2>
        <div class="flex items-center gap-2">
            <button class="px-5 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-md text-[10px] font-bold uppercase tracking-wider border border-slate-700 transition-all">
                Add New Albums
            </button>
            <button class="px-5 py-2 bg-white hover:bg-slate-200 text-slate-900 rounded-md text-[10px] font-bold uppercase tracking-wider transition-all">
                Upload Unsorted Images
            </button>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <div class="relative">
            <input type="text" class="bg-slate-900 border border-slate-800 text-slate-200 text-xs rounded-md pl-9 pr-4 py-2.5 outline-none focus:border-ai-accent w-64" placeholder="Search">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-600">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
        </div>

        <div class="relative group">
            <select class="bg-slate-900 border border-slate-800 text-slate-300 text-[11px] rounded-md pl-4 pr-10 py-2.5 outline-none appearance-none cursor-pointer focus:border-ai-accent">
                <option>Filter by Album</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500 group-hover:text-white">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>

        <div class="relative group">
            <select class="bg-slate-900 border border-slate-800 text-slate-300 text-[11px] rounded-md pl-4 pr-10 py-2.5 outline-none appearance-none cursor-pointer focus:border-ai-accent">
                <option>Filter Status</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500 group-hover:text-white">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 flex flex-col items-center text-center space-y-5 shadow-lg">
            <div class="w-full text-left">
                <h4 class="text-white font-medium text-sm">image4.png</h4>
                <p class="text-[11px] text-slate-500 font-mono mt-0.5 uppercase">Album Name</p>
            </div>

            <div class="relative h-24 w-24 flex items-center justify-center">
                <svg class="w-full h-full -rotate-90">
                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="6" fill="transparent" class="text-slate-950" />
                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="6" fill="transparent"
                        class="text-ai-accent"
                        stroke-dasharray="251.2"
                        stroke-dashoffset="62.8" />
                </svg>
                <span class="absolute text-lg font-bold text-white font-mono">75%</span>
            </div>

            <div class="flex items-center gap-4 text-[10px] font-mono text-slate-500 uppercase tracking-tighter">
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.6)]"></div>
                    Status
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-slate-700"></div>
                    Date & Time
                </div>
            </div>

            <button class="w-full py-2 bg-slate-800 hover:bg-red-900/30 text-slate-300 hover:text-red-200 border border-slate-700 hover:border-red-900/50 rounded-md text-[10px] font-bold uppercase tracking-widest transition-all">
                Cancel
            </button>
        </div>

    </div>

    <div class="flex items-center justify-center gap-2 pt-6">
        <button class="w-9 h-9 flex items-center justify-center rounded-md border border-slate-800 text-slate-500 hover:bg-slate-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button class="w-9 h-9 flex items-center justify-center rounded-md bg-white text-slate-900 text-xs font-bold">1</button>
        <button class="w-9 h-9 flex items-center justify-center rounded-md border border-slate-800 text-slate-400 text-xs font-medium hover:bg-slate-800 transition-colors">2</button>
        <button class="w-9 h-9 flex items-center justify-center rounded-md border border-slate-800 text-slate-400 text-xs font-medium hover:bg-slate-800 transition-colors">3</button>
        <span class="text-slate-700 font-bold px-1">...</span>
        <button class="w-9 h-9 flex items-center justify-center rounded-md border border-slate-800 text-slate-400 text-xs font-medium hover:bg-slate-800 transition-colors">8</button>
        <button class="w-9 h-9 flex items-center justify-center rounded-md border border-slate-800 text-slate-500 hover:bg-slate-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>
</div>