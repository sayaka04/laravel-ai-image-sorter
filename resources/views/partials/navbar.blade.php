        <header class="bg-slate-900 text-white h-16 border-b border-gray-200 flex items-center justify-between px-4 sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <button id="mobile-menu-btn" class="md:hidden text-gray-500 hover:text-gray-900 p-1">
                    <i class="ph ph-list text-2xl"></i>
                </button>
                <h1 class="text-xl font-semibold pl-2 ">{{$header_name ?? '\(^o^)/ Hello, I wonder what this page should be named?'}}</h1>
            </div>

            {{--
            <div class="flex items-center gap-4">
                <button class="p-2 text-gray-400 hover:text-indigo-600 transition-colors">
                    <i class="ph ph-bell text-xl"></i>
                </button>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">
                    New Project
                </button>
            </div>
            --}}
        </header>