@extends('adminlte::page')

@section('title', 'Practitioner')

@section('content_header')
    <h1>Practitioner</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Data Dokter" theme="info" icon="fas fa-info-circle" collapsible maximizable>
                @php
                    $heads = ['Kode BPJS', 'Kode SIMRS', 'ID SatuSehat', 'NIK', 'Nama Dokter', 'SIP', 'Status', 'Action'];
                    $config['paging'] = false;
                    $config['info'] = false;
                    $config['scrollY'] = '500px';
                    $config['scrollCollapse'] = true;
                @endphp
                <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($dokter as $item)
                        <tr>
                            <td>{{ $item->kodedokter }}</td>
                            <td>{{ $item->paramedis ? $item->paramedis->kode_paramedis : '-' }}</td>
                            <td>{{ $item->id_satusehat }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->namadokter }}</td>
                            <td>{{ $item->paramedis ? $item->paramedis->sip_dr : '-' }}</td>
                            <td>
                                @if ($item->paramedis)
                                    <a href="#" class="btn btn-xs btn-secondary">Sudah
                                        Ada</a>
                                @else
                                    <a href="#" class="btn btn-xs btn-danger">Belum
                                        Ada</a>
                                @endif
                            </td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" label="Edit" theme="warning" icon="fas fa-edit"
                                    data-toggle="tooltip" title="Edit Dokter {{ $item->nama_paramedis }}"
                                    data-id="{{ $item->kodedokter }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
