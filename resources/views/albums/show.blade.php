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
                            <div class="flex items-center space-x-2 text-[10px] font-mono text-slate-500 mb-4 uppercase tracking-widest">
                                <a href="{{ route('albums.index') }}" class="hover:text-ai-accent transition-colors">Albums</a>
                                <span class="text-slate-700">/</span>
                                <span class="text-ai-accent border-b border-ai-accent/30 pb-0.5">{{ $album->album_name }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-1 bg-ai-accent shadow-[0_0_10px_var(--neon-primary)] rounded-full"></div>
                                <h1 class="text-3xl font-light text-white tracking-tight">Album Content</h1>
                            </div>
                            <p class="text-sm text-slate-500 mt-1">Manage the content of the selected album.</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('albums.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-ai-accent hover:bg-indigo-500 text-white text-xs font-medium rounded shadow-[0_0_15px_-5px_rgba(99,102,241,0.5)] transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add New Album
                            </a>
                            <a href="{{ route('download.folder', 'upload_sorted/'.$album->album_name) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/20 text-indigo-300 hover:text-indigo-200 text-xs font-medium rounded transition-all whitespace-nowrap decoration-none">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Download Album ZIP
                            </a>
                        </div>
                    </div>

                    <div class="h-px w-full bg-slate-800"></div>

                    <form action="{{ route('albums.show', $album->id) }}" method="GET">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                            <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                                <div class="relative group w-full sm:w-64">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-slate-600 group-focus-within:text-ai-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="w-full bg-slate-900 border border-slate-800 focus:border-ai-accent text-slate-300 text-sm rounded block pl-10 py-2 placeholder-slate-600 transition-all focus:outline-none focus:ring-1 focus:ring-ai-accent/50"
                                        placeholder="Search category...">
                                </div>

                                <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded text-xs transition-all">
                                    Apply Filters
                                </button>

                                @if(request()->anyFilled(['search', 'from', 'to']))
                                <a href="{{ route('albums.show', $album->id) }}" class="text-slate-500 hover:text-white text-xs flex items-center">Clear</a>
                                @endif
                            </div>

                            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                <div class="relative w-full sm:w-auto">
                                    <label class="absolute -top-2 left-2 bg-slate-950 px-1 text-[10px] text-slate-500 font-mono">FROM</label>
                                    <input type="date" name="from" value="{{ request('from') }}"
                                        class="w-full sm:w-auto bg-slate-900 border border-slate-800 text-slate-300 text-xs rounded px-3 py-2 font-mono uppercase focus:border-ai-accent focus:outline-none">
                                </div>
                                <span class="text-slate-600">-</span>
                                <div class="relative w-full sm:w-auto">
                                    <label class="absolute -top-2 left-2 bg-slate-950 px-1 text-[10px] text-slate-500 font-mono">TO</label>
                                    <input type="date" name="to" value="{{ request('to') }}"
                                        class="w-full sm:w-auto bg-slate-900 border border-slate-800 text-slate-300 text-xs rounded px-3 py-2 font-mono uppercase focus:border-ai-accent focus:outline-none">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </section>

            <main class="flex-1 p-5">
                <section class="p-6 bg-slate-950">

                    @if($album->categories()->exists())
                    <form id="upload-form" action="{{ route('upload_queues.store') }}" method="POST" enctype="multipart/form-data" class="w-full mb-8">
                        @csrf
                        <div class="w-full bg-slate-900 border border-slate-800 rounded-lg shadow-xl overflow-hidden">
                            <div class="px-5 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-900">
                                <h3 class="text-white font-semibold text-base">Upload Images</h3>
                            </div>
                            <div class="p-6 space-y-5">
                                <div>
                                    <label for="album_id" class="block text-xs font-medium text-slate-300 mb-2">Select Album</label>
                                    <div class="relative">
                                        <select id="album_id" name="album_id" class="w-full bg-slate-950 border border-slate-700 text-slate-200 text-sm rounded-md px-4 py-2 outline-none focus:border-indigo-500 appearance-none">
                                            <option value="{{ $album->id }}" selected>{{ $album->album_name }}</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div id="drop-zone" class="relative border-2 border-dashed border-slate-700 bg-slate-950 rounded-lg p-10 flex flex-col items-center justify-center text-center hover:border-indigo-500 transition-all cursor-pointer">
                                    <input id="multi-upload" name="images[]" type="file" required
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        multiple accept="image/*"
                                        onchange="document.getElementById('file-count').innerText = this.files.length; document.getElementById('file-preview').classList.remove('hidden')">

                                    <svg class="w-10 h-10 text-slate-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm text-slate-300">Click to upload or drag and drop</p>
                                    <p class="text-xs text-slate-500 mt-1">PNG, JPG or WEBP (max. 10MB each file)</p>

                                    <div id="file-preview" class="hidden absolute inset-0 bg-slate-900 rounded-lg flex flex-col items-center justify-center z-20">
                                        <p class="text-sm font-medium text-indigo-400"><span id="file-count">0</span> files selected</p>
                                        <button type="button" onclick="event.stopPropagation(); document.getElementById('multi-upload').value = ''; document.getElementById('file-preview').classList.add('hidden')" class="mt-2 text-xs text-rose-500 hover:underline">Remove all</button>
                                    </div>
                                </div>
                                @error('images') <p class="text-rose-500 text-xs">{{ $message }}</p> @enderror
                            </div>

                            <div class="px-6 py-4 bg-slate-950 border-t border-slate-800">
                                <button type="submit" id="upload-btn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-md text-sm transition-colors shadow-md flex justify-center items-center gap-2">
                                    <svg id="upload-spinner" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span id="btn-text">Upload to Queue</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <script>
                        document.getElementById('upload-form').addEventListener('submit', function(e) {
                            const fileInput = document.getElementById('multi-upload');

                            // 1. Check if files are selected
                            if (fileInput.files.length === 0) {
                                e.preventDefault();
                                alert('Please select at least one image.');
                                return;
                            }

                            // 2. Disable button immediately
                            const btn = document.getElementById('upload-btn');
                            const spinner = document.getElementById('upload-spinner');
                            const btnText = document.getElementById('btn-text');

                            btn.disabled = true;
                            btn.classList.add('opacity-75', 'cursor-not-allowed');

                            // 3. Show loading state
                            spinner.classList.remove('hidden');
                            btnText.innerText = 'Uploading...';
                        });
                    </script>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-5 gap-4 p-4 bg-slate-950">

                        <a href="{{ route('categories.create') }}" class="group relative flex items-center justify-center border-2 border-dashed border-slate-800 rounded-lg hover:border-indigo-500/50 hover:bg-slate-900/40 transition-all cursor-pointer min-h-[180px]">
                            <div class="text-center">
                                <div class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-slate-500 group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-bold uppercase tracking-tighter text-[9px]">New Category</p>
                            </div>
                        </a>

                        @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category->id) }}" class="group relative block">
                            <div class="absolute -top-2 left-0 w-20 h-6 bg-slate-900 border-t border-x border-slate-700 rounded-t-md z-0 transition-colors group-hover:bg-slate-800"></div>

                            <div class="relative z-10 bg-slate-900 border border-slate-700 rounded-lg rounded-tl-none p-3 shadow-xl transition-all duration-300 group-hover:translate-y-[-2px]">

                                <div class="flex justify-between items-start mb-3">
                                    <div class="truncate mr-2">
                                        <h3 class="text-white font-bold text-sm tracking-tight truncate">{{ $category->category_name }}</h3>
                                        <p class="text-[8px] text-slate-500 font-mono uppercase tracking-tighter">{{ $category->updated_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                </div>

                                <div class="relative h-20 w-full mb-3 flex items-center justify-center bg-slate-950/40 rounded border border-slate-800 overflow-hidden">
                                    <div class="relative w-12 h-10">
                                        <div class="absolute inset-0 bg-slate-700 rounded transform group-hover:translate-y-[-4px] transition-transform duration-500"></div>
                                        <div class="absolute inset-0 bg-indigo-600 rounded shadow-lg flex items-end p-1 border-t border-indigo-400">
                                            <div class="w-full h-0.5 bg-indigo-400/30 rounded"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between mb-3 px-1">
                                    <div class="text-center">
                                        <p class="text-[8px] text-slate-500 uppercase font-black">Objs</p>
                                        <p class="text-xs text-white font-mono">1.2k</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-[8px] text-slate-500 uppercase font-black">Size</p>
                                        <p class="text-xs text-white font-mono">4.2GB</p>
                                    </div>
                                </div>

                                <span class="flex items-center justify-center w-full bg-indigo-600 group-hover:bg-indigo-500 text-white text-[9px] font-bold py-1.5 rounded transition-all uppercase tracking-widest shadow-lg shadow-indigo-900/40">
                                    Open
                                </span>
                            </div>
                        </a>
                        @endforeach

                    </div>
                </section>
            </main>

            {{ $categories->links('partials.pagination') }}

        </div>

    </div>

    <script>
        const dropZone = document.getElementById('drop-zone');
        const input = document.getElementById('multi-upload');
        const preview = document.getElementById('file-preview');
        const countSpan = document.getElementById('file-count');

        if (dropZone && input) {
            // Drag and Drop Logic
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Add visual cues when dragging over
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.add('border-indigo-500', 'bg-slate-900');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.remove('border-indigo-500', 'bg-slate-900');
                }, false);
            });

            dropZone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;

                const dataTransfer = new DataTransfer();
                for (let i = 0; i < files.length; i++) {
                    dataTransfer.items.add(files[i]);
                }
                input.files = dataTransfer.files;

                updatePreview(files.length);
            });

            input.addEventListener('change', () => {
                updatePreview(input.files.length);
            });

            function updatePreview(count) {
                if (count > 0) {
                    preview.classList.remove('hidden');
                    countSpan.innerText = count;
                }
            }

            function resetUpload() {
                input.value = '';
                preview.classList.add('hidden');
                dropZone.classList.remove('border-indigo-500', 'bg-slate-900');
            }
        }
    </script>

</body>

</html>