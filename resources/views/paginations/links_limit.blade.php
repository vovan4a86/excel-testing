@if($paginator instanceof \Illuminate\Pagination\LengthAwarePaginator
    && $paginator->hasPages()
    && $paginator->lastPage() > 1)
	<? /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */  ?>

	<?php
	// config
	$link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
	$half_total_links = floor($link_limit / 2);
	$from = $paginator->currentPage() - $half_total_links;
	$to = $paginator->currentPage() + $half_total_links;
	if ($paginator->currentPage() < $half_total_links) {
		$to += $half_total_links - $paginator->currentPage();
	}
	if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
		$from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
	}
	?>

    @if ($paginator->lastPage() > 1)
        <div class="paginations">
            @if ($paginator->currentPage() > 1)
                <a href="{{ $paginator->previousPageUrl() }}" class="prev">
                    <svg width="11" height="27" viewBox="0 0 6 14" fill="#000" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 7L0 14.003V-0.0039978L6 7Z"></path>
                    </svg>
                </a>
            @endif
            @if($from > 1)
                <a href="{{ $paginator->url(1) }}">{{ 1 }}</a>
                <a>...</a>
            @endif

            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @if ($from < $i && $i < $to)
                    @if ($i == $paginator->currentPage())
                        <span>{{ $i }}</span>
                    @else
                        <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    @endif
                @endif
            @endfor
            @if($to < $paginator->lastPage())
                <a>...</a>
                <a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
            @endif
            @if ($paginator->currentPage() < $paginator->lastPage())
                <a href="{{ $paginator->nextPageUrl() }}" class="next">
                    <svg width="11" height="27" viewBox="0 0 6 14" fill="#000" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 7L0 14.003V-0.0039978L6 7Z"></path>
                    </svg>
                </a>
            @endif
        </div>
    @endif
@endif


