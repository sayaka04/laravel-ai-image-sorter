<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xs font-mono uppercase tracking-[0.2em] text-slate-500 font-bold">Media Ingestion</h2>
        <div class="h-px flex-1 bg-slate-800 ml-4"></div>
    </div>

    <div class="flex justify-center">
        <div class="w-full max-w-2xl bg-slate-900 border border-slate-800 rounded-xl overflow-hidden flex flex-col shadow-2xl">

            <div class="p-5 border-b border-slate-800 bg-slate-950/30 flex justify-between items-center">
                <div>
                    <h3 class="text-white font-medium">Upload to Queue</h3>
                    <p class="text-[11px] text-slate-500 font-mono mt-1 uppercase">Ready for Input</p>
                </div>
            </div>

            <div class="p-8 space-y-8">
                <div class="max-w-md mx-auto">
                    <label class="block text-[10px] uppercase font-mono text-slate-500 font-bold mb-3 tracking-wider">Target Destination</label>
                    <div class="relative group">
                        <select class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-xs rounded-md px-4 py-2.5 outline-none appearance-none cursor-pointer focus:border-ai-accent transition-colors">
                            <option>Select Album...</option>
                            <option>January Screenshots</option>
                            <option>Unsorted Images</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-500 group-hover:text-white transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div id="dropzone" class="relative group border-2 border-dashed border-slate-800 bg-slate-950/50 rounded-lg py-16 text-center transition-all duration-300 hover:border-ai-accent/50 hover:bg-slate-900 cursor-pointer">
                    <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" multiple>
                    <div class="space-y-4 pointer-events-none">
                        <div class="mx-auto h-12 w-12 text-slate-600 group-hover:text-ai-accent transition-colors">
                            <svg class="animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Drop media here</p>
                            <p class="text-[11px] text-slate-500 mt-1">or <span class="text-ai-accent underline underline-offset-4">browse computer</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-slate-950/50 border-t border-slate-800 flex justify-center">
                <button class="px-12 py-2.5 bg-white hover:bg-slate-200 text-slate-900 rounded-md text-xs font-bold uppercase tracking-widest transition-all shadow-sm">
                    Upload to Queue
                </button>
            </div>
        </div>
    </div>
</div>