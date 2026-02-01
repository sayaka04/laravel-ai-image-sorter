        <div class="flex-1 min-h-0 flex flex-col gap-6 p-4 md:p-6 lg:p-8 overflow-y-auto w-full">

            <div class="flex flex-col gap-4 shrink-0">

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-light text-white tracking-tight">Albums</h1>
                        <p class="text-sm text-slate-500 mt-1">Manage and organize your image collections</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button class="flex items-center justify-center gap-2 px-4 py-2 bg-slate-900 border border-slate-700 hover:border-slate-500 text-white text-xs font-medium rounded transition-all whitespace-nowrap">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add New Album
                        </button>
                        <button class="flex items-center justify-center gap-2 px-4 py-2 bg-ai-accent hover:bg-indigo-500 text-white text-xs font-medium rounded shadow-[0_0_15px_-5px_rgba(99,102,241,0.5)] transition-all whitespace-nowrap">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Upload Unsorted
                        </button>
                    </div>
                </div>

                <div class="h-px w-full bg-slate-800"></div>

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                    <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                        <div class="relative group w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-600 group-focus-within:text-ai-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" class="w-full bg-slate-900 border border-slate-800 focus:border-ai-accent text-slate-300 text-sm rounded block pl-10 py-2 placeholder-slate-600 transition-all focus:outline-none focus:ring-1 focus:ring-ai-accent/50" placeholder="Search...">
                        </div>

                        <select class="w-full sm:w-auto bg-slate-900 border border-slate-800 focus:border-ai-accent text-slate-300 text-sm rounded block pl-3 pr-8 py-2 focus:outline-none transition-all cursor-pointer">
                            <option>Filter by Status</option>
                            <option>Active</option>
                            <option>Archived</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                        <div class="relative w-full sm:w-auto">
                            <label class="absolute -top-2 left-2 bg-slate-950 px-1 text-[10px] text-slate-500 font-mono">FROM</label>
                            <input type="date" class="w-full sm:w-auto bg-slate-900 border border-slate-800 text-slate-300 text-xs rounded px-3 py-2 font-mono uppercase focus:border-ai-accent focus:outline-none">
                        </div>
                        <span class="text-slate-600">-</span>
                        <div class="relative w-full sm:w-auto">
                            <label class="absolute -top-2 left-2 bg-slate-950 px-1 text-[10px] text-slate-500 font-mono">TO</label>
                            <input type="date" class="w-full sm:w-auto bg-slate-900 border border-slate-800 text-slate-300 text-xs rounded px-3 py-2 font-mono uppercase focus:border-ai-accent focus:outline-none">
                        </div>
                    </div>

                </div>
            </div>

            <main class="flex-1">
                @include('template.partials.part2')
                @include('template.partials.part3')

                @include('template.partials.part4')

                @include('template.partials.part5')
                @include('template.partials.part6')
                @include('template.partials.part7')
                @include('template.partials.part8')

            </main>

            <div class="flex flex-col sm:flex-row items-center justify-between border-t border-slate-800 pt-4 gap-4 shrink-0">
                <div class="text-xs text-slate-500 font-mono">
                    Showing <span class="text-white">1</span> to <span class="text-white">10</span> of <span class="text-white">50</span>
                </div>

                <div class="flex items-center gap-1">
                    <button class="p-2 text-slate-500 hover:text-white hover:bg-slate-800 rounded transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center text-sm font-medium rounded bg-ai-accent text-white shadow-[0_0_10px_-3px_rgba(99,102,241,0.5)]">1</button>
                    <button class="w-8 h-8 flex items-center justify-center text-sm font-medium rounded text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">2</button>
                    <button class="w-8 h-8 flex items-center justify-center text-sm font-medium rounded text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">3</button>
                    <span class="w-8 h-8 flex items-center justify-center text-slate-600">...</span>
                    <button class="w-8 h-8 flex items-center justify-center text-sm font-medium rounded text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">8</button>

                    <button class="p-2 text-slate-500 hover:text-white hover:bg-slate-800 rounded transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

        </div>