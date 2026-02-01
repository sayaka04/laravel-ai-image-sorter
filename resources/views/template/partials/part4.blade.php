<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xs font-mono uppercase tracking-[0.2em] text-slate-500 font-bold">System Configuration</h2>
        <div class="h-px flex-1 bg-slate-800 ml-4"></div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-800 bg-slate-950/30">
                <h3 class="text-white font-medium">Create New Album</h3>
                <p class="text-[11px] text-slate-500 font-mono mt-1 uppercase">Initialize Storage Collection</p>
            </div>

            <div class="p-6 space-y-5 flex-1">
                <div>
                    <label class="block text-[10px] uppercase font-mono text-slate-500 font-bold mb-2 tracking-wider">Album Name</label>
                    <input type="text" class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-md px-4 py-2.5 focus:border-ai-accent outline-none" placeholder="e.g. January Screenshots">
                </div>

                <div>
                    <label class="block text-[10px] uppercase font-mono text-slate-500 font-bold mb-2 tracking-wider">Description</label>
                    <textarea rows="4" class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-md px-4 py-2.5 focus:border-slate-600 outline-none resize-none" placeholder="Content about the album..."></textarea>
                </div>
            </div>

            <div class="p-6 bg-slate-950/50 border-t border-slate-800 flex justify-center">
                <button class="px-8 py-2.5 bg-white hover:bg-slate-200 text-slate-900 rounded-md text-xs font-bold uppercase tracking-widest transition-all shadow-sm">
                    Confirm Album
                </button>
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-800 bg-slate-950/30">
                <h3 class="text-white font-medium">Create Category</h3>
                <p class="text-[11px] text-ai-accent font-mono mt-1 uppercase">AI Logic Configuration</p>
            </div>

            <div class="p-6 space-y-5 flex-1">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase font-mono text-slate-500 font-bold mb-2 tracking-wider">Select Album</label>
                        <div class="relative group">
                            <select class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-xs rounded-md px-3 py-2.5 outline-none appearance-none cursor-pointer focus:border-ai-accent transition-colors">
                                <option>January Screenshots</option>
                                <option>Travel 2024</option>
                                <option>Personal</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500 group-hover:text-white transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase font-mono text-slate-500 font-bold mb-2 tracking-wider">Category Name</label>
                        <input type="text" class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-xs rounded-md px-3 py-2.5 outline-none" placeholder="e.g. Receipts">
                    </div>
                </div>

                <div>
                    <label class="text-[10px] uppercase font-mono text-ai-accent font-bold tracking-wider block mb-2">AI Sorting Logic</label>
                    <textarea rows="4" class="w-full bg-[#050a14] border border-ai-accent/20 text-indigo-100 text-xs font-mono rounded-md p-4 outline-none resize-none leading-relaxed" placeholder="Describe what belongs here..."></textarea>
                </div>
            </div>

            <div class="p-6 bg-slate-950/50 border-t border-slate-800 flex justify-center">
                <button class="px-10 py-2.5 bg-white hover:bg-slate-200 text-slate-900 rounded-md text-xs font-bold uppercase tracking-widest transition-all shadow-sm">
                    Apply Logic
                </button>
            </div>
        </div>
    </div>
</div>