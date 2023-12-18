@extends('adminlte::page')

@section('title', 'List Pasien')
@section('content_header')
    <div class="callout callout-warning">
        <h5>List Pasien Yang di Daftarkan oleh :</h5>
        <p>{{ Auth::user()->username }}</p>
    </div>
@stop

@section('content')

    <div class="col-lg-12">
        <x-adminlte-card theme="primary" collapsible title="Daftar Kunjungan :">
            @php
                $heads = ['Masuk', 'keluar', 'No RM', 'Unit','Pasien', 'Diagnosa', 'No SEP'];
                $config['order'] = ['0', 'asc'];
                $config['paging'] = false;
                $config['info'] = false;
                $config['scrollY'] = '300px';
                $config['scrollCollapse'] = true;
                $config['scrollX'] = true;
            @endphp
            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config" striped bordered
                hoverable compressed>
                @foreach ($kunjungan as $item)
                    <tr>
                        <td>{{ $item->tgl_masuk }}</td>
                        <td>{{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}</td>
                        <td>{{ $item->no_rm }}</td>
                        <td>{{ $item->kode_unit }}</td>
                        <td>
                          <b>Nama : {{ $item->pasien->nama_px }} </b><br>
                          NIK : {{ $item->pasien->nik_bpjs }} <br>
                        </td>
                        <td>{{ $item->diagx }}</td>
                        <td>{{ $item->no_sep }}</td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </x-adminlte-card>
    </div>
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
