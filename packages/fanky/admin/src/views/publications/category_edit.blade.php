@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.publications') }}"><i class="fa fa-list"></i>Статьи</a></li>
        <li class="active">{{ $category->id ? $category->name : 'Новая категория' }}</li>
    </ol>
@stop
@section('page_name')
    <h1>Категория
        <small>{{ $category->id ? $category->name : 'Новая категория' }}</small>
    </h1>
@stop

<form action="{{ route('admin.publications.categorySave') }}" onsubmit="return categorySave(this, event)">
	<input type="hidden" name="id" value="{{ $category->id ?? '' }}">

	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
            <li><a href="#tab_2" data-toggle="tab">Тексты</a></li>

{{--        @if($category->id)--}}
{{--                <li class="pull-right">--}}
{{--                    <a href="{{ $category->url }}" target="_blank">Посмотреть</a>--}}
{{--                </li>--}}
{{--        @endif--}}
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">

                {!! Form::groupText('name', $category->name, 'Название') !!}
                {!! Form::groupText('alias', $category->alias, 'Alias') !!}
                {!! Form::groupText('title', $category->title, 'Title') !!}
                {!! Form::groupText('keywords', $category->keywords, 'keywords') !!}
                {!! Form::groupText('description', $category->description, 'description') !!}

{{--                <div class="form-group">--}}
{{--                    <label for="article-image">Изображение</label>--}}
{{--                    <input id="article-image" type="file" name="image" value="" onchange="return newsImageAttache(this, event)">--}}
{{--                    <div id="article-image-block">--}}
{{--                        @if ($category->image)--}}
{{--                            <img class="img-polaroid" src="{{ $category->thumb(1) }}" height="100" data-image="{{ $category->image_src }}" onclick="return popupImage($(this).data('image'))">--}}
{{--                        @else--}}
{{--                            <p class="text-yellow">Изображение не загружено.</p>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                {!! Form::hidden('published', 0) !!}--}}
{{--                {!! Form::hidden('on_main', 0) !!}--}}
{{--                {!! Form::hidden('on_catalog', 0) !!}--}}
{{--                {!! Form::hidden('hide_on_menu', 0) !!}--}}
{{--                {!! Form::groupCheckbox('published', 1, $category->published, 'Показывать раздел') !!}--}}
{{--                {!! Form::groupCheckbox('on_main', 1, $category->on_main, 'Показывать на главной') !!}--}}
{{--                {!! Form::groupCheckbox('on_catalog', 1, $category->on_catalog, 'Показывать в каталоге') !!}--}}
{{--                {!! Form::groupCheckbox('hide_on_menu', 1, $category->hide_on_menu, 'Не показывать в левом меню') !!}--}}


			</div>

			<div class="tab-pane" id="tab_2">
                {!! Form::groupRichtext('text', $category->text, 'Текст', ['rows' => 3]) !!}
			</div>
            <div class="tab-pane" id="tab_stock_items">
                <div id="tree" class="treeview">

                </div>
            </div>
		</div>

		<div class="box-footer">
			<button type="submit" class="btn btn-primary">Сохранить</button>
            @if($category->id)
                <a class="btn btn-danger mx-2" href="{{ route('admin.publications.categoryDel', [$category->id]) }}" title="Удалить категорию" onclick="return categoryDel(this)">Удалить категорию</a>
            @endif
            <div class="onSaveStatus"></div>
		</div>
	</div>
</form>

