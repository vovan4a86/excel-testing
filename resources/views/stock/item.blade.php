@extends('template')
@section('main')
    <x-breadcrumbs :items="$bread"/>
    <div class="container container--inner">
        <x-catalog-aside :items="$stocks"/>
        <main class="main main--inner">
            <section class="section section--dark product">
                <h1 class="page-title">{{ $h1 }}</h1>
                <div class="product__container">
                    @if($image = $item->thumb(2))
                        <a class="product__preview lightbox" href="{{ $item->image_src }}"
                           title="{{ $h1 }}">
                            <img class="b-lazy" data-src="{{$image}}"
                                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                 loading="lazy" alt="{{ $item->name }}" title="{{ $item->name }}"/>
                        </a>
                    @endif
                    <div class="product__layout">
                        <form class="form" action="#">
                            <div class="product__properties">
                                @if($item->diameter)
                                    <div class="product__property">Диаметр
                                        <span>{{ $item->diameter }}</span>
                                    </div>
                                @endif
                                @if($item->gost)
                                    <div class="product__property">ГОСТ
                                        <span>{{ $item->gost }}</span>
                                    </div>
                                @endif
                                @if($item->thickness)
                                    <div class="product__property">Толщина
                                        <span>{{ $item->thickness }}</span>
                                    </div>
                                @endif
                                @if($item->steel)
                                    <div class="product__property">Сталь
                                        <span>{{ $item->steel }}</span>
                                    </div>
                                @endif
                                @if($item->weight)
                                    <div class="product__property">Вес
                                        <span>{{ $item->weight }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="product__note" data-start="*">Стоимость на продукцию необходимо уточнять у
                                менеджера на день формирования заказа
                            </div>
                            <a class="btn btn--big popup js-to-cart" href="#order"
                               data-id="{{ $item->id }}"
                               data-order="true"
                               data-product="{{ $item->name }}">В лист заказа</a>
                        </form>
                    </div>
                </div>
                @if($item->text)
                    <div class="page-block">
                        {!! $item->text !!}
                    </div>
                @endif
                <form class="form product__callback" action="{{ route('ajax.callback') }}" onsubmit="sendCallback(this, event)">
                    <div class="page__block-formtitle text-center">Нужна консультация по этому товару?</div>
                    <div class="form__row">
                        <input type="text" name="name" placeholder="Ваше имя" aria-label="Ваше имя" required>
                        <input type="tel" name="phone" placeholder="+7 (___) ___-__-__" aria-label="Ваш телефон"
                               required>
                        <button class="btn">Отправить запрос</button>
                    </div>
                </form>
                @if(count($relatedItems))
                    <div class="page__block-title">Похожие товары</div>
                    <div class="product__order order-list">
                        <table>
                            <thead>
                            <tr>
                                <th>Размер</th>
                                <th>Ст</th>
                                <th>Вес, т</th>
                                <th>Гост</th>
                                <th>Бронь, т</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($relatedItems as $relatedItem)
                                <tr>
                                    <td>
                                        <a href="javascript:void(0)"
                                           title="{{ $relatedItem->name }}"
                                           target="_blank">{{ $relatedItem->name }}</a>
                                    </td>
                                    <td>{{ $relatedItem->steel }}</td>
                                    <td>{{ $relatedItem->weight }}</td>
                                    <td>{{ $relatedItem->gost }}</td>
                                    <td>{{ $relatedItem->reserved }}</td>
                                    <td>
                                        <a href="#order" class="is-bold popup js-to-cart"
                                                data-id="{{ $relatedItem->id }}"
                                                data-order="ду 15х2,8 (6м) / Ст: 3сп / Бронь, т: 5">в лист
                                            заказа
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--include product__related-->
                @endif


                <a class="section__back" href="{{ URL::previous() ?: $item->stock->url }}" title="Вернуться назад">
                    <span>← Вернуться назад</span>
                </a>
            </section>
        </main>
    </div>
@endsection
