@section('page_name')
	<h1>Склады
		<small>{{ $catalog->id ? 'Редактировать раздел' : 'Новый раздел' }}</small>
	</h1>
@stop

{{--<form action="{{ route('admin.stock.catalogSave') }}" onsubmit="return stockSave(this, event)">--}}
<form action="{{ route('qwe') }}" method="post"
	  enctype="multipart/form-data" onsubmit="return stockSave(this, event)">
	@csrf
	<input type="hidden" name="id" value="{{ $catalog->id }}">

	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">Основные</a></li>
			@if($catalog->id)
				<li class="pull-right">
					<a href="{{ $catalog->url }}" target="_blank">Показать</a>
				</li>
			@endif
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">
				{!! Form::groupText('name', $catalog->name, 'Название') !!}
				{!! Form::groupText('h1', $catalog->h1, 'H1') !!}
				{!! Form::groupText('price_head', $catalog->price_head, 'Подзаголовок') !!}

				<label>Загрузить XLS прайс-лист</label><br>
{{--			<input id="article-ima	ge" type="file" name="price" value="" onchange="return stockPriceAttache(this, event)">--}}
				<input type="file" id="fileXls" name="fileXls" class="btn btn-default"  onchange="return stockPriceAttache(this, event)">


				<div id="article-image-block">
					@if ($catalog->price)
						<a href="{{ $catalog->getPrice() }}" download="">
							{{ $catalog->price }}
						</a>
					@else
						<p class="text-yellow">Прайс не загружен.</p>
					@endif
				</div>

				{!! Form::groupRichtext('text', $catalog->text, 'Текст') !!}
				{!! Form::groupText('alias', $catalog->alias, 'Alias') !!}
				{!! Form::groupText('title', $catalog->title, 'Title') !!}
				{!! Form::groupTextarea('keywords', $catalog->keywords, 'Keywords') !!}
				{!! Form::groupTextarea('description', $catalog->description, 'Description') !!}

				{!! Form::hidden('published', 0) !!}
				{!! Form::groupCheckbox('published', 1, $catalog->published, 'Показывать склад') !!}
			</div>
		</div>

		<div class="box-footer">
			<button type="submit" class="btn btn-primary">Сохранить</button>
		</div>
	</div>
</form>
