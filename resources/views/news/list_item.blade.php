<div class="news__item">
    <div class="postcard">
        <a href="{{ $item->url }}" class="postcard__pic">
            <span class="postcard__picinn">
                @if($image = $item->thumb(2))
                    @if(Request::ajax())
                        <img src="{{ $image }}" alt="{{ $item->name }}">
                    @else
                        <img data-src="{{ $image }}"
                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                             alt="{{ $item->name }}" class="b-lazy">
                    @endif
                @endif
            </span>
        </a>
        <div class="postcard__body">
            <div class="postcard__tags tags">
                @foreach($item->tags as $tag)
                    <div class="tags__tag">{{ $tag->tag }}</div>
                @endforeach
            </div>
            <div class="postcard__date">{{ $item->dateFormat('d F Y') }}</div>
            <a href="{{ $item->url }}" class="postcard__name">{{ $item->name }}</a>
            <div class="postcard__descr">{{ $item->announce }}</div>
        </div>
    </div>
</div>