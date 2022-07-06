@extends('template')
@section('main')
    <main class="main">
        <section class="section error">
            <div class="container error__container">
                <div class="page__megatitle">Страница не найдена</div>
                <a class="btn btn--big btn--accent" href="{{ url('/') }}">На главную</a>
            </div>
        </section>
    </main>
@stop
