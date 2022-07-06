<div>
    <nav class="chapter__menu page-nav">
        <ul class="page-nav__list">
            @foreach($items as $item)
                <li class="page-nav__item">
                    @if(Request::url() == $item->url)
                        <a class="page-nav__link active" title="{{ $item->name }}">{{ $item->name }}</a>
                    @else
                        <a class="page-nav__link" href="{{ $item->url }}" title="{{ $item->name }}">{{ $item->name }}</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
</div>
