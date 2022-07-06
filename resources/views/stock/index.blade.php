@extends('template')
@section('main')
    <x-breadcrumbs :items="$bread" />
    <div class="container container--inner">
        <x-catalog-aside :items="$stocks" />
        <main class="main main--inner">
            <section class="section section--dark store">
                <div class="container store__container">
                    <h1 class="page-title">{{ $h1 }}</h1>
                </div>

                <div class="page-block text-block">
                    {!! $text !!}
                </div>
            </section>
        </main>
    </div>
@endsection
