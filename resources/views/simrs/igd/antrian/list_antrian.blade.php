@extends('adminlte::page')
@section('title', 'List Antrian')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List Antrian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- <li class="breadcrumb-item"><a href="{{ route('pasien-kecelakaan.index') }}" class="btn btn-sm bg-purple">Daftar Pasien Kecelakaan</a></li> --}}
                    <li class="breadcrumb-item"><a href="{{ route('v.tanpa-nomor') }}" class="btn btn-sm btn-warning">Daftar
                            Tanpa Antrian</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pasien-bayi.index') }}"
                            class="btn btn-sm btn-success">Daftar
                            Pasien Bayi</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('list.antrian') }}"
                            class="btn btn-sm btn-danger">Refresh</a></li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" collapsible title="Antrian Instalasi Gawat Darurat">
                @php
                    $heads = ['No Antrian', 'Nama Pasien', 'Triase', 'Aksi'];
                    $config['order'] = false;
                    $config['paging'] = false;
                    $config['info'] = false;
                    $config['scrollY'] = '600px';
                    $config['scrollCollapse'] = true;
                    $config['scrollX'] = true;
                @endphp
                <x-adminlte-datatable id="table1" class="text-xs " :heads="$heads" head-theme="dark" :config="$config"
                    striped bordered hoverable compressed>
                    @foreach ($antrian->where('isNoAntrian', 1) as $item)
                        <tr style="border: 1px solid black;border-collapse: collapse;border-color:black;">
                            <td>{{ $item->no_antri }}</td>
                            <td>{{ $item->isTriase != null ? strtoupper($item->isTriase->nama_pasien) : 'tidak diketahui' }}
                            </td>
                            <td>
                                @if ($item->isTriase != null)
                                    @if ($item->isTriase->klasifikasi_pasien == 'PULANG')
                                        <span class="badge badge-danger">PASIEN PULANG</span>
                                    @else
                                        <span
                                            class="badge {{ $item->isTriase == null ? 'badge-danger' : 'badge-success' }}">{{ $item->isTriase == null ? '-' : $item->isTriase->klasifikasi_pasien }}</span>
                                    @endif
                                @else
                                    <span class="badge badge-danger">BELUM TRIASE</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->isTriase != null)
                                    <a href="{{ route('terpilih.antrian', ['no' => $item->no_antri, 'jp' => 1]) }}"
                                        class="btn btn-primary btn-xs" action="">pilih nomor</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
        {{-- <div class="col-md-6">
            <x-adminlte-card theme="purple" collapsible title="Antrian Kebidanan">
                @php
                    $heads = ['No Antrian', 'Triase', 'Aksi'];
                    $config['order'] = false;
                    $config['paging'] = false;
                    $config['info'] = false;
                    $config['scrollY'] = '600px';
                    $config['scrollCollapse'] = true;
                    $config['scrollX'] = true;
                @endphp
                <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark" :config="$config" striped bordered
                    hoverable compressed>
                    @foreach ($antrian->where('isNoAntrian', 0) as $item)
                        <tr>
                            <td>{{ $item->no_antri }}</td>
                            <td>
                                @if ($item->isTriase)
                                    @if ($item->isTriase->klasifikasi_pasien == 'PULANG')
                                        <span class="badge badge-danger">pasien pulang</span>
                                    @else
                                        <span
                                            class="badge {{ $item->isTriase == null ? 'badge-danger' : 'badge-warning' }}">{{ $item->isTriase == null ? '-' : $item->isTriase->klasifikasi_pasien }}</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('terpilih.antrian', ['no' => $item->no_antri, 'jp' => 0]) }}"
                                    class="btn bg-purple btn-xs" action="">pilih nomor</a>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div> --}}
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)

@section('js')

@endsection
