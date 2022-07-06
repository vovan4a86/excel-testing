@section('page_name')
    <h1>Склады
        <small>{{ $product->id ? $product->name : 'Новый товар' }}</small>
    </h1>
@stop

<form action="{{ route('admin.stock.productSave') }}" onsubmit="return catalogSave(this, event)">
    <input type="hidden" name="id" value="{{ $product->id }}">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
            <li class="pull-right">
                <a href="{{ route('admin.stock.products', [$product->stock_id]) }}"
                   onclick="return catalogContent(this)">К
                    списку товаров</a>
            </li>
            @if($product->id)
                <li class="pull-right">
                    <a href="{{ $product->url }}" target="_blank">Показать</a>
                </li>
            @endif
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                {!! Form::groupText('name', $product->name, 'Название') !!}
                {!! Form::groupText('price_name', $product->price_name, 'price_name', ['readonly' => true]) !!}
                {!! Form::groupText('h1', $product->h1, 'H1') !!}
                <div class="form-group">
                    <label for="article-image">Изображение</label>
                    <input id="article-image" type="file" name="image" value="" onchange="return newsImageAttache(this, event)">
                    <div id="article-image-block">
                        @if ($product->image)
                            <img class="img-polaroid" src="{{ $product->thumb(1) }}" height="100"
                                 data-image="{{ $product->image_src }}"
                                 onclick="return popupImage($(this).data('image'))">
                        @else
                            <p class="text-yellow">Изображение не загружено.</p>
                        @endif
                    </div>
                </div>
                {!! Form::groupSelect('stock_id', $stocks, $product->stock_id, 'Категория') !!}

                {!! Form::groupRichtext('text', $product->text, 'Текст') !!}
                {!! Form::groupText('alias', $product->alias, 'Alias') !!}
                {!! Form::groupText('title', $product->title, 'Title') !!}
                {!! Form::groupTextarea('keywords', $product->keywords, 'Keywords') !!}
                {!! Form::groupTextarea('description', $product->description, 'Description') !!}

                {!! Form::groupText('diameter', $product->diameter, 'Диаметр') !!}
                {!! Form::groupText('thickness', $product->thickness, 'Толщина') !!}
                {!! Form::groupText('weight', $product->weight, 'Вес') !!}
                {!! Form::groupText('gost', $product->gost, 'ГОСТ') !!}
                {!! Form::groupText('steel', $product->steel, 'Сталь') !!}
                {!! Form::groupText('reserved', $product->reserved, 'Бронь') !!}

                {!! Form::hidden('published', 0) !!}
                {!! Form::groupCheckbox('published', 1, $product->published, 'Показывать товар') !!}

                {!! Form::hidden('in_stock', 0) !!}
                {!! Form::groupCheckbox('in_stock', 1, $product->in_stock, 'В наличии') !!}

            </div>
        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </div>
</form>
