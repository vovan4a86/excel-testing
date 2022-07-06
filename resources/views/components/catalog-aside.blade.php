<aside class="aside">
    <nav class="aside-nav">
        @foreach($catalogs as $catalog)
            <div class="aside-nav__container {{ $catalog->public_children_on_menu->count() ? 'js-aside': '' }} {!! $catalog->isActive ? 'showed-up': '' !!}">
                <a class="aside-nav__title" href="{{ $catalog->url }}" aria-label="Показать меню">{{ $catalog->name }}</a>
                @if($catalog->public_children->count())
                    <ul class="aside-nav__list">
                        @foreach($catalog->public_children_on_menu as $child)
                            <li class="aside-nav__item">
                                <a class="aside-nav__link active" href="{{ $child->url }}" title="{{ $child->name }}">{{ $child->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
            <a class="aside-nav__title" href="{{ route('publications.index') }}" aria-label="Показать меню">Статьи</a>
    </nav>
    @if(Request::is('prod*'))
        <div class="aside-links">
            <ul>
                <li>
                    <a href="{{ route('stocks') }}">В наличии на складе</a>
                </li>
            </ul>
        </div>
    @endif


    <div class="aside-questions">
        <div class="aside-questions__container">
            <div class="aside-questions__title">Остались вопросы? Пишите, ответим в ближайшее время!</div>
            <a class="btn popup" href="#question">Отправить сообщение</a>
        </div>
    </div>
    <!--include ./_aside-map-->
</aside>
