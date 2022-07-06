@extends('template')
@section('main')
    <main class="main">
        <h1 class="visually-hidden">{{ $h1 }}</h1>
        <section class="hero">
            @if($container = Settings::get('01_hero_content'))
                <div class="container hero__container">
                    <div class="hero__content">
                        <div class="hero__title">{!! array_get($container, 'tit') !!}</div>
                        <div class="hero__subtitle">{!! array_get($container, 'subtit') !!}</div>
                        <a class="btn btn--big"
                           href="{{ array_get($container, 'btn_link') }}">{{ array_get($container, 'btn_text') }}</a>
                    </div>
                </div>
            @endif
            <div class="hero__bottom">
                <div class="container">
                    <div class="hero__cols">
                        @if($item = Settings::get('01_ekb_contacts'))
                            <div class="hero__item">
                                <div class="hero__image">
                                    <img class="b-lazy" data-src="{{ Settings::fileSrc(array_get($item, 'map')) }}"
                                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                         loading="lazy" alt="{{ array_get($item, 'tit') }}"
                                         title="{{ array_get($item, 'tit') }}"/>
                                </div>
                                <div class="hero__contacts">
                                    <span>{{ array_get($item, 'tit') }}</span>
                                    <address>{!! array_get($item, 'address') !!}</address>
                                </div>
                            </div>
                        @endif
                        @if($item = Settings::get('01_chlb_contacts'))
                            <div class="hero__item">
                                <div class="hero__image">
                                    <img class="b-lazy" data-src="{{ Settings::fileSrc(array_get($item, 'map')) }}"
                                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                         loading="lazy" alt="{{ array_get($item, 'tit') }}"
                                         title="{{ array_get($item, 'tit') }}"/>
                                </div>
                                <div class="hero__contacts">
                                    <span>{{ array_get($item, 'tit') }}</span>
                                    <address>{!! array_get($item, 'address') !!}</address>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <section class="section section--dark categories">
            <div class="container categories__container">
                <div class="categories__head">
                    <div class="page-title">Продукция</div>
                    <a class="page-link" href="{{ route('catalog.index') }}">Смотреть весь сортамент</a>
                </div>
                <div class="categories__content">
                    @foreach($catalogs as $catalog)
                        <h2 class="page-subtitle">{{ $catalog->name }}</h2>
                        <div class="categories__list categories__list--homepage">
                            @foreach($catalog->public_children_on_main as $child)
                                <a class="categories__item" href="{{ $child->url }}" title="{{ $child->name }}">
                                    <span class="categories__image">
                                        @if($image = $child->thumb(2))
                                            <img class="b-lazy" data-src="{{ $image }}"
                                                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                 loading="lazy"
                                                 alt="{{ $child->name }}">
                                        @endif
                                    </span>
                                    <span class="categories__title">{{ $child->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="map map--ekb js-map">
            <div class="container">
                @include('blocks.question-fom')
                <div class="map__content">
                    <div class="map__cities">
                        <div class="map__title page-title">{{ Settings::get('01_map_title') }}</div>
                        @if($item = Settings::get('01_ekb_map'))
                            <div class="map__item is-active" data-city-active>
                                <div class="map__link" data-link="ekb">{{ array_get($item, 'tit') }}</div>
                                <div class="map__data">
                                    <div class="map__subtitle">{{ array_get($item, 'subtit') }}</div>
                                    <div class="map__address">{{ array_get($item, 'address') }}</div>
                                </div>
                            </div>
                        @endif
                        @if($item = Settings::get('01_chlb_map'))
                            <div class="map__item" data-city-active>
                                <div class="map__link" data-link="chelyabinsk">{{ array_get($item, 'tit') }}</div>
                                <div class="map__data">
                                    <div class="map__subtitle">{{ array_get($item, 'subtit') }}</div>
                                    <div class="map__address">{{ array_get($item, 'address') }}</div>
                                </div>
                            </div>
                        @endif
                        @if($item = Settings::get('01_polevskoy_map'))
                            <div class="map__item" data-city-active>
                                <div class="map__link" data-link="polevskoy">{{ array_get($item, 'tit') }}</div>
                                <div class="map__data">
                                    <div class="map__subtitle">{{ array_get($item, 'subtit') }}</div>
                                    <div class="map__address">{{ array_get($item, 'address') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="map__region">
                        <img class="b-lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="static/images/common/region.png" alt="map">
                        <!-- is-active-->
                        <div class="map__city map__city--ekb is-active" data-city-active>
                            <div class="map__pins">
                                <img class="b-lazy map__pin" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="static/images/common/pin.svg" alt="map-pin">
                                <img class="b-lazy map__pin map__pin--backdrop" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="static/images/common/pin--active.svg" alt="map-pin">
                            </div>
                            <div class="map__name">Екатеринбург</div>
                        </div>
                        <div class="map__city map__city--chelyabinsk" data-city-active>
                            <div class="map__pins">
                                <img class="b-lazy map__pin" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="static/images/common/pin.svg" alt="map-pin">
                                <img class="b-lazy map__pin map__pin--backdrop" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="static/images/common/pin--active.svg" alt="map-pin">
                            </div>
                            <div class="map__name">Челябинск</div>
                        </div>
                        <div class="map__city map__city--polevskoy" data-city-active>
                            <div class="map__name">Полевской</div>
                            <div class="map__pins">
                                <img class="b-lazy map__pin" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="static/images/common/pin.svg" alt="map-pin">
                                <img class="b-lazy map__pin map__pin--backdrop" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="static/images/common/pin--active.svg" alt="map-pin">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section--dark about">
            <div class="container">
                <div class="about__text page-block text-block">
                    {!! $text !!}
                </div>
            </div>
        </section>
    </main>
@stop
