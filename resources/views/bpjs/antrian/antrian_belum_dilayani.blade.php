@extends('adminlte::page')
@section('title', 'Antrian Belum Dilayani')
@section('content_header')
    <h1>Antrian Belum Dilayani</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Waktu Antrian" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['Tanggal', 'Antrean', 'Pasien', 'No HP', 'Poliklinik', 'No Referensi', 'Estimasi', 'Created at', 'Status'];
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" bordered hoverable compressed>
                    <div class="hidden" hidden>
                        {{ date_default_timezone_set('Asia/Jakarta') }}
                    </div>
                    @if (isset($antrians))
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->tanggal }}</td>
                                <td>
                                    <a
                                        href="{{ route('bpjs.antrian.antrian_per_kodebooking') }}?kodebooking={{ $item->kodebooking }}">
                                        {{ $item->kodebooking }}
                                    </a>
                                    <br>
                                    {{ $item->noantrean }}
                                </td>
                                <td>
                                    {{ $item->norekammedis }} <br>
                                    {{ $item->nokapst }}
                                </td>
                                <td>{{ $item->nohp }}</td>
                                <td>
                                    {{ $item->kodepoli }} {{ $item->jampraktek }} <br>
                                    {{ $item->kodedokter }}
                                </td>
                                <td>{{ $item->jeniskunjungan }} <br>
                                    {{ $item->nomorreferensi }}
                                </td>
                                <td>{{ date('Y-m-d H:i:s', $item->estimasidilayani / 1000) }} </td>
                                <td>{{ date('Y-m-d H:i:s', $item->createdtime / 1000) }} <br>{{ $item->sumberdata }}</td>
                                <td>{{ $item->status }} {{ $item->ispeserta }}</td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
