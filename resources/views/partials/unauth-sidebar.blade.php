    <nav class="fixed top-0 w-full z-50 border-b border-slate-800/50 bg-slate-950/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                            <path strokeLinecap="round" strokeLinejoin="round" d="m6.75 7.5 3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0 0 21 18V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v12a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </div>
                    <span class="text-white font-bold tracking-tighter text-xl">SmartSorter<span class="text-indigo-500">AI</span></span>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-8 text-[11px] font-mono uppercase tracking-[0.2em]">
                @if(Request::is('/home'))
                <a href="#logic" class="hover:text-indigo-400 transition-colors">How it Works</a>
                <a href="#pipeline" class="hover:text-indigo-400 transition-colors">The Queue</a>
                @else
                <a href="{{ url('/home#logic') }}" class="hover:text-indigo-400 transition-colors">How it Works</a>
                <a href="{{ url('/home#pipeline') }}" class="hover:text-indigo-400 transition-colors">The Queue</a>
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