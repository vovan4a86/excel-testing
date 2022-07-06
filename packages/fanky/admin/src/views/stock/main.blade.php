@extends('admin::template')

@section('scripts')
	<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="/adminlte/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/adminlte/plugins/autocomplete/jquery.autocomplete.min.js"></script>
	<script type="text/javascript" src="/adminlte/plugins/jstree/dist/jstree.min.js"></script>
	<link href="/adminlte/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/adminlte/interface_catalog.js"></script>
    <script type="text/javascript" src="/adminlte/interface_stocks.js"></script>
@stop

@section('page_name')
	<h1>Склады</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active"><a href="{{ route('admin.stock') }}"> Склады</a></li>
	</ol>
@stop

@section('content')
	<div class="row">
		<div class="col-md-3">
			<div class="box box-solid">
				<div id="catalog-tree" class="box-body">
					<a href="{{ route('admin.stock.catalogEdit') }}" onclick="return catalogContent(this)">Добавить склад</a>
					<br><br>

					@include('admin::stock.tree_lvl', ['parent' => 0, 'items' => $catalogs])

					<script type="text/javascript">
						$(".tree-lvl").sortable({
							connectWith: ".tree-lvl",
							placeholder: "tree-highlight",
							update: function(event, ui) {
								var url = "{{ route('admin.stock.catalogReorder') }}";
								var data = {};
								data.id = ui.item.data('id');
								data.parent = ui.item.closest('.tree-lvl').closest('li').data('id') || 0;
								data.sorted = ui.item.closest('.tree-lvl').sortable( "toArray", {attribute: 'data-id'} );
								sendAjax(url, data);
								//console.log(data);
							},
						}).disableSelection();
					</script>
				</div>
			</div>
		</div>

		<div id="catalog-content" class="col-md-9">
			{!! $content ?? '' !!}
		</div>
	</div>
@stop
