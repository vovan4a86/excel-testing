@extends('template')
@section('main')
    <x-breadcrumbs :items="$bread" />
    <div class="container container--inner">
        <x-catalog-aside />
        <main class="main main--inner">
            <section class="section section--dark articles">
                <h1 class="page-title">{{ $h1 }}</h1>
                <ul class="years">
                    @foreach($archiveYears as $archiveYear)
                        <li class="years__item">
                            <a class="years__link {{ $archiveYear->active ? 'years__link--current': '' }}" href="{{ $archiveYear->url }}" title="{{ $archiveYear->year }}">{{ $archiveYear->year }}</a>
                        </li>
                    @endforeach
                </ul>
                @include('news.news_section_list')
                @foreach($items as $item)
                    <div class="articles__item section__item">
                        <div class="articles__date">{{ $item->dateFormat() }}</div>
                        <div class="articles__block">
                            <h2 class="articles__title">
                                <a href="{{ $item->url }}" title="{{ $item->name }}">{{ $item->name }}</a>
                            </h2>
                            <p>{{ $item->announce }}</p>
                        </div>
                    </div>
                @endforeach
                @if($items->hasMorePages())
                    <div class="load">
                        <button class="load__link" type="button" onclick="location.href='{{ $items->nextPageUrl() }}'">Загрузить еще</button>
                    </div>
                @endif
            </section>
        </main>
    </div>
@endsection