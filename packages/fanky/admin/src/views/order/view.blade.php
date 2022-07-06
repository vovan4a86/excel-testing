@extends('admin::template')

@section('scripts')
@endsection


@section('page_name')
    <h1>Заказ № {{ $item->id }} от {{ $item->created_at->format('d.m.Y H:i') }}</h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.order') }}">Заказы</a></li>
        <li class="active">Заказ № {{ $item->id }}</li>
    </ol>
@endsection

@section('content')
	<div class="row">
    <div class="col-md-6">
		<table class="table table-striped">
			<tbody>
				<tr>
					<td>Имя</td>
					<td>{{ $item->name }}</td>
				</tr>
				<tr>
					<td>Телефон</td>
					<td>{{ $item->phone }}</td>
				</tr>
				<tr>
					<td>Email</td>
					<td>{{ $item->email }}</td>
				</tr>
				<tr>
					<td>Склад</td>
					<td>{{ $item->stock }}</td>
				</tr>
				<tr>
					<td>Резка</td>
					<td>{{ $item->cut ? 'Да': 'Нет' }}</td>
				</tr>
				<tr>
					<td>Доставка</td>
					<td>{{ $item->delivery ? 'Да': 'Нет' }}</td>
				</tr>
				<tr>
					<td>Текст</td>
					<td>{{ $item->text }}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-6">
		<table class="table table-bordered table-striped">
			<thead>
				<th>Название</th>
				<th>Сталь</th>
				<th>ГОСТ</th>
			</thead>
			<tbody>
			@foreach($item->stockItems as $stockItem)
				<tr>
					<td>{{ $stockItem->name }}</td>
					<td>{{ $stockItem->steel }}</td>
					<td>{{ $stockItem->gost }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	</div>
	<a href="{{ route('admin.order') }}" class="btn btn-primary">Назад в заказы</a>
@endsection