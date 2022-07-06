@extends('template')
@section('main')
    <x-breadcrumbs :items="$bread" />
    <div class="container container--inner">
        <x-catalog-aside :items="$leftMenuItems"  />
        <main class="main main--inner">
            <section class="section section--dark chapter">
                <h1 class="page-title">{{ $h1 }}</h1>
                @if(count($children))
                    <x-page-nav :items="$children" />
                @endif
                <div class="chapter__tabs tabs">
                    <div class="chapter__triggers tabs__triggers">
                        @if($category->text_prev)
                            <a class="chapter__link tabs__link" href="#tab-1" title="Описание">Описание</a>
                        @endif
                        @if($category->status)
                            <a class="chapter__link tabs__link" href="#tab-2" title="В наличии">В наличии</a>
                        @endif
                        @if($category->content_tech)
                            <a class="chapter__link tabs__link" href="#tab-3" title="Технические характеристики">Технические характеристики</a>
                        @endif
                        @if($category->content_gosti)
                            <a class="chapter__link tabs__link" href="#tab-4" title="Цены">Цены</a>
                        @endif
                        @if(isset($stockItems) && count($stockItems))
                            <a class="chapter__link tabs__link" href="#tab-5" title="Цены">Сортамент</a>
                        @endif

                    </div>
                    <div class="chapter__content tabs__content text-block">
                        <!-- #tab-1-->
                        <div class="chapter__item tabs__item animate" id="tab-1">
                            {!! $category->text_prev !!}
{{--                            <a class="chapter__reference" href="javascript:void(0)">Читать далее</a>--}}
                        </div>
                        <!-- #tab-2-->
                        <div class="chapter__item tabs__item animate" id="tab-2">
                            {!! $category->status !!}
                        </div>
                        <!-- #tab-3-->
                        <div class="chapter__item tabs__item animate" id="tab-3">
                            {!! $category->content_tech !!}
                        </div>
                        <!-- #tab-4-->
                        <div class="chapter__item tabs__item animate" id="tab-4">
                            {!! $category->content_gosti !!}
                        </div>
                        @if(isset($stockItems) && count($stockItems))
                        <div class="chapter__item tabs__item animate" id="tab-5">
                            @include('blocks.stock_items_block')
                        </div>
                        @endif
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection