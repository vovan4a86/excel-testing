@extends('admin::hardwares.main')

@section('page_name')
    <h1>{{ $item->id? $item->name: 'Новая запись' }}</h1>
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.hardware') }}"><i class="fa fa-server"></i> Оборудование</a></li>
        <li class="active">{{ $item->id? $item->name: 'Новая запись' }}</li>
    </ol>
@stop

@section('catalog_content')
    <div class="box box-solid">
        <div class="box-body">
            <form action="{{ route('admin.hardware.save') }}" onsubmit="categorySave(this, event)">
                @if($item->id)
                    <input type="hidden" name="id" value="{{ $item->id }}">
                @endif
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Текст</a></li>
                        <li><a href="#tab_3" data-toggle="tab">SEO</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            {!! Form::groupText('name', $item->name, 'Название') !!}
                            {!! Form::groupSelect('category_id', $categories->pluck('name', 'id')->all(), $item->category_id, 'Категория') !!}
                            {!! Form::groupText('h1', $item->h1, 'H1') !!}

                            <div class="form-group">
                                <label for="article-image">Изображение</label>
                                <input id="article-image" type="file" name="image" value=""
                                       onchange="return imageAttache(this, event)">
                                <div id="article-image-block">
                                    @if ($item->image)
                                        <img class="img-polaroid" src="{{ $item->thumb(1) }}" height="100"
                                             data-image="{{ $item->image_src }}"
                                             onclick="return popupImage($(this).data('image'))">
                                    @else
                                        <p class="text-yellow">Изображение не загружено.</p>
                                    @endif
                                </div>
                            </div>

                            {!! Form::groupCheckbox('published', 1, $item->published, 'Опубликовать') !!}
                        </div>
                        <div class="tab-pane" id="tab_2">
                            {!! Form::groupRichtext('text', $item->text, 'Текст') !!}
                        </div>
                        <div class="tab-pane" id="tab_3">
                            {!! Form::groupText('alias', $item->alias, 'Alias') !!}
                            {!! Form::groupText('title', $item->title, 'Title') !!}
                            {!! Form::groupText('keywords', $item->keywords, 'keywords') !!}
                            {!! Form::groupText('description', $item->description, 'description') !!}
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div>
@stop