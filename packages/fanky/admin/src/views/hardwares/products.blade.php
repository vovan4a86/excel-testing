@extends('admin::hardwares.main')

@section('catalog_content')
    <div class="box box-solid">
        <div class="box-body">
            <div class="box box-solid">
                <div class="box-body">
                    @if(Request::get('select_category'))
                        <a href="{{ route('admin.hardware.edit') . '?select_category=' . Request::get('select_category') }}">Добавить
                            запись</a>
                    @else
                        <a href="{{ route('admin.hardware.edit') }}">Добавить запись</a>
                    @endif

                    <table class="table table-striped">
                        <thead>
                        <th>ID</th>
                        <th>Категория</th>
                        <th>Название</th>
                        <th></th>
                        </thead>

                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->category? $item->category->name: '---' }}</td>
                                <td>
                                    <a href="{{ route('admin.hardware.edit', [$item->id]) }}">
                                        {{ $item->name }}</a></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop