@extends('adminlte::page')

@section('title', 'Data Kunjungan')
@section('content_header')
    <h1>Data Kunjungan : {{ \Carbon\Carbon::now()->format('Y-m-d') }}</h1>
@stop

@section('content')
    <div class="col-lg-12">
        <x-adminlte-card theme="primary" collapsible title="Daftar Kunjungan :">
            @php
                $heads = ['Pasien', 'Kartu', 'Kunjungan', 'Unit', 'Tgl Masuk', 'Tgl keluar', 'Diagnosa', 'No SEP', 'stts kunj', 'action'];
                $config['order'] = ['0', 'asc'];
                $config['paging'] = true;
                $config['info'] = false;
                $config['scrollY'] = '450px';
                $config['scrollCollapse'] = true;
                $config['scrollX'] = true;
            @endphp
            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config" striped bordered
                hoverable compressed>
                @foreach ($kunjungan as $item)
                    <tr style="background-color:{{ $item->pasien->no_Bpjs==null?'rgb(213, 171, 171)':'rgb(152, 200, 152)' }};">
                        <td>{{ $item->no_rm }} <br>{{ $item->pasien->nama_px }}</td>
                        <td>BPJS : {{ $item->pasien->no_Bpjs }}<br>NIK : {{ $item->pasien->nik_bpjs }}</td>
                        <td>{{ $item->kode_kunjungan }}</td>
                        <td>{{ $item->kode_unit }} ({{ $item->unit->nama_unit }})</td>
                        <td>{{ $item->tgl_masuk }}</td>
                        <td>{{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}</td>
                        <td>{{ $item->diagx }}</td>
                        <td>{{ $item->no_sep }}</td>
                        <td><button type="button"
                                class="btn {{ $item->status_kunjungan == 2 ? 'btn-block bg-gradient-danger disabled' : ($item->status_kunjungan == 1 ? 'btn-success' : 'btn-success') }} btn-block btn-flat btn-xs">{{ $item->status_kunjungan == 2 ? 'ditutup' : ($item->status_kunjungan == 1 ? 'aktif' : 'kunjungan dibatalkan') }}</button>
                        </td>
                        <td>
                            <a href="{{ route('ranapumum') }}/?no={{ $item->no_rm }}&kun={{ $item->kode_kunjungan }}"
                                class="btn btn-block btn-primary btn-sm btn-flat ">Ranap Umum</a>
                            <a href="{{ route('ranapbpjs') }}/?no={{ $item->no_rm }}&kun={{ $item->kode_kunjungan }}&nobp={{ $item->pasien->no_Bpjs }}"
                                class="btn btn-block btn-success btn-sm btn-flat ">Ranap BPJS</a>

                        </td>
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
