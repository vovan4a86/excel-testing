@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.catalog') }}"><i class="fa fa-list"></i> Каталог</a></li>
        <li class="active">{{ $catalog->id ? $catalog->name : 'Новый раздел' }}</li>

    </ol>
@stop
@section('page_name')
    <h1>Каталог
        <small>{{ $catalog->id ? $catalog->name : 'Новый раздел' }}</small>
    </h1>
@stop

<form action="{{ route('admin.catalog.catalogSave') }}" onsubmit="return catalogSave(this, event)">
	<input type="hidden" name="id" value="{{ $catalog->id }}">

	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
			<li><a href="#tab_2" data-toggle="tab">Тексты</a></li>
            <li><a href="#tab_stock_items" data-toggle="tab">Товары</a></li>
            @if($catalog->id)
                <li class="pull-right">
                    <a href="{{ $catalog->url }}" target="_blank">Посмотреть</a>
                </li>
            @endif
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">

                {!! Form::groupText('name', $catalog->name, 'Название') !!}
                {!! Form::groupText('h1', $catalog->h1, 'H1') !!}

                {!! Form::groupSelect('parent_id', ['0' => '---корень---'] + $catalogs->pluck('name', 'id')->all(),
                    $catalog->parent_id, 'Родительский раздел') !!}
                {!! Form::groupText('alias', $catalog->alias, 'Alias') !!}
                {!! Form::groupText('title', $catalog->title, 'Title') !!}
                {!! Form::groupText('keywords', $catalog->keywords, 'keywords') !!}
                {!! Form::groupText('description', $catalog->description, 'description') !!}

                <div class="form-group">
                    <label for="article-image">Изображение</label>
                    <input id="article-image" type="file" name="image" value="" onchange="return newsImageAttache(this, event)">
                    <div id="article-image-block">
                        @if ($catalog->image)
                            <img class="img-polaroid" src="{{ $catalog->thumb(1) }}" height="100" data-image="{{ $catalog->image_src }}" onclick="return popupImage($(this).data('image'))">
                        @else
                            <p class="text-yellow">Изображение не загружено.</p>
                        @endif
                    </div>
                </div>
                {!! Form::hidden('published', 0) !!}
                {!! Form::hidden('on_main', 0) !!}
                {!! Form::hidden('on_catalog', 0) !!}
                {!! Form::hidden('hide_on_menu', 0) !!}
                {!! Form::groupCheckbox('published', 1, $catalog->published, 'Показывать раздел') !!}
                {!! Form::groupCheckbox('on_main', 1, $catalog->on_main, 'Показывать на главной') !!}
                {!! Form::groupCheckbox('on_catalog', 1, $catalog->on_catalog, 'Показывать в каталоге') !!}
                {!! Form::groupCheckbox('hide_on_menu', 1, $catalog->hide_on_menu, 'Не показывать в левом меню') !!}


			</div>

			<div class="tab-pane" id="tab_2">
                {!! Form::groupRichtext('text_prev', $catalog->text_prev, 'Описание', ['rows' => 3]) !!}
                {!! Form::groupRichtext('status', $catalog->status, 'В наличии', ['rows' => 3]) !!}
                {!! Form::groupRichtext('content_tech', $catalog->content_tech, 'Технические характеристики', ['rows' => 3]) !!}
                {!! Form::groupRichtext('content_gosti', $catalog->content_gosti, 'Цены', ['rows' => 3]) !!}

			</div>
            <div class="tab-pane" id="tab_stock_items">
                <div id="tree" class="treeview">

                </div>
            </div>
		</div>

		<div class="box-footer">
			<button type="submit" class="btn btn-primary">Сохранить</button>
		</div>
	</div>
</form>
<script type="text/javascript">
    let stockItemIds = @json($stockItemIds);
</script>
