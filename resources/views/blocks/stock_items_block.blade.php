@if(isset($stockItems) && count($stockItems))
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
                @foreach($stockItems  as $stockItem)
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
                <tr data-total>
                    <td>Итого:</td>
                    <td></td>
                    <td data-summary>{{ $stockItems->sum('weight') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif
