<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clean Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* --- SIDEBAR TRANSITIONS --- */
        #sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 16rem;
            /* Expanded width (w-64) */
        }

        /* Collapsed State (Desktop) */
        #sidebar.collapsed {
            width: 5rem;
            /* Collapsed width (w-20) */
        }

        /* Hide text smoothly */
        .link-text {
            transition: opacity 0.2s, width 0.2s;
            opacity: 1;
            white-space: nowrap;
            overflow: hidden;
        }

        #sidebar.collapsed .link-text {
            opacity: 0;
            width: 0;
        }

        /* Rotate Arrow */
        .toggle-arrow {
            transition: transform 0.3s;
        }

        #sidebar.collapsed .toggle-arrow {
            transform: rotate(180deg);
        }

        /* Mobile State */
        #sidebar.mobile-open {
            transform: translateX(0) !important;
        }
    </style>
</head>

<body class="bg-gray-50 flex h-screen overflow-hidden">

    <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-20 hidden opacity-0 transition-opacity duration-300 md:hidden"></div>

    <aside id="sidebar" class="bg-slate-900 text-white flex flex-col h-full fixed md:relative z-30 transform -translate-x-full md:translate-x-0 shadow-xl">

        <button id="toggle-btn" class="hidden md:flex absolute -right-3 top-8 bg-indigo-600 text-white rounded-full p-1 shadow-lg hover:bg-indigo-500 transition-colors z-50 items-center justify-center w-6 h-6">
            <i class="ph-bold ph-caret-left toggle-arrow text-xs"></i>
        </button>

        <div class="h-16 flex items-center shrink-0 border-b border-slate-800">
            <div class="w-20 shrink-0 flex items-center justify-center">
                <div class="w-8 h-8 rounded bg-indigo-600 flex items-center justify-center text-white">
                    <i class="ph ph-aperture"></i>
                </div>
            </div>
            <span class="font-bold text-lg tracking-wide link-text">SmartSorter AI</span>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 space-y-1">

            <a href="#" class="flex items-center h-12 hover:bg-slate-800 hover:text-indigo-400 transition-colors group relative">
                <div class="w-20 shrink-0 flex items-center justify-center text-xl text-slate-400 group-hover:text-indigo-400">
                    <i class="ph ph-squares-four"></i>
                </div>
                <span class="font-medium text-sm link-text">Dashboard</span>
            </a>

            <a href="#" class="flex items-center h-12 hover:bg-slate-800 hover:text-indigo-400 transition-colors group">
                <div class="w-20 shrink-0 flex items-center justify-center text-xl text-slate-400 group-hover:text-indigo-400">
                    <i class="ph ph-archive"></i>
                </div>
                <span class="font-medium text-sm link-text">Albums</span>
            </a>

            <a href="#" class="flex items-center h-12 hover:bg-slate-800 hover:text-indigo-400 transition-colors group">
                <div class="w-20 shrink-0 flex items-center justify-center text-xl text-slate-400 group-hover:text-indigo-400">
                    <i class="ph ph-images-square"></i>
                </div>
                <span class="font-medium text-sm link-text">Files</span>
            </a>

            <a href="#" class="flex items-center h-12 hover:bg-slate-800 hover:text-indigo-400 transition-colors group">
                <div class="w-20 shrink-0 flex items-center justify-center text-xl text-slate-400 group-hover:text-indigo-400">
                    <i class="ph ph-tag-simple"></i>
                </div>
                <span class="font-medium text-sm link-text">Categories</span>
            </a>

        </nav>

        <div class="border-t border-slate-800 shrink-0">
            <button class="w-full flex items-center h-16 hover:bg-slate-800 transition-colors text-left">
                <div class="w-20 shrink-0 flex items-center justify-center">
                    <img src="https://ui-avatars.com/api/?name=Alex+Doe&background=3730a3&color=fff" class="w-8 h-8 rounded-full">
                </div>
                <div class="link-text overflow-hidden pr-4">
                    <p class="text-sm font-semibold text-white">Alex Doe</p>
                    <p class="text-xs text-slate-500">View Profile</p>
                </div>
            </button>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">

        <header class="bg-white h-16 border-b border-gray-200 flex items-center justify-between px-4 sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <button id="mobile-menu-btn" class="md:hidden text-gray-500 hover:text-gray-900 p-1">
                    <i class="ph ph-list text-2xl"></i>
                </button>
                <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
            </div>

            <div class="flex items-center gap-4">
                <button class="p-2 text-gray-400 hover:text-indigo-600 transition-colors">
                    <i class="ph ph-bell text-xl"></i>
                </button>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">
                    New Project
                </button>
            </div>
        </header>

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

                    <section>
                        <div class="flex justify-between items-end mb-4">
                            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">01. Image Upload</h2>
                        </div>

                        <div class="w-full">
                            <label for="multi-upload" class="flex flex-col items-center justify-center w-full h-56 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-violet-50 hover:border-violet-500 hover:shadow-lg hover:shadow-violet-100/50 transition-all duration-300 group relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-transparent to-violet-100 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>

                                <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                                    <div class="w-14 h-14 rounded-full bg-white border border-slate-100 shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 group-hover:border-violet-200 group-hover:text-violet-600 transition-all duration-300">
                                        <i class="ph ph-images text-3xl text-slate-400 group-hover:text-violet-600"></i>
                                    </div>
                                    <p class="mb-1 text-lg font-medium text-slate-700 group-hover:text-slate-900 transition-colors">Upload project images</p>
                                    <p class="text-sm text-slate-500 group-hover:text-slate-600">PNG, JPG, WEBP (Select multiple)</p>
                                </div>
                                <input id="multi-upload" type="file" class="hidden" multiple accept="image/png, image/jpeg, image/webp" />
                            </label>

                            <div id="file-preview" class="mt-4 flex items-center gap-2 p-3 bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-100 text-sm font-medium hidden animate-pulse">
                                <i class="ph ph-check-circle text-lg"></i>
                                <span><span id="file-count">0</span> images selected ready for sorting.</span>
                            </div>
                        </div>
                    </section>

                    <script>
                        const input = document.getElementById('multi-upload');
                        const preview = document.getElementById('file-preview');
                        const countSpan = document.getElementById('file-count');

                        if (input) {
                            input.addEventListener('change', () => {
                                const count = input.files.length;
                                if (count > 0) {
                                    preview.classList.remove('hidden');
                                    countSpan.innerText = count;
                                } else {
                                    preview.classList.add('hidden');
                                }
                            });
                        }
                    </script>
                </div>
            </div>


        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggle-btn');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileOverlay = document.getElementById('mobile-overlay');

        // 1. Desktop Toggle
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // 2. Mobile Open
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.add('mobile-open');
            mobileOverlay.classList.remove('hidden');
            setTimeout(() => mobileOverlay.classList.remove('opacity-0'), 10);
        });

        // 3. Mobile Close
        function closeMobileMenu() {
            sidebar.classList.remove('mobile-open');
            mobileOverlay.classList.add('opacity-0');
            setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
        }

        mobileOverlay.addEventListener('click', closeMobileMenu);
    </script>
</body>

</html>