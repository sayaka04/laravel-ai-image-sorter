    <nav class="fixed top-0 w-full z-50 border-b border-slate-800/50 bg-slate-950/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center">
                    <i class="ph ph-aperture"></i>
                </div>
                <span class="text-white font-bold tracking-tighter text-xl">SmartSorter<span class="text-indigo-500">AI</span></span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-[11px] font-mono uppercase tracking-[0.2em]">
                @if(Request::is('/'))
                <a href="#logic" class="hover:text-indigo-400 transition-colors">How it Works</a>
                <a href="#pipeline" class="hover:text-indigo-400 transition-colors">The Queue</a>
                @else
                <a href="{{ url('/#logic') }}" class="hover:text-indigo-400 transition-colors">How it Works</a>
                <a href="{{ url('/#pipeline') }}" class="hover:text-indigo-400 transition-colors">The Queue</a>
                @endif
                <span class="text-slate-700">|</span>
                <a href="https://github.com" class="hover:text-white transition-colors flex items-center gap-1"><i class="ph ph-github-logo text-lg"></i> Code</a>
            </div>
            <div class="flex items-center gap-4">
                @if(!Auth::user())
                <a href="{{ route('login') }}" class="text-sm font-semibold text-white hover:text-indigo-400">Sign In</a>
                <a href="{{ route('register') }}" class="bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 px-4 py-2 rounded-md text-sm font-bold transition-all">Create Account</a>
                @else
                <a href="{{ route('dashboard') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-md text-sm font-bold transition-all">Dashboard</a>
                @endif
            </div>
        </div>
    </nav>