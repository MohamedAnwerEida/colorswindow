@if ($paginator->hasPages())
{{-- Previous Page Link --}}
@if ($paginator->onFirstPage())

@else
<a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">السابق</a>
@endif

{{-- Pagination Elements --}}
@foreach ($elements as $element)
{{-- "Three Dots" Separator --}}
@if (is_string($element))
<span>{{ $element }}</span>
@endif

{{-- Array Of Links --}}
@if (is_array($element))
@foreach ($element as $page => $url)
@if ($page == $paginator->currentPage())
<span class="current">{{ $page }}</span>
@else
<a href="{{ $url }}" class="page" title="{{ $page }}">{{ $page }}</a>
@endif
@endforeach
@endif
@endforeach

{{-- Next Page Link --}}
@if ($paginator->hasMorePages())
<a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">التالي</a>
@else

@endif
@endif
