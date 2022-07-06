@extends('template')
@section('main')
    <x-breadcrumbs :items="$bread" />
    <div class="container container--inner">
        <x-catalog-aside />
        <main class="main main--inner">
            <section class="section section--dark articles">
                <h1 class="page-title">{{ $h1 }}</h1>
                <div class="page-block text-block">
                    {!! $text !!}
                </div>
            </section>
        </main>
    </div>
@endsection