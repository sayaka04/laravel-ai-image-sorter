<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | SmartSorter AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @include('partials.assets')

</head>

<body class="bg-slate-950 text-slate-400 font-sans selection:bg-indigo-500 selection:text-slate-950 antialiased">

    <nav class="fixed top-0 w-full z-50 border-b border-slate-800/50 bg-slate-950/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center">
                    <i class="ph-bold ph-terminal text-white text-xl"></i>
                </div>
                <span class="text-white font-bold tracking-tighter text-xl">SmartSorter<span class="text-indigo-500">AI</span></span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-[11px] font-mono uppercase tracking-[0.2em]">
                <a href="/" class="hover:text-indigo-400 transition-colors">Home</a>
                <a href="/#logic" class="hover:text-indigo-400 transition-colors">How it Works</a>
                <span class="text-slate-700">|</span>
                <a href="https://github.com" class="hover:text-white transition-colors flex items-center gap-1"><i class="ph ph-github-logo text-lg"></i> Code</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs font-mono text-slate-500">{{ Auth::user()->name ?? 'Account Pending' }}</span>
            </div>
        </div>
    </nav>

    <main class="relative min-h-screen w-full flex items-center justify-center px-6 pt-20 overflow-hidden">

        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[600px] bg-gradient-to-b from-indigo-500/10 via-transparent to-transparent blur-3xl opacity-50 pointer-events-none"></div>

        <div class="w-full max-w-lg bg-slate-900/40 border border-slate-800 rounded-3xl p-8 md:p-10 backdrop-blur-sm relative z-10 shadow-2xl shadow-indigo-900/10">

            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-indigo-500/10 border border-indigo-500/20 rounded-xl flex items-center justify-center mx-auto mb-4 text-indigo-500">
                    <i class="ph-duotone ph-envelope-simple-open text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-4">Check your inbox.</h1>
                <p class="text-sm text-slate-400 leading-relaxed">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
            <div class="mb-8 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-mono text-center tracking-wide flex items-center justify-center gap-2">
                <i class="ph-bold ph-check-circle text-lg"></i>
                {{ __('A NEW LINK HAS BEEN SENT TO YOUR EMAIL.') }}
            </div>
            @endif

            <div class="flex flex-col gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-900/20 flex items-center justify-center gap-2 uppercase tracking-tight text-sm">
                        <i class="ph-bold ph-paper-plane-tilt"></i>
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center text-xs font-mono uppercase tracking-widest text-slate-500 hover:text-white transition-colors py-2">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>

        </div>
    </main>

    <footer class="absolute bottom-6 w-full text-center">
        <p class="text-[9px] font-mono uppercase tracking-[0.4em] text-slate-600">SmartSorter AI &bull; Pending Activation</p>
    </footer>

</body>

</html>