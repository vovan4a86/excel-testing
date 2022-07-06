@extends('template')
@section('main')
    <x-breadcrumbs :items="$bread" />
    <div class="container container--inner">
        <x-catalog-aside />
        <main class="main main--inner">
            <section class="section section--dark screeds" style="opacity: 1;">
                <h1 class="page-title">{{ $h1 }}</h1>
                <div class="screeds__label">{!! $title !!}</div>
                @foreach($items as $item)
                <div class="screeds__block">
                    <h2 class="screeds__title" data-spoiler="">{{ $item['name'] }}
                        <svg class="svg-sprite-icon icon-arrow">
                            <use xlink:href="static/images/sprite/symbol/sprite.svg#arrow"></use>
                        </svg>
                    </h2>
                    <div class="screeds__content" data-content="" style="display: none;">
                        <ul class="screeds__list">
                            @foreach($item['articles'] as $article)
                            <li class="screeds__item">
                                <a class="screeds__link" href="{{ route('publications.item', ['alias' => $article->alias]) }}" title="{{ $article->name }}">{{ $article->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach
            </section>
        </main>
    </div>
@endsection
