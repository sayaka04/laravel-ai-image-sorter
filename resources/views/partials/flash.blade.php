<div class="space-y-4 my-6">

    {{-- SUCCESS: Cyberpunk Green --}}
    @if (session('success'))
    <div id="alert-success" class="relative overflow-hidden rounded-lg border border-green-500/20 bg-slate-900/90 backdrop-blur shadow-[0_0_20px_-5px_rgba(74,222,128,0.15)] transition-all duration-500">
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500 shadow-[0_0_10px_rgba(74,222,128,0.8)]"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-green-500/5 to-transparent pointer-events-none"></div>

        <div class="relative flex items-center gap-4 p-4 pl-6">
            <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-green-500/10 border border-green-500/20 text-green-400 shadow-[0_0_10px_-2px_rgba(74,222,128,0.3)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-green-400 uppercase tracking-wider mb-0.5">System Success</h3>
                <p class="text-sm text-slate-300 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="dismissAlert('alert-success')" class="text-slate-500 hover:text-white transition-colors p-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    {{-- ERROR: Critical Failure Red --}}
    @if (session('error'))
    <div id="alert-error" class="relative overflow-hidden rounded-lg border border-red-500/20 bg-slate-900/90 backdrop-blur shadow-[0_0_20px_-5px_rgba(248,113,113,0.15)] transition-all duration-500">
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500 shadow-[0_0_10px_rgba(248,113,113,0.8)]"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-red-500/5 to-transparent pointer-events-none"></div>

        <div class="relative flex items-center gap-4 p-4 pl-6">
            <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 shadow-[0_0_10px_-2px_rgba(248,113,113,0.3)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-red-400 uppercase tracking-wider mb-0.5">Critical Error</h3>
                <p class="text-sm text-slate-300 font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="dismissAlert('alert-error')" class="text-slate-500 hover:text-white transition-colors p-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    {{-- WARNING: High Voltage Amber --}}
    @if (session('warning'))
    <div id="alert-warning" class="relative overflow-hidden rounded-lg border border-amber-500/20 bg-slate-900/90 backdrop-blur shadow-[0_0_20px_-5px_rgba(251,191,36,0.15)] transition-all duration-500">
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-500 shadow-[0_0_10px_rgba(251,191,36,0.8)]"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-amber-500/5 to-transparent pointer-events-none"></div>

        <div class="relative flex items-center gap-4 p-4 pl-6">
            <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 shadow-[0_0_10px_-2px_rgba(251,191,36,0.3)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-amber-400 uppercase tracking-wider mb-0.5">Warning</h3>
                <p class="text-sm text-slate-300 font-medium">{{ session('warning') }}</p>
            </div>
            <button onclick="dismissAlert('alert-warning')" class="text-slate-500 hover:text-white transition-colors p-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    {{-- INFO: Data Stream Blue --}}
    @if (session('info'))
    <div id="alert-info" class="relative overflow-hidden rounded-lg border border-indigo-500/20 bg-slate-900/90 backdrop-blur shadow-[0_0_20px_-5px_rgba(99,102,241,0.15)] transition-all duration-500">
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.8)]"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/5 to-transparent pointer-events-none"></div>

        <div class="relative flex items-center gap-4 p-4 pl-6">
            <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 shadow-[0_0_10px_-2px_rgba(99,102,241,0.3)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-indigo-400 uppercase tracking-wider mb-0.5">System Info</h3>
                <p class="text-sm text-slate-300 font-medium">{{ session('info') }}</p>
            </div>
            <button onclick="dismissAlert('alert-info')" class="text-slate-500 hover:text-white transition-colors p-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    {{-- VALIDATION ERRORS: Terminal Style List --}}
    @if ($errors->any())
    <div id="alert-validation" class="relative overflow-hidden rounded-lg border border-red-500/30 bg-slate-950/95 backdrop-blur shadow-[0_0_20px_-5px_rgba(248,113,113,0.15)] transition-all duration-500">
        <div class="bg-red-500/10 border-b border-red-500/20 px-4 py-2 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                <span class="text-xs font-bold text-red-400 uppercase tracking-widest font-mono">Input Validation Failed</span>
            </div>
            <button onclick="dismissAlert('alert-validation')" class="text-red-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-4 bg-gradient-to-b from-red-500/5 to-transparent">
            <ul class="space-y-2">
                @foreach ($errors->all() as $error)
                <li class="flex items-start gap-3 text-sm text-slate-300 group">
                    <span class="text-red-500 mt-0.5 font-mono group-hover:text-red-400 transition-colors">></span>
                    <span class="group-hover:text-white transition-colors">{{ $error }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

</div>

{{-- Vanilla JS for dismissal --}}
<script>
    function dismissAlert(id) {
        const element = document.getElementById(id);
        if (element) {
            // Add fade out and slide up effect
            element.style.opacity = '0';
            element.style.transform = 'translateY(-10px)';
            // Wait for transition then remove
            setTimeout(() => {
                element.style.display = 'none';
            }, 500);
        }
    }
</script>