@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 w-full">
        <div class="text-sm text-on-surface-variant font-medium">
            Menampilkan <span class="font-bold text-on-surface">{{ $paginator->firstItem() }}</span> hingga <span class="font-bold text-on-surface">{{ $paginator->lastItem() }}</span> dari <span class="font-bold text-on-surface">{{ $paginator->total() }}</span> data
        </div>
        <div class="join shadow-none">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button class="join-item btn btn-sm bg-slate-50 border-slate-200 text-slate-300 cursor-not-allowed shadow-none" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="join-item btn btn-sm bg-white border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <button class="join-item btn btn-sm bg-slate-50 border-slate-200 text-slate-400 cursor-not-allowed shadow-none" disabled>{{ $element }}</button>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="join-item btn btn-sm bg-primary border-primary text-on-primary hover:bg-primary/90 shadow-none">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}" class="join-item btn btn-sm bg-white border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-none">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn btn-sm bg-white border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            @else
                <button class="join-item btn btn-sm bg-slate-50 border-slate-200 text-slate-300 cursor-not-allowed shadow-none" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            @endif
        </div>
    </div>
@else
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 w-full">
        <div class="text-sm text-on-surface-variant font-medium">
            Menampilkan <span class="font-bold text-on-surface">{{ $paginator->count() }}</span> dari <span class="font-bold text-on-surface">{{ $paginator->total() }}</span> data
        </div>
    </div>
@endif
