<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | SmartSorter AI</title>
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
                <a href="{{ route('login') }}" class="text-sm font-semibold text-white hover:text-indigo-400">Sign In</a>
                <a href="{{ route('register') }}" class="bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 px-4 py-2 rounded-md text-sm font-bold transition-all">Create Account</a>
            </div>
        </div>
    </nav>

    <main class="relative min-h-screen w-full flex items-center justify-center px-6 pt-20 overflow-hidden">

        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[600px] bg-gradient-to-b from-indigo-500/10 via-transparent to-transparent blur-3xl opacity-50 pointer-events-none"></div>

        <div class="w-full max-w-md bg-slate-900/40 border border-slate-800 rounded-3xl p-8 md:p-10 backdrop-blur-sm relative z-10 shadow-2xl shadow-indigo-900/10">

            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center mx-auto mb-4 text-indigo-500">
                    <i class="ph-bold ph-lock-key text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Reset Password</h1>
                <p class="text-sm text-slate-400 leading-relaxed">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
                </p>
            </div>

            @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-sm font-semibold text-center">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-[11px] font-mono uppercase tracking-widest text-slate-500 mb-2">Email Address</label>
                    <input id="email"
                        class="block w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all sm:text-sm"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="you@example.com" />

                    @error('email')
                    <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-900/20 flex items-center justify-center gap-2 uppercase tracking-tight text-sm mb-6">
                    <i class="ph-bold ph-paper-plane-right"></i>
                    {{ __('Email Password Reset Link') }}
                </button>

                <div class="text-center">
                    <a class="text-xs font-mono uppercase tracking-widest text-slate-500 hover:text-white transition-colors" href="{{ route('login') }}">
                        <i class="ph-bold ph-arrow-left mr-1"></i> Back to Login
                    </a>
                </div>

            </form>
        </div>
    </main>

    <footer class="absolute bottom-6 w-full text-center">
        <p class="text-[9px] font-mono uppercase tracking-[0.4em] text-slate-600">SmartSorter AI &bull; Account Recovery</p>
    </footer>

</body>

</html>