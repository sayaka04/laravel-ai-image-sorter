<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SmartSorter AI'}}</title>

    @include('partials.assets')

</head>

<body class="bg-gray-50 flex h-screen overflow-hidden">

    @include('partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        @include('partials.navbar')

        <main class="flex-1 overflow-y-auto p-6">

            <section class="min-h-[80vh] flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
                <div class="w-full max-w-2xl">
                    <a href="{{ route('albums.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors mb-8 group">
                        <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Collections
                    </a>

                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                        <div class="p-8 sm:p-12">
                            <header class="mb-10 text-center">
                                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Create New Album</h1>
                                <p class="text-slate-500 mt-2">Set up a smart container for your media and documents.</p>
                            </header>

                            <form action="{{ route('albums.store') }}" method="POST" class="space-y-8">
                                @csrf

                                <div class="relative group">
                                    <label for="album_name" class="block text-sm font-bold text-slate-700 mb-2 ml-1">
                                        Album Name
                                    </label>
                                    <input id="album_name" name="album_name" type="text" required
                                        value="{{ old('album_name') }}"
                                        class="block w-full px-5 py-4 bg-slate-50 border-transparent rounded-2xl text-slate-900 text-sm placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200"
                                        placeholder="e.g. 2026 Tax Season">

                                    @error('album_name')
                                    <div class="flex items-center mt-2 ml-1 text-red-500">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="text-xs font-medium">{{ $message }}</p>
                                    </div>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <div class="flex justify-between items-center mb-2 ml-1">
                                        <label for="description" class="block text-sm font-bold text-slate-700">
                                            Context (for AI)
                                        </label>
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-500 bg-indigo-50 px-2 py-1 rounded-md">Smart Sorting</span>
                                    </div>

                                    <div class="relative">
                                        <textarea id="description" name="description" rows="5"
                                            class="block w-full px-5 py-4 bg-slate-50 border-transparent rounded-2xl text-slate-900 text-sm placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 resize-none"
                                            placeholder="Tell the AI exactly what to look for. E.g. 'This is for my home renovation. Categorize by Plumbing, Electrical, and Material receipts.'">{{ old('description') }}</textarea>

                                        <div class="absolute bottom-4 right-4 opacity-40 pointer-events-none">
                                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <p class="mt-3 ml-1 text-xs text-slate-400 leading-relaxed">
                                        <span class="text-indigo-500 font-semibold">Pro tip:</span> Specificity wins. Mention keywords, dates, or file types you want prioritized.
                                    </p>
                                </div>

                                <div class="pt-4">
                                    <button type="submit"
                                        class="group relative w-full flex items-center justify-center py-4 px-6 border border-transparent rounded-2xl shadow-xl text-base font-bold text-white bg-slate-900 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                        <span class="absolute left-0 inset-y-0 flex items-center pl-6 transition-transform group-hover:translate-x-1">
                                            <svg class="h-5 w-5 text-indigo-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </span>
                                        Initialize Collection
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 text-center">
                            <p class="text-[11px] text-slate-400 uppercase tracking-widest font-semibold">Secure Encryption Enabled</p>
                        </div>
                    </div>
                </div>
            </section>

        </main>

    </div>

</body>

</html>