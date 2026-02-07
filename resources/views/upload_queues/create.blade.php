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
                                <h1 class="text-3xl font-light text-white tracking-tight">Add to Queue</h1>
                            </div>
                            <p class="text-sm text-slate-500 mt-1">Upload images to an existing album to queue them for sorting</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
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

            <main class="flex-1 mb-10">
                <section class="bg-slate-950 mb-10">

                    <form id="upload-form" action="{{ route('upload_queues.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="flex justify-center">
                            <div class="w-full max-w-2xl bg-slate-900 border border-slate-800 rounded-xl overflow-hidden flex flex-col shadow-2xl">

                                <div class="p-5 border-b border-slate-800 bg-slate-950/30 flex justify-between items-center">
                                    <div>
                                        <h3 class="text-white font-medium">Upload to Queue</h3>
                                        <p class="text-[11px] text-slate-500 font-mono mt-1 uppercase">Ready for Input</p>
                                    </div>
                                    <a href="{{ route('upload_queues.index') }}" class="text-[10px] font-bold text-slate-600 hover:text-rose-500 uppercase tracking-widest transition-colors">Cancel</a>
                                </div>

                                <div class="p-8 space-y-8">

                                    <div class="max-w-md mx-auto">
                                        <label for="album_id" class="block text-[10px] uppercase font-mono text-slate-500 font-bold mb-3 tracking-wider">Target Destination</label>
                                        <div class="relative group">
                                            <select id="album_id" name="album_id" class="w-full bg-slate-950 border border-slate-800 text-slate-200 text-xs rounded-md px-4 py-2.5 outline-none appearance-none cursor-pointer focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50 transition-colors">
                                                @foreach($albums as $album)
                                                <option value="{{ $album->id }}" {{ (isset($selectedAlbumId) && $selectedAlbumId == $album->id) ? 'selected' : '' }}>
                                                    {{ $album->album_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-500 group-hover:text-white transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('album_id')
                                        <p class="text-rose-500 text-[10px] mt-2 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div id="drop-zone" class="relative group border-2 border-dashed border-slate-800 bg-slate-950/50 rounded-lg h-64 flex flex-col items-center justify-center text-center transition-all duration-300 hover:border-indigo-500/50 hover:bg-slate-900 cursor-pointer overflow-hidden">

                                        <input id="multi-upload" name="images[]" type="file" required
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                            multiple accept="image/png, image/jpeg, image/webp">

                                        <div class="space-y-4 pointer-events-none z-0">
                                            <div class="mx-auto h-12 w-12 text-slate-600 group-hover:text-indigo-400 transition-colors">
                                                <svg class="animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-white">Drop media here</p>
                                                <p class="text-[11px] text-slate-500 mt-1">or <span class="text-indigo-400 underline underline-offset-4 decoration-indigo-400/30">browse computer</span></p>
                                            </div>
                                        </div>

                                        <div id="file-preview" class="hidden absolute inset-0 z-20 bg-slate-900/95 backdrop-blur-sm flex flex-col items-center justify-center animate-in fade-in zoom-in duration-300">
                                            <div class="w-16 h-16 bg-emerald-500/10 rounded-full flex items-center justify-center mb-4 border border-emerald-500/20">
                                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <p class="text-xl font-light text-white"><span id="file-count" class="font-bold text-emerald-400">0</span> Images Selected</p>
                                            <p class="text-[10px] text-slate-500 font-mono mt-1 uppercase tracking-widest">Ready for Analysis</p>

                                            <button type="button" id="reset-btn" class="mt-6 px-4 py-2 rounded border border-rose-500/20 bg-rose-500/10 text-[10px] font-bold text-rose-500 hover:bg-rose-500 hover:text-white transition-all uppercase tracking-widest z-30 pointer-events-auto">
                                                Reset Files
                                            </button>
                                        </div>

                                    </div>
                                    @error('file')
                                    <p class="text-rose-500 text-xs text-center font-medium">{{ $message }}</p>
                                    @enderror
                                    @error('images')
                                    <p class="text-rose-500 text-xs text-center font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="p-6 bg-slate-950/50 border-t border-slate-800 flex justify-center">
                                    <button type="submit" id="upload-btn" class="px-12 py-2.5 bg-white hover:bg-slate-200 text-slate-900 rounded-md text-xs font-bold uppercase tracking-widest transition-all shadow-sm flex items-center gap-2">
                                        <svg id="upload-spinner" class="animate-spin -ml-1 h-4 w-4 text-slate-900 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span id="btn-text">Upload to Queue</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <script>
                        // 1. Handle File Selection (Show Preview)
                        document.getElementById('multi-upload').addEventListener('change', function(e) {
                            if (this.files.length > 0) {
                                document.getElementById('file-count').innerText = this.files.length;
                                document.getElementById('file-preview').classList.remove('hidden');
                            }
                        });

                        // 2. Handle Reset Button (Clear Selection)
                        document.getElementById('reset-btn').addEventListener('click', function(e) {
                            e.stopPropagation(); // Stop click from triggering the file input behind it
                            const input = document.getElementById('multi-upload');
                            input.value = ''; // Clear files
                            document.getElementById('file-preview').classList.add('hidden');
                        });

                        // 3. Handle Form Submission (Prevent Double Uploads)
                        document.getElementById('upload-form').addEventListener('submit', function(e) {
                            const fileInput = document.getElementById('multi-upload');

                            // Validation: Ensure files are selected
                            if (fileInput.files.length === 0) {
                                e.preventDefault();
                                alert('Please select files to upload.');
                                return;
                            }

                            // Disable UI
                            const btn = document.getElementById('upload-btn');
                            const spinner = document.getElementById('upload-spinner');
                            const btnText = document.getElementById('btn-text');

                            btn.disabled = true;
                            btn.classList.add('opacity-75', 'cursor-not-allowed');

                            // Show Loading State
                            spinner.classList.remove('hidden');
                            btnText.innerText = 'PROCESSING...';
                        });
                    </script>
                </section>
            </main>

        </div>

    </div>

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

            // Create a DataTransfer to update the input files
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
            // Reset visual styles just in case
            dropZone.classList.remove('border-indigo-500', 'bg-slate-900');
        }
    </script>

</body>

</html>