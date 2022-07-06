<!-- .header--homepage только на главной-->
<header class="header {{ $headerClass }}">
    <div class="container header__container">
        <div class="header__name">
            @if(Request::is('/'))
                <img src="/static/images/common/logo.svg" alt="logo">
            @else
                <a href="{{ url('/') }}">
                    <img src="/static/images/common/logo.svg" alt="logo">
                </a>
            @endif
            <div class="header__label">{!! Settings::get('header_text') !!}</div>
        </div>
        @if($contacts = Settings::get('header_contacts', []))
            <div class="header__contacts">
                <div class="header__cities">
                    @foreach($contacts as $contact)
                        <div class="header__city{{ $loop->first ? ' header__city--active': '' }}"
                             data-code="{{ array_get($contact, 'code') }}"
                             data-phone="{{ array_get($contact, 'phone') }}"
                             data-link="{{ clearPhone('+7' . array_get($contact, 'code') . array_get($contact, 'phone')) }}">{{ array_get($contact, 'city') }}</div>
                    @endforeach
                </div>
                <div class="header__phones">
                    <div class="header__code">({{ array_get($contacts, '0.code') }})</div>
                    <div class="header__phone">
                        <a href="tel:{{ clearPhone('+7' . array_get($contacts, '0.code') . array_get($contacts, '0.phone')) }}">{{ array_get($contacts, '0.phone') }}</a>
                    </div>
                </div>
            </div>
        @endif
        @include('blocks.header_order')

    </div>
    <!-- .nav--homepage только на главной-->
    <nav class="nav {{ $navClass }}" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="Меню">
        <div class="container nav__container">
            <ul class="nav__list" itemprop="about" itemscope itemtype="https://schema.org/ItemList">
                @foreach($mainMenu as$mainMenuItem)
                    @if($mainMenuItem->alias == 'about')
                        <li class="nav__item has-child" itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList">
                            <a class="nav__link nav__link--sublinked" href="{{ $mainMenuItem->url }}" title="{{ $mainMenuItem->name }}" aria-label="{{ $mainMenuItem->name }}" itemprop="url">{{ $mainMenuItem->name }}</a>
                            <meta itemprop="name" content="Регионметпром">
                            <ul class="nav__sublist">
                                @foreach($aboutMenu as $aboutMenuItem)
                                    <li class="nav__subitem">
                                        <a class="nav__sublink" href="{{ $aboutMenuItem->url }}">{{ $aboutMenuItem->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="nav__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList">
                            <a class="nav__link {{ $mainMenuItem->isActive || $mainMenuItem->alias == 'sklad' ? 'nav__link--active': '' }}"
                               href="{{ $mainMenuItem->url }}" title="{{ $mainMenuItem->name }}"
                               aria-label="{{ $mainMenuItem->name }}"
                               itemprop="url">{{ $mainMenuItem->name }}</a>
                            <meta itemprop="name" content="{{ $mainMenuItem->name }}">
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </nav>
</header>
<div class="headermob">
    <div class="container headermob__container">
        <a class="headermob__logo" href="{{ url('/') }}">
            <img src="/static/images/common/logo.svg" alt="logo">
        </a>
        <button class="hamburger hamburger--collapse" type="button">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
    </div>
    <div class="container headermob__content">
        <nav class="nav" aria-label="Меню">
            <ul class="nav__list">
                @foreach($mainMenu as $mainMenuItem)
                    <li class="nav__item {{ $mainMenuItem->alias == 'about' ? ' headermob__subnav': '' }}">
                        <a class="nav__link" href="{{ $mainMenuItem->url }}" title="{{ $mainMenuItem->name }}">{{ $mainMenuItem->name }}</a>
                        @if($mainMenuItem->alias == 'about')
                            <ul class="headermob__sublist">
                                @foreach($aboutMenu as $aboutMenuItem)
                                    <li class="headermob__subitem">
                                        <a class="headermob__sublink" href="{{ $aboutMenuItem->url }}">{{ $aboutMenuItem->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
        @if(isset($contacts))
            <a class="headermob__phone" href="tel:{{ clearPhone('+7' . array_get($contacts, '0.code') . array_get($contacts, '0.phone')) }}">{{ '+7 (' . array_get($contacts, '0.code') . ') ' . array_get($contacts, '0.phone') }}</a>
        @endif
    </div>
</div>
