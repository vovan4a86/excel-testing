@extends('admin::template')

@section('scripts')
    <script type="text/javascript" src="/adminlte/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/adminlte/plugins/jstree/dist/jstree.min.js"></script>
    <link href="/adminlte/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/adminlte/interface_catalogs.js"></script>
@stop

@section('page_name')
    <h1>Оборудование</h1>
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Оборудование</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-body">
                    @include('admin::hardwares.categories')
                </div>
            </div>
        </div>

        <div id="catalog-content" class="col-md-9">
            @yield('catalog_content')
        </div>
    </div>
@stop