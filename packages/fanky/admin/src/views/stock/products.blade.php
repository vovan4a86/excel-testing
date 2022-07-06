@section('page_name')
	<h1>Склады
		<small>{{ $catalog->name }}</small>
	</h1>
@stop

<div class="box box-solid">
	<div class="box-body">
		<a href="{{ route('admin.stock.productEdit').'?catalog='.$catalog->id }}" onclick="return catalogContent(this)">Добавить товар</a>

		@if (count($products))
			<table class="table table-striped table-v-middle">
				<thead>
					<tr>
						<th width="40"></th>
						<th width="100"></th>
						<th>Название</th>
						<th>Сталь</th>
						<th>Диаметр</th>
						<th>ГОСТ</th>
						<th>Title</th>
						<th width="50"></th>
					</tr>
				</thead>
				<tbody id="catalog-products">
					@foreach ($products as $item)
						<tr data-id="{{ $item->id }}">
							<td><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></td>
							<td>
								@if ($item->image)
									<img src="{{ $item->thumb(1) }}">
								@endif
							</td>
							<td><a href="{{ route('admin.stock.productEdit', [$item->id]) }}" onclick="return catalogContent(this)">{{ $item->name }}</a></td>
							<td>{{ $item->steel }}</td>
							<td>{{ $item->diameter }}</td>
							<td>{{ $item->gost }}</td>
							<td><a href="{{ route('admin.stock.productEdit', [$item->id]) }}" onclick="return catalogContent(this)">{{ $item->title }}</a></td>
							<td>
								<a class="glyphicon glyphicon-trash" href="{{ route('admin.stock.productDel', [$item->id]) }}" style="font-size:20px; color:red;" title="Удалить" onclick="return productDel(this)"></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<script type="text/javascript">
				$("#catalog-products").sortable({
					update: function(event, ui) {
						var url = "{{ route('admin.stock.productReorder') }}";
						var data = {};
						data.sorted = $('#catalog-products').sortable("toArray", {attribute: 'data-id'} );
						sendAjax(url, data);
						//console.log(data);
					},
				}).disableSelection();
			</script>
		@else
			<p class="text-yellow">В разделе нет товаров!</p>
		@endif
	</div>
</div>