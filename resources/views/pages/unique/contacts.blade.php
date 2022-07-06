@extends('template')
@section('main')
    <main class="main">
        <x-breadcrumbs :items="$bread"/>
        <section class="section section--dark contacts">
            <div class="container">
                <h1 class="page-title">{{ $h1 }}</h1>
                @if($item = Settings::get('61_office_block'))
                    <div class="contacts__item">
                        <h2 class="contacts__title">{{ array_get($item, 'title') }}</h2>
                        <div class="contacts__wrapper">
                            <div class="contacts__content">
                                @if($address = array_get($item, 'address'))
                                    <div class="contacts__row">
                                        <div class="contacts__top">
                                            <svg class="svg-sprite-icon icon-location">
                                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#location"></use>
                                            </svg>
                                            Адрес:
                                        </div>
                                        <div class="contacts__bottom">
                                            <p>{{ $address }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if($phone = array_get($item, 'phone'))
                                    <div class="contacts__row">
                                        <div class="contacts__top">
                                            <svg class="svg-sprite-icon icon-phone">
                                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#phone"></use>
                                            </svg>
                                            Телефон:
                                        </div>
                                        <div class="contacts__bottom">
                                            <a href="tel:{{ clearPhone($phone) }}">{{ $phone }}</a>
                                        </div>
                                    </div>
                                @endif
                                @if($email = array_get($item,'email'))
                                    <div class="contacts__row">
                                        <div class="contacts__top">
                                            <svg class="svg-sprite-icon icon-email">
                                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#email"></use>
                                            </svg>
                                            Эл. почта:
                                        </div>
                                        <div class="contacts__bottom">
                                            <a href="mailto:{{ $email }}">{{ $email }}</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="contacts__map">
                                <div class="contacts__pin" id="ekb"
                                     data-lat="{{ array_get($item, 'lat') }}"
                                     data-long="{{ array_get($item, 'long') }}"
                                     data-hint="{{ htmlspecialchars(array_get($item, 'map_hint')) }}"></div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($item = Settings::get('61_store_block'))
                    <div class="contacts__item">
                        <h2 class="contacts__title">{{ array_get($item, 'title') }}</h2>
                        <div class="contacts__wrapper">
                            <div class="contacts__content">
                                @if($address = array_get($item, 'address'))
                                    <div class="contacts__row">
                                        <div class="contacts__top">
                                            <svg class="svg-sprite-icon icon-location">
                                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#location"></use>
                                            </svg>
                                            Адрес:
                                        </div>
                                        <div class="contacts__bottom">
                                            <p>{{ $address }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if($phone = array_get($item, 'phone'))
                                    <div class="contacts__row">
                                        <div class="contacts__top">
                                            <svg class="svg-sprite-icon icon-phone">
                                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#phone"></use>
                                            </svg>
                                            Телефон:
                                        </div>
                                        <div class="contacts__bottom">
                                            <a href="tel:{{ clearPhone($phone) }}">{{ $phone }}</a>
                                        </div>
                                    </div>
                                @endif
                                @if($link = array_get($item, 'map_link'))
                                    <div class="contacts__row">
                                        <div class="contacts__top">
                                            <svg class="svg-sprite-icon icon-nav">
                                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#nav"></use>
                                            </svg>
                                            Карта проезда:
                                        </div>
                                        <div class="contacts__bottom contacts__bottom--nav">
                                            <a href="{{ $link }}" rel="nofollow"
                                               target="_blank">смотреть карту проезда</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="contacts__map">
                                <div class="contacts__pin" id="store"
                                     data-lat="{{ array_get($item, 'lat') }}"
                                     data-long="{{ array_get($item, 'long') }}"
                                     data-hint="{{ htmlspecialchars(array_get($item, 'map_hint')) }}"></div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($item = Settings::get('61_chelyabinsk_block'))
                    <div class="contacts__item">
                        <h2 class="contacts__title" data-collapsed>Представительство в г. Челябинск</h2>
                        <div data-content>
                            <div class="contacts__wrapper">
                                <div class="contacts__content">
                                    @if($address = array_get($item, 'address'))
                                        <div class="contacts__row">
                                            <div class="contacts__top">
                                                <svg class="svg-sprite-icon icon-location">
                                                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#location"></use>
                                                </svg>
                                                Адрес:
                                            </div>
                                            <div class="contacts__bottom">
                                                <p>{{ $address }}</p>
                                            </div>
                                        </div>
                                    @endif
                                <!-- .contacts__row--columns-->
                                    <div class="contacts__row contacts__row--columns">
                                        @if($phone = array_get($item, 'phone'))
                                            <div class="contacts__column">
                                                <div class="contacts__top">
                                                    <svg class="svg-sprite-icon icon-phone">
                                                        <use xlink:href="/static/images/sprite/symbol/sprite.svg#phone"></use>
                                                    </svg>
                                                    Телефон:
                                                </div>
                                                <div class="contacts__bottom">
                                                    <a href="tel:{{ clearPhone($phone) }}">{{ $phone }}</a>
                                                </div>
                                            </div>
                                        @endif
                                        @if($email = array_get($item, 'email'))
                                            <div class="contacts__column">
                                                <div class="contacts__top">
                                                    <svg class="svg-sprite-icon icon-email">
                                                        <use xlink:href="/static/images/sprite/symbol/sprite.svg#email"></use>
                                                    </svg>
                                                    Эл. почта:
                                                </div>
                                                <div class="contacts__bottom">
                                                    <a href="{{ $email }}">{{ $email }}</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @if($link = array_get($item, 'map_link'))
                                        <div class="contacts__row">
                                            <div class="contacts__top">
                                                <svg class="svg-sprite-icon icon-nav">
                                                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#nav"></use>
                                                </svg>
                                                Карта проезда:
                                            </div>
                                            <div class="contacts__bottom contacts__bottom--nav">
                                                <a href="{{ $link }}" rel="nofollow"
                                                   target="_blank">смотреть карту проезда</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- .contacts__map--collapsed-->
                                <div class="contacts__map contacts__map--collapsed">
                                    <div class="contacts__pin" id="chelyabinsk"
                                         data-lat="{{ array_get($item, 'lat') }}"
                                         data-long="{{ array_get($item, 'long') }}"
                                         data-hint="{{ htmlspecialchars(array_get($item, 'map_hint')) }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($item = Settings::get('61_contact_data'))
                    <div class="contacts__item">
                        <h2 class="contacts__title" data-collapsed>{{ array_get($item, 'title') }}</h2>
                        <div data-content>
                            <div class="contacts__company">{!! array_get($item, 'company') !!}</div>
                            <div class="contacts__wrapper">
                                <!-- contacts__content--data-->
                                <div class="contacts__content contacts__content--data">{!! array_get($item, 'requisites') !!}</div>
                                <!-- contacts__content--data-->
                                <div class="contacts__content contacts__content--data">{!! array_get($item, 'contacts') !!}</div>
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </section>

        <section class="map map--ekb js-map">
            <div class="container">
                @include('blocks.question-fom')
            </div>
        </section>
    </main>
@endsection
