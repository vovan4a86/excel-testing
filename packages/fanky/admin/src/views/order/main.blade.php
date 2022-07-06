@extends('admin::template')

@section('scripts')
@stop


@section('page_name')
    <h1>Заказы</h1>
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Заказы</li>
    </ol>
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
            <table class="table table-striped table-v-middle">
                <thead>
                <tr>
                    <th>Дата</th>
                    <th>Имя</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th width="50"></th>
                </tr>
                </thead>
                <tbody id="users-list">
                @foreach ($items as $item)
                    <tr data-id="{{ $item->id }}">
                        <td>
                            <a href="{{ route('admin.order.view', [$item->id]) }}">{{ $item->created_at->format('d.m.Y H:i') }}</a>
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <a class="glyphicon glyphicon-trash" href="{{ route('admin.order.delete', [$item->id]) }}" style="font-size:20px; color:red;"
                               onclick="postDelete(this, 'Действительно удалить строку?', 'tr', event)"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $items->render() !!}
        </div>
    </div>
@stop