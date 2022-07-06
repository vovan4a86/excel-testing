@extends('template')
@section('main')
    <main class="main">
        <x-breadcrumbs :items="$bread" />
        <section class="section">
            <div class="container">
                <h1 class="page__megatitle">{!! $h1 !!}</h1>
            </div>
        </section>
        <section class="section section--gradient">
            <div class="container">
                <div class="page-block text-block">
                    {!! $text !!}
                </div>

                @include('blocks.stock_items_block')
            </div>
        </section>
    </main>
@stop