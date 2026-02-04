@if ($paginator->hasPages())
@php
// CONFIGURATION: Set your limits here
$startLimit = 3; // "3 lowest pages"
$endLimit = 3; // "3 last numbers"
$midWindow = 1; // How many pages around the current page (1 means: 49 50 51)

$total = $paginator->lastPage();
$current = $paginator->currentPage();

// 1. Collect Fixed Start Pages (1, 2, 3)
$pages = range(1, min($startLimit, $total));

// 2. Collect Fixed End Pages (99, 100, 101)
$endStart = max($total - $endLimit + 1, 1);
$pages = array_merge($pages, range($endStart, $total));

// 3. Collect Middle Pages (Around current) to ensure we always see where we are
// If we didn't do this, page 50 would be invisible!
$midStart = max($current - $midWindow, 1);
$midEnd = min($current + $midWindow, $total);
$pages = array_merge($pages, range($midStart, $midEnd));

// 4. Sort and remove duplicates
$pages = array_unique($pages);
sort($pages);
@endphp

<div class="flex flex-col sm:flex-row items-center justify-between border-t border-slate-800 pt-4 gap-4 shrink-0">

    {{-- Info Text --}}
    <div class="text-xs text-slate-500 font-mono">
        Showing <span class="text-white">{{ $paginator->firstItem() }}</span>
        to <span class="text-white">{{ $paginator->lastItem() }}</span>
        of <span class="text-white">{{ $paginator->total() }}</span>
    </div>

    <div class="flex items-center gap-1">

        {{-- Previous Button --}}
        @if ($paginator->onFirstPage())
        <button disabled class="p-2 text-slate-700 cursor-not-allowed rounded transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="p-2 text-slate-500 hover:text-white hover:bg-slate-800 rounded transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        @endif

        {{-- Custom Page Numbers Loop --}}
        @foreach ($pages as $index => $page)

        {{-- Add "..." Separator if there is a gap between numbers --}}
        @if ($index > 0 && $page > $pages[$index - 1] + 1)
        <span class="w-8 h-8 flex items-center justify-center text-slate-600">...</span>
        @endif

        {{-- Page Links --}}
        @if ($page == $current)
        <span class="w-8 h-8 flex items-center justify-center text-sm font-medium rounded bg-ai-accent text-white shadow-[0_0_10px_-3px_rgba(99,102,241,0.5)]">
            {{ $page }}
        </span>
        @else
        <a href="{{ $paginator->url($page) }}" class="w-8 h-8 flex items-center justify-center text-sm font-medium rounded text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
            {{ $page }}
        </a>
        @endif

        @endforeach

        {{-- Next Button --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="p-2 text-slate-500 hover:text-white hover:bg-slate-800 rounded transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
        @else
        <button disabled class="p-2 text-slate-700 cursor-not-allowed rounded transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
        @endif

    </div>
</div>
@endif