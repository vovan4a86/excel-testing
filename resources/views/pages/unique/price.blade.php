@extends('template')
@section('main')
    <main class="main">
        <x-breadcrumbs :items="$bread" />
        <section class="section">
            <div class="container">
                <h1 class="page__megatitle">{!! $h1 !!}</h1>
            </div>
        </section>
        <section class="section section--gradient">
            <div class="container">
                <div class="page-block text-block">
                    {!! $text !!}
                    @if(is_array($data = json_decode(Settings::get('price_data'), true)))
                        @php
                            $list = $data;
                            $head = array_shift($list);
                            $keys = array_keys($head);
                        @endphp
                        <div class="table-tools">
                            <a class="tt-file" href="{{ Settings::fileSrc(Settings::get('price_file')) }}">скачать файл .xls</a>
                        </div>
                        <div class="text">
                            <table width="100%">
                                <tr>
                                    @foreach($head as $title)
                                        <td class="table-title">{{ $title }}</td>
                                    @endforeach
                                </tr>
                                @foreach($list as $row)
                                    <tr>
                                        @if(preg_match("/^\s*ГОСТ/", array_get($row, 3) ))
                                            <?php $insert_empty_row = true; ?>
                                            @foreach($keys as $key)
                                                <td class="table-line2">{!! array_get($row, $key, "&nbsp;") !!}</td>
                                            @endforeach
                                        @else
                                            @foreach($keys as $key)
                                                <td>{!! array_get($row, $key, "&nbsp;") !!}</td>
                                            @endforeach
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@stop