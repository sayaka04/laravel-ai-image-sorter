<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Template'}}</title>

    @include('partials.assets')

</head>

<body class="bg-gray-50 flex h-screen overflow-hidden">

    @include('partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        @include('partials.navbar')

        <main class="flex-1 overflow-y-auto p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="text-gray-500 text-sm font-medium uppercase mb-2">Total Revenue</div>
                    <div class="text-3xl font-bold text-gray-900">$24,500</div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="text-gray-500 text-sm font-medium uppercase mb-2">Active Users</div>
                    <div class="text-3xl font-bold text-gray-900">1,240</div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="text-gray-500 text-sm font-medium uppercase mb-2">Bounce Rate</div>
                    <div class="text-3xl font-bold text-gray-900">12%</div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm h-96 flex items-center justify-center text-gray-400">
                Chart Area Placeholder
            </div>

            <div class="flex-1 overflow-y-auto p-4 md:p-8 bg-slate-50">
                <div class="max-w-5xl mx-auto space-y-12 pb-20">

                    <section class="max-w-2xl mx-auto py-8">
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-900 text-[10px] font-bold text-white uppercase tracking-tighter">01</span>
                                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-widest">Image Upload</h2>
                            </div>
                            <span class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Batch Processing Enabled</span>
                        </div>

                        <div id="drop-zone" class="relative group">
                            <label for="multi-upload"
                                class="relative flex flex-col items-center justify-center w-full h-72 border-2 border-dashed border-slate-200 rounded-[2.5rem] cursor-pointer bg-white hover:bg-slate-50 hover:border-violet-400 transition-all duration-500 overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-violet-100/50">

                                <div class="absolute -top-24 -right-24 w-48 h-48 bg-violet-100/50 rounded-full blur-3xl group-hover:bg-violet-200/50 transition-colors"></div>

                                <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                                    <div id="icon-container" class="w-20 h-20 rounded-3xl bg-slate-50 border border-slate-100 shadow-sm flex items-center justify-center mb-5 group-hover:scale-110 group-hover:rotate-3 group-hover:bg-white group-hover:border-violet-100 transition-all duration-500">
                                        <svg class="w-10 h-10 text-slate-400 group-hover:text-violet-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path>
                                        </svg>
                                    </div>

                                    <h3 class="text-xl font-bold text-slate-900 mb-2">Drop your media here</h3>
                                    <p class="text-sm text-slate-500 font-medium">or <span class="text-violet-600 underline decoration-2 underline-offset-4">browse files</span> from computer</p>

                                    <div class="mt-6 flex gap-3">
                                        <span class="px-3 py-1 rounded-full bg-slate-100 text-[10px] font-bold text-slate-500 uppercase tracking-tight">PNG</span>
                                        <span class="px-3 py-1 rounded-full bg-slate-100 text-[10px] font-bold text-slate-500 uppercase tracking-tight">JPG</span>
                                        <span class="px-3 py-1 rounded-full bg-slate-100 text-[10px] font-bold text-slate-500 uppercase tracking-tight">WEBP</span>
                                    </div>
                                </div>

                                <input id="multi-upload" name="images[]" type="file" class="hidden" multiple accept="image/png, image/jpeg, image/webp" />
                            </label>

                            <div id="file-preview" class="hidden absolute inset-0 pointer-events-none bg-white/90 backdrop-blur-sm rounded-[2.5rem] flex flex-col items-center justify-center z-20 animate-in fade-in zoom-in duration-300">
                                <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <p class="text-2xl font-black text-slate-900"><span id="file-count">0</span> Images</p>
                                <p class="text-slate-500 font-medium mt-1 uppercase text-xs tracking-widest">Selected & Ready for AI Sorting</p>
                                <button type="button" onclick="resetUpload()" class="mt-6 pointer-events-auto text-xs font-bold text-slate-400 hover:text-rose-500 transition-colors uppercase tracking-widest">Clear Selection</button>
                            </div>
                        </div>
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

                        // Visual feedback for drag
                        ['dragenter', 'dragover'].forEach(eventName => {
                            dropZone.addEventListener(eventName, () => {
                                dropZone.classList.add('scale-[0.98]', 'opacity-80');
                            }, false);
                        });

                        ['dragleave', 'drop'].forEach(eventName => {
                            dropZone.addEventListener(eventName, () => {
                                dropZone.classList.remove('scale-[0.98]', 'opacity-80');
                            }, false);
                        });

                        // Handle dropped files
                        dropZone.addEventListener('drop', (e) => {
                            const dt = e.dataTransfer;
                            const files = dt.files;
                            input.files = files; // Assign files to the hidden input
                            updatePreview(files.length);
                        });

                        // Handle clicked files
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

                </div>
            </div>


        </main>

    </div>

</body>

</html>