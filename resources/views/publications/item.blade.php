@extends('template')
@section('main')
    <x-breadcrumbs :items="$bread" />
    <div class="container container--inner">
        <x-catalog-aside />
        <main class="main main--inner">
            <section class="section section--dark screeds" style="opacity: 1;">
                <h1 class="page-title">{{ $name }}</h1>
                <div class="section__item text-block">
                    {!! $text !!}
                </div>
                <ul class="screeds__links links-screeds">
                    <li class="links-screeds__item">
                        @if( $hasPrev )
                            <a class="links-screeds__link" href="{{ route('publications.item', ['alias' => $hasPrev]) }}" title="Предыдущая статья">← Предыдущая статья</a>
                        @else
                            <span class="links-screeds__link-none " title="Предыдущая статья">← Предыдущая статья</span>
                        @endif
                    </li>
                    <li class="links-screeds__item">
                        <a class="links-screeds__link" href="{{route('publications.index')}}" title="Назад к списку статей">Назад к списку статей</a>
                    </li>
                    <li class="links-screeds__item">
                        @if( $hasNext )
                            <a class="links-screeds__link" href="{{ route('publications.item', ['alias' => $hasNext]) }}" title="Предыдущая статья">Следующая статья →</a>
                        @else
                            <span class="links-screeds__link-none" title="Предыдущая статья">Следующая статья →</span>
                        @endif
                    </li>
                </ul>
            </section>
        </main>
    </div>
@endsection
