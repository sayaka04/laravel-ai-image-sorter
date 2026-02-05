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

        <a href="{{ route('dashboard') }}" class="flex items-center h-12 hover:bg-slate-800 hover:text-indigo-400 transition-colors group relative">
            <div class="w-20 shrink-0 flex items-center justify-center text-xl text-slate-400 group-hover:text-indigo-400">
                <i class="ph ph-squares-four"></i>
            </div>
            <span class="font-medium text-sm link-text">Dashboard</span>
        </a>

        <a href="{{ route('albums.index') }}" class="flex items-center h-12 hover:bg-slate-800 hover:text-indigo-400 transition-colors group">
            <div class="w-20 shrink-0 flex items-center justify-center text-xl text-slate-400 group-hover:text-indigo-400">
                <i class="ph ph-archive"></i>
            </div>
            <span class="font-medium text-sm link-text">Albums</span>
        </a>

        <a href="{{ route('upload_queues.index') }}" class="flex items-center h-12 hover:bg-slate-800 hover:text-indigo-400 transition-colors group">
            <div class="w-20 shrink-0 flex items-center justify-center text-xl text-slate-400 group-hover:text-indigo-400">
                <i class="ph ph-queue"></i>
            </div>
            <span class="font-medium text-sm link-text">Queues</span>
        </a>

        <a href="{{ route('files.index') }}" class="flex items-center h-12 hover:bg-slate-800 hover:text-indigo-400 transition-colors group">
            <div class="w-20 shrink-0 flex items-center justify-center text-xl text-slate-400 group-hover:text-indigo-400">
                <i class="ph ph-images-square"></i>
            </div>
            <span class="font-medium text-sm link-text">Files</span>
        </a>

        <a href="{{ route('categories.index') }}" class="flex items-center h-12 hover:bg-slate-800 hover:text-indigo-400 transition-colors group">
            <div class="w-20 shrink-0 flex items-center justify-center text-xl text-slate-400 group-hover:text-indigo-400">
                <i class="ph ph-tag-simple"></i>
            </div>
            <span class="font-medium text-sm link-text">Categories</span>
        </a>

    </nav>

    <div class="border-t border-slate-800 shrink-0">

        <a href="{{ route('profile.edit') }}" class="w-full flex items-center h-16 hover:bg-slate-800 transition-colors text-left">
            <div class="w-20 shrink-0 flex items-center justify-center">
                <img src="https://ui-avatars.com/api/?name=Alex+Doe&background=3730a3&color=fff" class="w-8 h-8 rounded-full">
            </div>
            <div class="link-text overflow-hidden pr-4">
                <p class="text-sm font-semibold text-white">{{ Auth::user()->name}}</p>
                <p class="text-xs text-slate-500">View Profile</p>
            </div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center h-12 hover:bg-slate-800 hover:text-red-400 transition-colors group relative">
                <div class="w-20 shrink-0 flex items-center justify-center text-xl text-slate-500 group-hover:text-red-400">
                    <i class="ph ph-sign-out"></i>
                </div>
                <span class="font-medium text-sm text-slate-400 group-hover:text-red-400 link-text">
                    Log Out
                </span>
            </button>
        </form>

    </div>
</aside>