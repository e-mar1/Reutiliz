@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex justify-center my-4">
        <ul class="flex items-center gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="inline-flex items-center justify-center h-10 w-10 min-w-[28px] rounded-md border border-gray-200 text-gray-300 bg-white cursor-not-allowed text-xs" aria-label="{{ __('pagination.previous') }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center justify-center h-10 w-10 min-w-[28px] rounded-md border border-gray-200 text-gray-500 bg-white hover:bg-blue-50 hover:text-blue-600 transition text-xs" aria-label="{{ __('pagination.previous') }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="inline-flex items-center justify-center h-10 w-10 min-w-[28px] rounded-md border border-gray-200 text-gray-400 bg-white text-xs">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="inline-flex items-center justify-center h-10 w-10 min-w-[28px] rounded-md border border-blue-200 bg-blue-50 text-blue-600 font-semibold text-xs">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="inline-flex items-center justify-center h-10 w-10 min-w-[28px] rounded-md border border-gray-200 text-gray-700 bg-white hover:bg-blue-50 hover:text-blue-700 transition text-xs" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center justify-center h-10 w-10 min-w-[28px] rounded-md border border-gray-200 text-gray-500 bg-white hover:bg-blue-50 hover:text-blue-600 transition text-xs" aria-label="{{ __('pagination.next') }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </li>
            @else
                <li>
                    <span class="inline-flex items-center justify-center h-10 w-10 min-w-[28px] rounded-md border border-gray-200 text-gray-300 bg-white cursor-not-allowed text-xs" aria-label="{{ __('pagination.next') }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
