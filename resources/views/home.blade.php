<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartSorter AI | Intelligent Local File Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @include('partials.assets')
</head>

<body class="bg-slate-950 text-slate-400 font-sans selection:bg-indigo-500 selection:text-slate-950">

    @include('partials/unauth-sidebar')

    <header class="relative pt-32 pb-20 px-6 overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[600px] bg-gradient-to-b from-indigo-500/10 via-transparent to-transparent blur-3xl opacity-50"></div>

        <div class="max-w-5xl mx-auto relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 border border-slate-800 mb-8">
                <span class="text-[10px] font-mono uppercase tracking-[0.2em] text-slate-400">Project Status: Stable v1.0</span>
            </div>

            <h1 class="text-6xl md:text-8xl font-black text-white tracking-tight mb-6 italic">
                A Simple AI <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-600 underline decoration-indigo-500/50">File Utility.</span>
            </h1>

            <p class="text-lg md:text-xl text-slate-400 max-w-3xl mx-auto leading-relaxed mb-12">
                This project handles image organization using <span class="text-white">Local Vision AI</span> and user-defined logic. It avoids cloud dependency by running processing locally, focusing on privacy and deterministic sorting.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="/register" class="w-full sm:w-auto px-10 py-5 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-500 transition-all flex items-center justify-center gap-2 uppercase tracking-tighter shadow-lg shadow-indigo-900/20">
                    <i class="ph-bold ph-rocket-launch"></i>
                    Get Started
                </a>
                <div class="flex items-center gap-4 text-[10px] font-mono text-slate-500 uppercase tracking-widest">
                    <span class="flex items-center gap-1"><i class="ph ph-cpu text-indigo-500"></i> Ollama Backend</span>
                    <span class="flex items-center gap-1"><i class="ph ph-database text-indigo-500"></i> Local Storage</span>
                </div>
            </div>
        </div>
    </header>

    <section id="logic" class="py-24 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

            <div class="md:col-span-8 bg-slate-900/40 border border-slate-800 rounded-3xl p-10 group relative overflow-hidden">
                <div class="relative z-10">
                    <i class="ph-duotone ph-code text-5xl text-indigo-500 mb-6 block"></i>
                    <h3 class="text-4xl font-bold text-white mb-6 underline decoration-indigo-500/30">Explicit Logic</h3>
                    <p class="text-slate-400 text-lg max-w-xl mb-8">
                        The system uses specific rules to handle how categories overlap, ensuring the AI follows user intent rather than making guesses.
                    </p>

                    <div class="space-y-6">
                        <div class="p-6 bg-slate-950 border-l-4 border-indigo-500 rounded-r-xl">
                            <h4 class="text-white font-bold mb-2">The "Conflict" Problem</h4>
                            <p class="text-sm text-slate-300">
                                If an image contains both <strong>"Animals"</strong> and <strong>"Art"</strong>, standard AI may struggle to categorize it. This tool allows the definition of priority rules: <span class="text-indigo-400 italic">"If the file is a drawing, it moves to Art regardless of the subject."</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-4 bg-slate-900/40 border border-slate-800 rounded-3xl p-10 flex flex-col justify-between">
                <div>
                    <i class="ph-duotone ph-hard-drive text-5xl text-indigo-500 mb-6 block"></i>
                    <h3 class="text-3xl font-bold text-white mb-6">File Specs</h3>
                    <p class="text-slate-400 text-sm mb-4">The current environment supports up to 200MB of active storage. It is designed to prioritize efficient batch processing and localized data handling.</p>
                </div>
                <div class="mt-8 bg-slate-950 p-4 rounded-xl border border-slate-800">
                    <div class="flex justify-between text-[10px] font-mono mb-2 text-slate-500">
                        <span>VOLUME_LIMIT</span>
                        <span class="text-indigo-400">200MB</span>
                    </div>
                    <div class="w-full bg-slate-800 h-1.5 rounded-full">
                        <div class="bg-indigo-500 h-full w-[100%] opacity-30"></div>
                    </div>
                </div>
            </div>

            <div id="pipeline" class="md:col-span-12 bg-slate-900/40 border border-slate-800 rounded-3xl p-10">
                <span class="text-[10px] font-mono text-indigo-500 uppercase tracking-[0.3em] mb-4 block">Execution Architecture</span>
                <h3 class="text-4xl font-bold text-white mb-10">The Dual-Model Process</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="flex gap-6">
                        <div class="shrink-0 w-12 h-12 rounded-xl bg-slate-950 border border-slate-800 flex items-center justify-center text-xl font-black text-indigo-500">
                            01
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-white mb-2 italic">Phase I: The Observer</h4>
                            <p class="text-slate-400 leading-relaxed">A local <strong>Vision Model</strong> (LLaVA) analyzes the image to generate a text report of its contents, including objects, text, and overall style.</p>
                        </div>
                    </div>

                    <div class="flex gap-6">
                        <div class="shrink-0 w-12 h-12 rounded-xl bg-slate-950 border border-slate-800 flex items-center justify-center text-xl font-black text-purple-500">
                            02
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-white mb-2 italic">Phase II: The Judge</h4>
                            <p class="text-slate-400 leading-relaxed">A <strong>Reasoning Model</strong> processes that report and makes the final classification based strictly on the user's logic rules.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="workflow" class="py-24 bg-slate-900/20 border-y border-slate-800/50">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-black text-white mb-16 uppercase tracking-widest">Processing Sequence</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="group">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ph ph-folder-plus text-2xl"></i>
                    </div>
                    <div class="relative">
                        <div class="text-6xl font-black text-slate-800 absolute -top-10 left-1/2 -translate-x-1/2 -z-10">01</div>
                        <h4 class="text-indigo-500 font-mono text-xs mb-2 tracking-[0.3em]">INIT_ALBUM</h4>
                        <p class="text-white font-bold">Create Album</p>
                        <p class="text-xs">Establish the high-level container.</p>
                    </div>
                </div>

                <div class="group">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ph ph-command text-2xl text-indigo-500"></i>
                    </div>
                    <div class="relative">
                        <div class="text-6xl font-black text-slate-800 absolute -top-10 left-1/2 -translate-x-1/2 -z-10">02</div>
                        <h4 class="text-indigo-500 font-mono text-xs mb-2 tracking-[0.3em]">DEFINE_RULES</h4>
                        <p class="text-white font-bold">Decision Logic</p>
                        <p class="text-xs">Configure the sorting prompts.</p>
                    </div>
                </div>

                <div class="group">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ph ph-upload-simple text-2xl"></i>
                    </div>
                    <div class="relative">
                        <div class="text-6xl font-black text-slate-800 absolute -top-10 left-1/2 -translate-x-1/2 -z-10">03</div>
                        <h4 class="text-indigo-500 font-mono text-xs mb-2 tracking-[0.3em]">UPLOAD_BATCH</h4>
                        <p class="text-white font-bold">Queue Vision</p>
                        <p class="text-xs">Submit images for analysis.</p>
                    </div>
                </div>

                <div class="group">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ph ph-file-zip text-2xl text-purple-500"></i>
                    </div>
                    <div class="relative">
                        <div class="text-6xl font-black text-slate-800 absolute -top-10 left-1/2 -translate-x-1/2 -z-10">04</div>
                        <h4 class="text-indigo-500 font-mono text-xs mb-2 tracking-[0.3em]">ZIP_EXPORT</h4>
                        <p class="text-white font-bold">Download Asset</p>
                        <p class="text-xs">Export the organized file structure.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 px-6 text-center border-t border-slate-900">
        <h2 class="text-4xl font-bold text-white mb-6">Technical Implementation</h2>
        <p class="text-slate-400 mb-10 max-w-xl mx-auto italic">Built with Laravel 12 and integrated with the Ollama API for high-performance, local-first artificial intelligence.</p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="https://github.com" class="px-8 py-4 bg-white text-slate-950 font-bold rounded-xl hover:bg-slate-200 hover:scale-105 transition-all flex items-center justify-center gap-2">
                <i class="ph-bold ph-github-logo"></i>
                View Documentation
            </a>

            <a href="{{ route('register') }}" class="px-8 py-4 bg-slate-900 text-white border border-slate-700 rounded-xl hover:bg-slate-800 hover:border-indigo-500 transition-all flex items-center justify-center">
                Access Web Console
            </a>

        </div>
    </section>

    <footer class="py-12 px-6 border-t border-slate-900 text-center">
        <div class="flex items-center justify-center gap-2 mb-4">
            <span class="text-white font-bold tracking-tighter text-sm uppercase">SmartSorter AI</span>
        </div>
        <p class="text-[9px] font-mono uppercase tracking-[0.4em] text-slate-600">Local Inference &bull; Private &bull; 2026</p>
    </footer>

</body>

</html>
