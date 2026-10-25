@if ($paginator->hasPages())
<nav class="pagination" aria-label="Pages">
    @if ($paginator->onFirstPage())
        <span class="pg is-disabled"><x-icon name="chevron-left" :size="16" /></span>
    @else
        <a class="pg" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous"><x-icon name="chevron-left" :size="16" /></a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))<span class="pg is-disabled">{{ $element }}</span>@endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="pg is-current" aria-current="page">{{ $page }}</span>
                @else
                    <a class="pg" href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a class="pg" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next"><x-icon name="chevron-right" :size="16" /></a>
    @else
        <span class="pg is-disabled"><x-icon name="chevron-right" :size="16" /></span>
    @endif
</nav>
@endif
