@extends('template')
@section('main')
    <x-breadcrumbs :items="$bread" />
    <div class="container container--inner">
        <x-catalog-aside :items="$stocks" />
        <main class="main main--inner">
            <section class="section section--dark store">
                <div class="container store__container">
                    <h1 class="page-title">{{ $h1 }}</h1>
                    <div class="store__title">{{ $stock->price_head }}</div>
                    <p>&nbsp;</p>
                    @if(count($stockItems))
                        <div class="store__table">
                            <div class="overflow-x">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Размер</th>
                                        <th>Ст</th>
                                        <th>Вес</th>
                                        <th>Гост</th>
                                        <th>Бронь, тн</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stockItems  as $innStockItems)
                                        <tr class="empty-row">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @php
                                            $itemsWeight = 0;
                                        @endphp
                                        @foreach($innStockItems as $stockItem)
                                            @php
                                                $itemsWeight += $stockItem->weight;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <a href="{{ $stockItem->url }}">{{ $stockItem->name }}</a>
                                                </td>
                                                <td>{{ $stockItem->steel }}</td>
                                                <td>{{ $stockItem->weight }}</td>
                                                <td>{{ $stockItem->gost }}</td>
                                                <td>{{ $stockItem->reserved }}</td>
                                                <td>
                                                    <a class="is-bold popup js-to-cart"
                                                       data-id="{{ $stockItem->id }}"
                                                       data-order="true"
                                                       href="#order">Добавить</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr data-total class="total-row">
                                            <td class="total-name">Итого : </td>
                                            <td></td>
                                            <td data-summary>{{ $itemsWeight }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </main>
    </div>

@endsection
