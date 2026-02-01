<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $album->album_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('albums.index') }}" class="text-gray-500 hover:text-gray-900 flex items-center gap-2">
                    &larr; <span class="text-sm font-medium">Back to Albums</span>
                </a>
                <span class="text-lg font-bold text-gray-900">{{ $album->album_name }}</span>
                <div></div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="bg-white shadow rounded-lg p-6 mb-8 border border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Context</h1>
            <div class="bg-indigo-50 rounded-md p-4 text-indigo-800 text-sm border border-indigo-100">
                <strong>AI Instructions:</strong> {{ $album->description ?? 'No specific context provided.' }}
            </div>
            <section class="max-w-2xl mx-auto py-10">
                <form action="{{ route('upload_queues.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf

                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-900 text-[10px] font-bold text-white uppercase tracking-tighter">01</span>
                            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-widest">Configure Upload</h2>
                        </div>
                        <a href="{{ route('upload_queues.index') }}" class="text-[10px] font-bold text-slate-400 hover:text-rose-500 uppercase tracking-widest transition-colors">Cancel Session</a>
                    </div>

                    <div class="relative group">
                        <label for="album_id" class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">
                            Target Album
                        </label>
                        <div class="relative">
                            <select id="album_id" name="album_id"
                                class="block w-full px-5 py-4 bg-white border border-slate-200 rounded-2xl text-slate-900 text-sm font-semibold appearance-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all cursor-pointer shadow-sm">
                                <option value="{{ $album->id }}" {{ (isset($selectedAlbumId) && $selectedAlbumId == $album->id) ? 'selected' : '' }}>
                                    {{ $album->album_name }}
                                </option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-5 pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('album_id')
                        <p class="text-rose-500 text-xs mt-2 ml-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-4">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">
                            Media Assets
                        </label>
                        <div id="drop-zone" class="relative group">
                            <label for="multi-upload"
                                class="relative flex flex-col items-center justify-center w-full h-80 border-2 border-dashed border-slate-200 rounded-[3rem] cursor-pointer bg-white hover:bg-slate-50 hover:border-indigo-400 transition-all duration-500 overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-indigo-100/50">

                                <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-100/50 rounded-full blur-3xl group-hover:bg-indigo-200/50 transition-colors"></div>

                                <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10 text-center px-6">
                                    <div id="icon-container" class="w-20 h-20 rounded-3xl bg-slate-50 border border-slate-100 shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 group-hover:bg-white group-hover:border-indigo-100 transition-all duration-500">
                                        <svg class="w-10 h-10 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path>
                                        </svg>
                                    </div>

                                    <h3 class="text-2xl font-black text-slate-900 mb-2 tracking-tight">Drop media here</h3>
                                    <p class="text-sm text-slate-500 font-medium">or <span class="text-indigo-600 underline decoration-2 underline-offset-4 font-bold">browse computer</span></p>

                                    <div class="mt-8 flex gap-2">
                                        <span class="px-4 py-1.5 rounded-xl bg-slate-100 text-[10px] font-black text-slate-500 uppercase tracking-widest group-hover:bg-white transition-colors">PNG</span>
                                        <span class="px-4 py-1.5 rounded-xl bg-slate-100 text-[10px] font-black text-slate-500 uppercase tracking-widest group-hover:bg-white transition-colors">JPG</span>
                                        <span class="px-4 py-1.5 rounded-xl bg-slate-100 text-[10px] font-black text-slate-500 uppercase tracking-widest group-hover:bg-white transition-colors">WEBP</span>
                                    </div>
                                </div>
                                <input id="multi-upload" name="images[]" type="file" class="hidden" multiple accept="image/png, image/jpeg, image/webp" />
                                <!-- <input id="multi-upload" name="file" type="file" class="hidden" multiple accept="image/png, image/jpeg, image/webp" /> -->
                            </label>

                            <div id="file-preview" class="hidden absolute inset-0 pointer-events-none bg-white/95 backdrop-blur-md rounded-[3rem] flex flex-col items-center justify-center z-20 animate-in fade-in zoom-in duration-300">
                                <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mb-6 shadow-inner">
                                    <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <p class="text-3xl font-black text-slate-900 tracking-tighter"><span id="file-count">0</span> Images</p>
                                <p class="text-slate-500 font-bold mt-1 uppercase text-[10px] tracking-[0.2em]">Ready for AI Analysis</p>
                                <button type="button" onclick="resetUpload()" class="mt-8 pointer-events-auto text-[10px] font-black text-rose-500 hover:text-rose-700 transition-colors uppercase tracking-[0.2em] bg-rose-50 px-4 py-2 rounded-lg">Reset Files</button>
                            </div>
                        </div>
                        @error('file')
                        <p class="text-rose-500 text-xs mt-2 ml-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full group relative flex items-center justify-center py-5 px-6 bg-slate-900 text-white rounded-[2rem] font-black text-lg shadow-2xl shadow-slate-200 hover:bg-indigo-600 transition-all duration-300 transform hover:-translate-y-1">
                            <span>Process & Sort via AI</span>
                            <svg class="ml-3 w-6 h-6 transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </section>

            <script>
                const dropZone = document.getElementById('drop-zone');
                const input = document.getElementById('multi-upload');
                const preview = document.getElementById('file-preview');
                const countSpan = document.getElementById('file-count');

                // Drag and Drop Logic
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.add('scale-[0.98]', 'opacity-90');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.remove('scale-[0.98]', 'opacity-90');
                    }, false);
                });

                dropZone.addEventListener('drop', (e) => {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    // Transfer files to input manually
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
                }
            </script>
            <div class="mt-6 flex space-x-3">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Upload Files
                </button>
                <button class="bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 font-medium py-2 px-4 rounded shadow">
                    Create Category
                </button>
            </div>
        </div>

        <div class="relative py-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="px-3 bg-gray-50 text-lg font-medium text-gray-900">
                    Smart Categories
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">

            @forelse($album->categories as $category)
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:border-indigo-300 transition cursor-pointer">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 truncate">
                                {{ $category->category_name }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                0 items </p>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-400">
                        {{ Str::limit($category->ai_rules, 40) }}
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View Files &rarr;</a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-10">
                <p class="text-gray-500 mb-4">No categories created yet.</p>
                <p class="text-sm text-gray-400">Once you upload files, the AI will auto-create these for you.</p>
            </div>
            @endforelse

        </div>

    </div>

</body>

</html>