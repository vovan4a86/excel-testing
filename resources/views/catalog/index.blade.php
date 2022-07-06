@extends('template')
@section('main')
    <x-breadcrumbs :items="$bread" />
    <div class="container container--inner">
        <x-catalog-aside />
        <main class="main main--inner">
            <section class="section section--dark categories categories--inner">
                <div class="container categories__container">
                    <h1 class="page-title">{{ $h1 }}</h1>
                    <div class="categories__content">
                        @foreach($catalogs as $catalog)
                            <h2 class="page-subtitle">{{ $catalog->name }}</h2>
                            <div class="categories__list">
                                @foreach($catalog->public_children as $child)
                                    @if($child->on_catalog)
                                        <a class="categories__item" href="{{ $child->url }}" title="{{ $child->name }}">
									        <span class="categories__image">
                                        @if($image = $child->thumb(2))
                                            <img class="b-lazy" data-src="{{ $image }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                 loading="lazy"
                                                 alt="{{ $child->name }}">
                                        @endif
									</span>
                                            <span class="categories__title">{{ $child->name }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
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
    </div>
@endsection
