<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SortAI - App Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* --- SIDEBAR BASE STYLES --- */
        #sidebar {
            width: 17rem;
            /* Smoothly animate width (desktop) and position (mobile) */
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* --- DESKTOP: COLLAPSED STATE --- */
        #sidebar.collapsed {
            width: 5rem;
        }

        /* Hide Text Elements smoothly when collapsed */
        .sidebar-text {
            transition: opacity 0.2s, transform 0.2s;
            opacity: 1;
            white-space: nowrap;
        }

        #sidebar.collapsed .sidebar-text {
            opacity: 0;
            pointer-events: none;
            display: none;
        }

        /* Center Icons when collapsed */
        #sidebar.collapsed .nav-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        #sidebar.collapsed .nav-item i {
            margin-right: 0;
        }

        /* Rotate Toggle Button */
        #toggleIcon {
            transition: transform 0.3s;
        }

        #sidebar.collapsed #toggleIcon {
            transform: rotate(180deg);
        }

        /* Center Logo when collapsed */
        .logo-container {
            transition: all 0.3s;
        }

        #sidebar.collapsed .logo-container {
            justify-content: center;
            padding: 0;
        }

        /* --- MOBILE: SLIDE-IN STATE --- */
        /* By default on mobile, sidebar is translated -100% (off screen) via Tailwind classes below.
           This class brings it back. */
        #sidebar.mobile-open {
            transform: translateX(0) !important;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 flex h-screen overflow-hidden">

    <div id="mobileOverlay" class="fixed inset-0 bg-slate-900/50 z-30 hidden md:hidden transition-opacity opacity-0"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 bg-slate-900 text-slate-300 flex flex-col h-full shadow-xl 
               transform -translate-x-full md:translate-x-0 md:relative md:flex-shrink-0">

        <button id="desktopToggleBtn" class="hidden md:flex absolute -right-3 top-7 z-50 w-6 h-6 bg-slate-800 border border-slate-600 rounded-full text-slate-400 hover:text-white items-center justify-center shadow-md transition-colors focus:outline-none">
            <i id="toggleIcon" class="ph ph-caret-left text-xs font-bold"></i>
        </button>

        <button id="mobileCloseBtn" class="md:hidden absolute right-4 top-4 text-slate-400 hover:text-white">
            <i class="ph ph-x text-2xl"></i>
        </button>

        <div class="h-20 flex items-center px-6 shrink-0 logo-container overflow-hidden">
            <a href="/" class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-600 to-indigo-600 flex items-center justify-center text-white shrink-0 shadow-lg shadow-violet-900/50">
                    <i class="ph ph-aperture text-lg font-bold"></i>
                </div>
                <span class="logo-text font-bold text-lg tracking-tight text-white sidebar-text">SortAI</span>
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <div class="px-3 mb-2 mt-2 text-[10px] font-bold uppercase tracking-wider text-slate-500 sidebar-text">Main</div>

            <a href="#" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl bg-violet-600 text-white shadow-lg shadow-violet-900/20 group">
                <i class="ph ph-squares-four text-xl shrink-0"></i>
                <span class="sidebar-text font-medium text-sm">Dashboard</span>
            </a>

            <a href="#" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/5 hover:text-white transition-all group">
                <i class="ph ph-folder-open text-xl shrink-0 group-hover:text-violet-400 transition-colors"></i>
                <span class="sidebar-text font-medium text-sm">All Files</span>
            </a>

            <a href="#" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/5 hover:text-white transition-all group">
                <i class="ph ph-gear text-xl shrink-0 group-hover:text-violet-400 transition-colors"></i>
                <span class="sidebar-text font-medium text-sm">Settings</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/5 shrink-0">
            <button class="flex items-center gap-3 w-full nav-item group">
                <img src="https://ui-avatars.com/api/?name=Admin+User&background=334155&color=fff" class="w-8 h-8 rounded-full border border-slate-600 shrink-0">
                <div class="sidebar-text text-left overflow-hidden">
                    <p class="text-sm font-medium text-white truncate">Admin User</p>
                    <p class="text-xs text-slate-500 truncate">Pro Plan</p>
                </div>
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden relative bg-white">

        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-4 md:px-8 shrink-0 z-10 sticky top-0">
            <div class="flex items-center gap-3">
                <button id="mobileMenuBtn" class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-md focus:outline-none">
                    <i class="ph ph-list text-2xl"></i>
                </button>

                <div class="flex items-center gap-2 text-slate-400 text-sm">
                    <span class="hidden md:inline">SortAI</span>
                    <span class="hidden md:inline">/</span>
                    <span class="text-slate-800 font-medium">Dashboard</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button class="text-slate-400 hover:text-violet-600 transition-colors"><i class="ph ph-bell text-xl"></i></button>
                <button class="hidden md:block bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-800 transition-colors">Export Report</button>
            </div>
        </header>

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

                <section>
                    <div class="flex justify-between items-end mb-4">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">02. File Status</h2>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-5 hover:bg-slate-50 flex items-center justify-between group cursor-pointer border-b border-slate-100 last:border-0 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center flex-shrink-0">
                                    <i class="ph ph-file-pdf text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-slate-800">Financial_Report_Q3.pdf</h4>
                                    <p class="text-xs text-slate-500">2.4 MB • Uploaded 2m ago</p>
                                </div>
                            </div>
                            <span class="hidden sm:flex px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100 items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Analyzing
                            </span>
                        </div>
                        <div class="p-5 hover:bg-slate-50 flex items-center justify-between group cursor-pointer border-b border-slate-100 last:border-0 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 border border-violet-100 flex items-center justify-center flex-shrink-0">
                                    <i class="ph ph-image text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-slate-800">Landing_Page_V2.png</h4>
                                    <p class="text-xs text-slate-500">1.8 MB • Sorted into "Design"</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="hidden sm:flex px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100 items-center gap-1.5">
                                    <i class="ph ph-check"></i> Sorted
                                </span>
                                <button class="text-slate-400 hover:text-slate-600"><i class="ph ph-dots-three-vertical font-bold"></i></button>
                            </div>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="flex justify-between items-end mb-4">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">03. Actions</h2>
                    </div>
                    <div class="flex flex-wrap gap-4 p-6 bg-white rounded-2xl border border-slate-200 shadow-sm">
                        <button class="px-5 py-2.5 bg-slate-900 text-white text-sm font-medium rounded-xl hover:bg-slate-800 shadow-lg shadow-slate-900/20 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                            <i class="ph ph-magic-wand text-lg"></i> Start Sorting
                        </button>
                        <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all">
                            View Documentation
                        </button>
                        <button class="px-4 py-2.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors ml-auto">
                            <i class="ph ph-trash text-lg"></i>
                        </button>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <script>
        // ELEMENTS
        const sidebar = document.getElementById('sidebar');
        const desktopToggleBtn = document.getElementById('desktopToggleBtn');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileCloseBtn = document.getElementById('mobileCloseBtn');
        const mobileOverlay = document.getElementById('mobileOverlay');

        // 1. DESKTOP: Collapse/Expand Sidebar
        desktopToggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // 2. MOBILE: Open Sidebar
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.add('mobile-open');
            mobileOverlay.classList.remove('hidden');
            // Small delay to allow display:block to apply before opacity transition
            setTimeout(() => {
                mobileOverlay.classList.remove('opacity-0');
            }, 10);
        });

        // 3. MOBILE: Close Sidebar (via X button or Overlay click)
        function closeMobileSidebar() {
            sidebar.classList.remove('mobile-open');
            mobileOverlay.classList.add('opacity-0');
            setTimeout(() => {
                mobileOverlay.classList.add('hidden');
            }, 300); // Wait for fade out
        }

        mobileCloseBtn.addEventListener('click', closeMobileSidebar);
        mobileOverlay.addEventListener('click', closeMobileSidebar);

        // 4. MULTI-UPLOAD LOGIC
        const input = document.getElementById('multi-upload');
        const preview = document.getElementById('file-preview');
        const countSpan = document.getElementById('file-count');

        input.addEventListener('change', () => {
            const count = input.files.length;
            if (count > 0) {
                preview.classList.remove('hidden');
                countSpan.innerText = count;
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
</body>

</html>