<footer class="footer">
    <div class="container footer__container">
        <div class="footer__row">
            <div class="footer__logo">
                @if(Request::is('/'))
                    <img src="/static/images/common/logo.svg" alt="logo">
                @else
                    <a href="{{ url('/') }}">
                        <img src="/static/images/common/logo.svg" alt="logo">
                    </a>
                @endif
            </div>
            <div class="footer__nav">
                <nav class="nav" aria-label="Меню">
                    <ul class="nav__list">
                        @foreach($mainMenu as $mainMenuItem)
                            <li class="nav__item">
                                <a class="nav__link" href="{{ $mainMenuItem->url }}"
                                   title="{{ $mainMenuItem->name }}">{{ $mainMenuItem->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
        <div class="footer__grid">
            @if($item = Settings::get('footer_ekb_contact'))
                <div class="footer__column">
                    <div class="footer__title">{{ array_get($item, 'title') }}</div>
                    <div class="footer__address">{!! array_get($item, 'address') !!}</div>
                    @if($phone = array_get($item, 'phone'))
                        <div class="footer__phone">
                            <a href="tel:{{ clearPhone($phone) }}">{{ $phone }}</a>
                        </div>
                    @endif
                    <div class="footer__link">
                        <a class="btn popup popup-with-zoom-anim" href="#callback">Заказать звонок</a>
                    </div>
                    @if($email = array_get($item, 'email'))
                        <div class="footer__email">
                            <a href="mailto:{{ $email }}">{{ $email }}</a>
                        </div>
                    @endif
                </div>
            @endif
            @if($item = Settings::get('footer_chlb_contact'))
                <div class="footer__column">
                    <div class="footer__title">{{ array_get($item, 'title') }}</div>
                    <div class="footer__address">{!! array_get($item, 'subtit') !!}</div>
                    <div class="footer__address">{!! array_get($item, 'address') !!}</div>
                    @if($phone = array_get($item, 'phone'))
                        <div class="footer__phone">
                            <a href="tel:{{ clearPhone($phone) }}">{{ $phone }}</a>
                        </div>
                    @endif
                    @if($email = array_get($item, 'email'))
                        <div class="footer__email">
                            <a href="mailto:{{ $email }}">{{ $email }}</a>
                        </div>
                    @endif
                </div>
            @endif
            @if($item = Settings::get('footer_store_contact'))
                <div class="footer__column">
                    <div class="footer__title">{{ array_get($item, 'title') }}</div>
                    <div class="footer__address">{!! array_get($item, 'address') !!}</div>
                    <div class="footer__map">
                        <a class="map-open popup-with-zoom-anim" href="#map-dialog">Карта</a>
                    </div>
                    @if($phone = array_get($item, 'phone'))
                        <div class="footer__phone">
                            <a href="tel:{{ clearPhone($phone) }}">{{ $phone }}</a>
                        </div>
                    @endif
                    @if($email = array_get($item, 'email'))
                        <div class="footer__email">
                            <a href="mailto:{{ $email }}">{{ $email }}</a>
                        </div>
                    @endif
                </div>
            @endif
            <div class="footer__column">
                <nav class="footer__products" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="Продукция">
                    <ul itemprop="about" itemscope itemtype="https://schema.org/ItemList">
                        @foreach(Settings::get('footer_nav_link', []) as $item)
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ItemList">
                                <a href="{{ url(array_get($item, 'link')) }}" title="{{ array_get($item, 'text') }}" itemprop="url">{{ array_get($item, 'text') }}</a>
                                <meta itemprop="name" content="{{ array_get($item, 'text') }}">
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
        <div class="footer__copyright">
            <div class="footer__year">&copy; 2009-
                <span>{{ date('Y') }}</span>, ООО &laquo;Регионметпром&raquo;</div>
            <div class="footer__developer">Разработка и продвижение сайтов&nbsp;
                <a href="https://fanky.ru" target="_blank" rel="nofollow,noindex">Fanky.ru</a>
            </div>
            <a class="footer__policy policy" href="{{ url('policy') }}">Политика конфиденциальности</a>
        </div>
    </div>
    @if(!App::isLocal())
        {!! Settings::get('counters') !!}
    @endif
</footer>
