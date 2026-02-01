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

        <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-white">
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                <div class="max-w-xl">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Categories</h1>
                    <p class="text-slate-500 font-medium mt-2 leading-relaxed">
                        Categories define the logic your AI uses to organize files. Each category uses
                        <span class="text-indigo-600 font-bold">AI Rules</span> to automatically identify and sort your media.
                    </p>
                </div>

                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="hidden lg:flex flex-col items-end pr-4 border-r border-slate-100">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Engine Status</span>
                        <span class="text-xs font-bold text-emerald-500 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Active & Learning
                        </span>
                    </div>
                    <a href="{{ route('categories.create') }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-slate-900 hover:bg-indigo-600 text-white px-6 py-3.5 rounded-2xl font-bold transition-all shadow-lg shadow-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New Category
                    </a>
                </div>
            </header>

            <div class="bg-white border border-slate-100 rounded-[2rem] md:rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px] border-collapse">
                        <thead>
                            <tr class="border-b border-slate-50 bg-slate-50/30">
                                <th class="text-left px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Category</th>
                                <th class="text-left px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Attached Album</th>
                                <th class="text-left px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">AI Sorting Rules</th>
                                <th class="px-8 py-5 text-right text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($categories as $category)
                            <tr class="group hover:bg-slate-50/50 transition-all duration-200">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                            {{ substr($category->category_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 leading-none mb-1">{{ $category->category_name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">ID: #{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-8 py-6">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100/50 text-slate-600 text-[11px] font-bold border border-slate-100">
                                        <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                        </svg>
                                        {{ $category->album->album_name ?? 'Unassigned' }}
                                    </span>
                                </td>

                                <td class="px-8 py-6">
                                    <div class="max-w-xs bg-slate-50/80 border border-slate-100 rounded-xl px-4 py-3 group-hover:bg-white transition-colors">
                                        <p class="text-xs text-slate-500 italic leading-relaxed line-clamp-2">
                                            @if($category->ai_rules)
                                            "{{ $category->ai_rules }}"
                                            @else
                                            <span class="text-slate-300 not-italic">No custom rules defined...</span>
                                            @endif
                                        </p>
                                    </div>
                                </td>

                                <td class="px-8 py-6">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Edit Logic">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('categories.show', $category) }}" class="px-4 py-2 text-[11px] font-black text-indigo-600 uppercase tracking-[0.1em] hover:bg-indigo-600 hover:text-white rounded-xl transition-all">
                                            Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-24 text-center">
                                    <div class="max-w-sm mx-auto">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-black text-slate-900">No Classification Rules</h3>
                                        <p class="text-slate-500 text-sm mt-2 leading-relaxed">The AI engine needs categories to know how to sort your images into the right folders.</p>
                                        <a href="{{ route('categories.create') }}" class="mt-8 inline-block bg-indigo-600 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">
                                            Get Started
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($categories->hasPages())
            <div class="mt-8 px-4">
                {{ $categories->links() }}
            </div>
            @endif
        </main>

    </div>

</body>

</html>