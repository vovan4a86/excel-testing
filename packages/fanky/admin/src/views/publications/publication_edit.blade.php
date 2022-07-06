@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.publications') }}"><i class="fa fa-list"></i>Статьи</a></li>
        <li class="active">{{ $pub->id ? $pub->name : 'Новая статья' }}</li>
    </ol>
@stop
@section('page_name')
    <h1>Статья
        <small>{{ $pub->id ? $pub->name : 'Новая статья' }}</small>
    </h1>
@stop

<form action="{{ route('admin.publications.publicationSave') }}"
      onsubmit="return publicationSave(this, event)">
	<input type="hidden" name="id" value="{{ $pub->id }}">

	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
			<li><a href="#tab_2" data-toggle="tab">Тексты</a></li>
            @if($pub->id)
                <li class="pull-right">
                    <a href="{{ $pub->url }}" target="_blank">Посмотреть</a>
                </li>
            @endif
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">

                {!! Form::groupText('name', $pub->name, 'Название') !!}
                {!! Form::groupText('h1', $pub->h1, 'H1') !!}

                {!! Form::groupSelect('category_id', $categories->pluck('name', 'id')->sortBy('order')->all(),
                    $pub->category_id, 'Категория') !!}

                {!! Form::groupText('alias', $pub->alias, 'Alias') !!}
                {!! Form::groupText('title', $pub->title, 'Title') !!}
                {!! Form::groupText('keywords', $pub->keywords, 'keywords') !!}
                {!! Form::groupText('description', $pub->description, 'description') !!}

                {!! Form::hidden('published', 0) !!}

                {!! Form::groupCheckbox('published', 1, $pub->published, 'Показывать статью') !!}


			</div>

			<div class="tab-pane" id="tab_2">
                {!! Form::groupRichtext('announce', $pub->anounce, 'Анонс', ['rows' => 2]) !!}
                {!! Form::groupRichtext('text', $pub->text, 'Текст', ['rows' => 3]) !!}

			</div>
            <div class="tab-pane" id="tab_stock_items">
                <div id="tree" class="treeview">

                </div>
            </div>
		</div>

		<div class="box-footer">
			<button type="submit" class="btn btn-primary">Сохранить</button>
            @if($pub->id)
                <a class="btn btn-danger mx-2" href="{{ route('admin.publications.publicationDel', [$pub->id]) }}" title="Удалить статью" onclick="return publicationDel(this)">Удалить статью</a>
            @endif
            <div class="onSaveStatus"></div>
		</div>
	</div>
</form>

