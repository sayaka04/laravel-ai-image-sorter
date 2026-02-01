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

        <div class="flex-1 min-h-0 flex flex-col gap-6 p-4 md:p-6 lg:p-8 overflow-y-auto w-full">

            <section>
                <div class="flex flex-col gap-4 shrink-0">

                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-light text-white tracking-tight">Create Category</h1>
                            <p class="text-sm text-slate-500 mt-1">Create a new category to organize your sorted images</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">

                            <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-ai-accent hover:bg-indigo-500 text-white text-xs font-medium rounded shadow-[0_0_15px_-5px_rgba(99,102,241,0.5)] transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Back to Categories
                            </a>

                            <a href="{{ route('albums.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-900 border border-slate-700 hover:border-slate-500 text-white text-xs font-medium rounded transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add New Album
                            </a>

                        </div>
                    </div>

                    <div class="h-px w-full bg-slate-800"></div>

                </div>
            </section>

            <main class="flex-1 p-5">
                <section class="p-6 bg-slate-950">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
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
                                            <select name="album_id" id="album_id" required
                                                class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-xs rounded-md px-3 py-2.5 outline-none appearance-none cursor-pointer focus:border-ai-accent transition-colors">
                                                <option value="" disabled selected>Select an Album...</option>
                                                @if(isset($albums))
                                                @foreach($albums as $album)
                                                <option value="{{ $album->id }}">{{ $album->album_name }}</option>
                                                @endforeach
                                                @else
                                                <option value="" disabled>No albums loaded</option>
                                                @endif
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
                                        <input type="text" name="category_name" id="category_name" required" class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-xs rounded-md px-3 py-2.5 outline-none" placeholder="e.g. Receipts">
                                    </div>
                                </div>

                                <div>
                                    <label class="text-[10px] uppercase font-mono text-ai-accent font-bold tracking-wider block mb-2">AI Sorting Logic</label>
                                    <textarea id="ai_rules" name="ai_rules" rows="5"" class=" w-full bg-[#050a14] border border-ai-accent/20 text-indigo-100 text-xs font-mono rounded-md p-4 outline-none resize-none leading-relaxed" placeholder="Describe what belongs here..."></textarea>
                                </div>
                            </div>

                            <div class="p-6 bg-slate-950/50 border-t border-slate-800 flex justify-center">
                                <button type="submit" class="px-10 py-2.5 bg-white hover:bg-slate-200 text-slate-900 rounded-md text-xs font-bold uppercase tracking-widest transition-all shadow-sm">
                                    Apply Logic
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
            </main>


        </div>

    </div>

</body>

</html>