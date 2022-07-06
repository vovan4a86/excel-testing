@extends('template')
@section('main')
    <main class="main">
        <x-breadcrumbs :items="$bread" />
        <section class="section section--dark about">
            <div class="container">
                <h1 class="about__title page-title mb-40">{{ $h1 }}</h1>
                <div class="about__text page-block text-block">
                    {!! $text !!}
                </div>
                <div class="about__sert">
                    <div class="page__block-title">Сертификаты, дипломы, письма</div>
                    <div class="about__grid sertificate gallery">
                        @foreach($images as $image)
                            <a class="sertificate__link" href="{{ $image->src }}" title="{{ array_get($image->data, 'title') }}">
                                <img class="b-lazy" data-src="{{ $image->thumb(1) }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" loading="lazy" alt="{{ array_get($image->data, 'title') }}">
                                <span>{{ array_get($image->data, 'title') }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection