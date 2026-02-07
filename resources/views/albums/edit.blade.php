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
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-1 bg-ai-accent shadow-[0_0_10px_var(--neon-primary)] rounded-full"></div>
                                <h1 class="text-3xl font-light text-white tracking-tight">Edit album</h1>
                            </div>
                            <p class="text-sm text-slate-500 mt-1">The album is where the categories of sorted images are stored.</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('albums.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-ai-accent hover:bg-indigo-500 text-white text-xs font-medium rounded shadow-[0_0_15px_-5px_rgba(99,102,241,0.5)] transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                </svg>
                                Back to Albums
                            </a>

                            <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-900 border border-slate-700 hover:border-slate-500 text-white text-xs font-medium rounded transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add new Category
                            </a>
                        </div>
                    </div>

                    <div class="h-px w-full bg-slate-800"></div>

                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        {{-- Kept empty as per your original layout --}}
                    </div>
                </div>
            </section>

            <main class="flex-1 mb-10">

                <section class="bg-slate-950 mb-10">
                    <div class="space-y-6">

                        @include('partials.flash')

                        <div class="flex justify-center">
                            {{-- Form integrated into your specific card structure --}}
                            <form id="edit-album-form" action="{{ route('albums.update', $album) }}" method="POST" class="w-full max-w-2xl bg-slate-900 border border-slate-800 rounded-xl overflow-hidden flex flex-col">
                                @csrf
                                @method('PUT')
                                <div class="p-5 border-b border-slate-800 bg-slate-950/30">
                                    <h3 class="text-white font-medium">Edit Album</h3>
                                    <p class="text-[11px] text-slate-500 font-mono mt-1 uppercase">Initialize Storage Collection</p>
                                </div>

                                <div class="p-6 space-y-5 flex-1">
                                    <div>
                                        <label for="album_name" class="block text-[10px] uppercase font-mono text-slate-500 font-bold mb-2 tracking-wider">Album Name</label>
                                        <input type="text"
                                            id="album_name"
                                            name="album_name"
                                            value="{{ $album->album_name }}"
                                            required
                                            class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-md px-4 py-2.5 focus:border-ai-accent outline-none"
                                            placeholder="e.g. January Screenshots">

                                        @error('album_name')
                                        <p class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="description" class="block text-[10px] uppercase font-mono text-slate-500 font-bold mb-2 tracking-wider">Description</label>
                                        <textarea id="description"
                                            name="description"
                                            rows="4"
                                            class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-md px-4 py-2.5 focus:border-slate-600 outline-none resize-none"
                                            placeholder="Content about the album...">{{ $album->description }}</textarea>
                                    </div>
                                </div>

                                <div class="p-6 bg-slate-950/50 border-t border-slate-800 flex justify-center">
                                    <button type="submit" id="create-btn" class="px-8 py-2.5 bg-white hover:bg-slate-200 text-slate-900 rounded-md text-xs font-bold uppercase tracking-widest transition-all shadow-sm flex items-center gap-2">
                                        <svg id="btn-spinner" class="animate-spin -ml-1 h-4 w-4 text-slate-900 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span id="btn-text">Confirm Album</span>
                                    </button>
                                </div>
                            </form>

                            <script>
                                document.getElementById('edit-album-form').addEventListener('submit', function(e) {
                                    // 1. Get Elements
                                    const btn = document.getElementById('create-btn');
                                    const spinner = document.getElementById('btn-spinner');
                                    const text = document.getElementById('btn-text');

                                    // 2. Disable Button immediately
                                    btn.disabled = true;
                                    btn.classList.add('opacity-75', 'cursor-not-allowed');

                                    // 3. Show Spinner and Change Text
                                    spinner.classList.remove('hidden');
                                    text.innerText = 'CREATING...';
                                });
                            </script>

                        </div>
                    </div>
                </section>

            </main>

        </div>

    </div>

</body>

</html>