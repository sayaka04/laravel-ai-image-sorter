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
                                <a href="{{ route('albums.show', ['album' => $file->category->album]) }}" class="hover:text-ai-accent transition-colors">{{ $file->category->album->album_name }}</a>
                                <span class="text-slate-700">/</span>
                                <a href="{{ route('categories.show', ['category' => $file->category]) }}" class="hover:text-ai-accent transition-colors">{{ $file->category->category_name }}</a>
                                <span class="text-slate-700">/</span>
                                <span class="text-ai-accent border-b border-ai-accent/30 pb-0.5">{{ $file->file_name }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-1 bg-ai-accent shadow-[0_0_10px_var(--neon-primary)] rounded-full"></div>
                                <h1 class="text-3xl font-light text-white tracking-tight">File Details</h1>
                            </div>
                            <p class="text-sm text-slate-500 mt-1">View and manage this specific file.</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">

                            <a href="{{ route('albums.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-ai-accent hover:bg-indigo-500 text-white text-xs font-medium rounded shadow-[0_0_15px_-5px_rgba(99,102,241,0.5)] transition-all whitespace-nowrap decoration-none">
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
                <section>

                    <div class="space-y-6 mb-10">

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                            <div class="flex flex-col gap-6">

                                <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-lg">

                                    <div class="relative h-72 bg-slate-950 border-b border-slate-800 flex items-center justify-center group overflow-hidden">
                                        <div class="absolute inset-0 opacity-[0.05]" style="background-image: radial-gradient(#4ade80 1px, transparent 1px); background-size: 16px 16px;"></div>

                                        <img src="{{ route('getFile', ['filePath' => $file->file_path]) }}"
                                            alt="{{ $file->file_name }}"
                                            class="h-full w-full object-contain relative z-10 p-4 transition-transform duration-500 group-hover:scale-105">
                                    </div>

                                    <div class="p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <h2 class="text-xl font-light text-white tracking-tight truncate" title="{{ $file->file_name }}">
                                                {{ $file->file_name }}
                                            </h2>
                                            <span class="px-2 py-1 rounded text-[10px] font-mono bg-slate-800 text-slate-400 border border-slate-700">
                                                {{ $file->extension ?? 'FILE' }}
                                            </span>
                                        </div>

                                        <div class="mb-6 pl-4 border-l-2 border-slate-700">
                                            <p class="text-sm text-slate-400 font-mono leading-relaxed">
                                                {{ $file->summary ?? 'AI analysis pending...' }}
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap gap-3">
                                            @php
                                            $path = "upload_sorted/{$file->category->album->album_name}/{$file->category->category_name}/{$file->file_name}";
                                            @endphp
                                            <a
                                                href="{{ route('getFile', ['filePath' => $path]) }}"
                                                download="{{ $file->file_name }}"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-medium rounded border border-slate-700 transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Download
                                            </a>
                                            <a href="{{ route('files.edit', $file) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-medium rounded shadow-[0_0_10px_-3px_rgba(99,102,241,0.5)] transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                                Edit Details
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-red-500/5 border border-red-500/10 rounded-xl p-5">
                                    <h3 class="text-xs font-bold text-red-500/80 uppercase tracking-widest mb-3">Danger Zone</h3>
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <p class="text-xs text-red-400/50">Permanently delete this file?</p>
                                        <form action="{{ route('files.destroy', $file) }}" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs bg-red-950 hover:bg-red-900 text-red-400 border border-red-900/50 hover:border-red-500/50 px-3 py-1.5 rounded transition-all">
                                                Delete File
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col h-full">
                                <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-lg flex flex-col h-full min-h-[400px]">
                                    <div class="px-5 py-3 border-b border-slate-800 flex justify-between items-center bg-slate-900/80">
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 shadow-[0_0_5px_rgba(74,222,128,0.8)]"></div>
                                            <span class="text-xs font-medium text-slate-300">Raw Analysis</span>
                                        </div>
                                        <span class="text-[10px] bg-slate-950 text-slate-500 px-2 py-0.5 rounded border border-slate-800 font-mono">JSON</span>
                                    </div>
                                    <div class="relative flex-1 bg-slate-950 p-4 overflow-hidden group">
                                        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-700 to-transparent opacity-50"></div>

                                        <div class="h-full overflow-y-auto custom-scrollbar">
                                            @php
                                            // 1. Decode the raw string into a PHP object, then Re-encode with Pretty Print
                                            $data = is_string($file->raw_ai_response) ? json_decode($file->raw_ai_response) : $file->raw_ai_response;
                                            $pretty = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                                            @endphp

                                            {{-- Display it --}}
                                            <pre class="font-mono text-[11px] leading-relaxed text-green-500/90">{{ $pretty ?? '// No Data' }}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </section>
            </main>

        </div>

    </div>

</body>

</html>