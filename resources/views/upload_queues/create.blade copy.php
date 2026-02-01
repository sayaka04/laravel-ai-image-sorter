<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SmartSorter AI'}}</title>

    @include('partials.assets')

</head>

<body class="bg-gray-50 flex h-screen overflow-hidden">

    @include('partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        @include('partials.navbar')

        <main class="flex-1 overflow-y-auto p-6">

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
                                @foreach($albums as $album)
                                <option value="{{ $album->id }}" {{ (isset($selectedAlbumId) && $selectedAlbumId == $album->id) ? 'selected' : '' }}>
                                    {{ $album->album_name }}
                                </option>
                                @endforeach
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

        </main>

    </div>

</body>

</html>