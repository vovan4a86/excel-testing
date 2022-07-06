@if($paginator instanceof \Illuminate\Pagination\LengthAwarePaginator
    && $paginator->hasPages()
    && $paginator->lastPage() > 1)
	<? /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */  ?>
    <div class="paginations">
        @if ($paginator->currentPage() > 1)
            <a href="{{ $paginator->previousPageUrl() }}" class="prev"><</a>
        @endif
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            @if ($i == $paginator->currentPage())
                <span>{{ $i }}</span>
            @else
                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
            @endif
        @endfor
        @if ($paginator->currentPage() < $paginator->lastPage())
            <a href="{{ $paginator->nextPageUrl() }}" class="next">></a>
        @endif
    </div>
@endif