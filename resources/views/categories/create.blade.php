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

        <main class="flex-1 overflow-y-auto bg-white p-8">
            <div class="max-w-3xl mx-auto">

                <div class="mb-10">
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-3">New AI Category</h1>
                    <p class="text-lg text-slate-500 font-medium leading-relaxed">
                        Teach the AI how to recognize this type of file.
                        Once created, the system will automatically sort matching images here.
                    </p>
                </div>

                <form action="{{ route('categories.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="space-y-3">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                            Parent Album
                        </label>

                        @if(request('album_id'))
                        <input type="hidden" name="album_id" value="{{ request('album_id') }}">
                        <div class="flex items-center p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">Attached to Album ID: {{ request('album_id') }}</p>
                                <p class="text-xs text-slate-500 font-medium">This category will be exclusive to this album.</p>
                            </div>
                            <div class="ml-auto">
                                <span class="px-3 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-widest">Locked</span>
                            </div>
                        </div>
                        @else
                        <div class="relative group">
                            <select name="album_id" id="album_id" required
                                class="block w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl text-slate-900 text-sm font-bold appearance-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                                <option value="" disabled selected>Select an Album...</option>
                                @if(isset($albums))
                                @foreach($albums as $album)
                                <option value="{{ $album->id }}">{{ $album->album_name }}</option>
                                @endforeach
                                @else
                                <option value="" disabled>No albums loaded</option>
                                @endif
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-5 pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @if(!isset($albums))
                        <div class="mt-2">
                            <input type="number" name="album_id" placeholder="Or enter Album ID manually" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm">
                        </div>
                        @endif
                        @endif
                    </div>

                    <div class="space-y-3">
                        <label for="category_name" class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                            Category Name
                        </label>
                        <input type="text" name="category_name" id="category_name" required
                            class="block w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl text-slate-900 text-lg font-bold placeholder-slate-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all"
                            placeholder="e.g. Utility Bills, Design Screenshots, Pet Photos">
                        @error('category_name')
                        <p class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-end">
                            <label for="ai_rules" class="block text-xs font-black text-violet-500 uppercase tracking-[0.2em] ml-1">
                                AI Sorting Logic
                            </label>
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg">Natural Language Processing</span>
                        </div>

                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-violet-200 to-indigo-200 rounded-[1.6rem] blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                            <div class="relative bg-white rounded-2xl">
                                <textarea id="ai_rules" name="ai_rules" rows="5"
                                    class="block w-full px-6 py-5 bg-white border-0 rounded-2xl text-slate-600 text-base font-medium placeholder-slate-300 focus:ring-2 focus:ring-violet-500/20 resize-none leading-relaxed"
                                    placeholder="Describe what belongs here. Example: 'Look for images that contain dates, currency symbols, and logos like Electric Co or Water Dept. Also include screenshots of banking apps.'"></textarea>

                                <div class="absolute bottom-4 right-4">
                                    <div class="flex items-center gap-1.5 px-3 py-1.5 bg-violet-50 rounded-lg border border-violet-100">
                                        <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <span class="text-[10px] font-bold text-violet-700 uppercase tracking-wide">AI Powered</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 ml-1 font-medium">
                            The AI will use these instructions to analyze image text (OCR) and visual context.
                        </p>
                    </div>

                    <div class="pt-6 flex items-center gap-4">
                        <a href="{{ url()->previous() }}" class="px-6 py-4 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="flex-1 bg-slate-900 hover:bg-indigo-600 text-white text-base font-bold py-4 px-8 rounded-2xl shadow-xl shadow-slate-200 hover:shadow-indigo-200 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                            <span>Create Category</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>

                </form>
            </div>
        </main>

    </div>

</body>

</html>