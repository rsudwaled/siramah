@extends('adminlte::page')
@section('title', 'Pasien')
@section('content_header')
    <h1>Pasien</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $total_pasien }}" text="Total Pasien" theme="success" icon="fas fa-users" />
        </div>
        <div class="col-12">
            <x-adminlte-card title="Data Pasien" theme="secondary" collapsible>
                <div class="row">
                    <div class="col-md-8">
                        <x-adminlte-button label="Tambah" class="btn-sm" theme="success" title="Tambah Pasien"
                            icon="fas fa-plus" data-toggle="modal" data-target="#modalCustom" />
                        <a href="{{ route('pasienexport') }}" class="btn btn-sm btn-primary"><i class="fas fa-print"></i>
                            Export</a>
                        <div class="btn btn-sm btn-primary btnModalImport"><i class="fas fa-file-medical"></i> Import</div>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('pasien.index') }}" method="get">
                            <x-adminlte-input name="search" placeholder="Pencarian NIK / Nama / No RM / BPJS"
                                igroup-size="sm" value="{{ $request->search }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="outline-primary" label="Cari" />
                                </x-slot>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text text-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </form>
                    </div>
                </div>
                @php
                    $heads = ['Nomor RM', 'BPJS', 'NIK', 'IHS SatuSehat', 'Nama Pasien (Sex)', 'Tanggal Lahir (Umur)', 'Kecamatan', 'Alamat', 'Tgl Entry', 'Action'];
                    $config['paging'] = false;
                    $config['lengthMenu'] = false;
                    $config['searching'] = false;
                    $config['info'] = false;
                    $config['responsive'] = true;
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered compressed>
                    @foreach ($pasiens as $item)
                        <tr>
                            <td>{{ $item->no_rm }}</td>
                            <td>{{ $item->no_Bpjs }}</td>
                            <td>{{ $item->nik_bpjs }}</td>
                            <td>
                                {{ $item->ihs }}
                                @if ($item->ihs)
                                    <a href="{{ route('patient_sync') }}?norm={{ $item->no_rm }}"
                                        class="btn btn-xs btn-warning"> <i class="fas fa-sync"></i> Sync</a>
                                @else
                                    <a href="{{ route('patient_sync') }}?norm={{ $item->no_rm }}"
                                        class="btn btn-xs btn-warning"> <i class="fas fa-sync"></i> Sync</a>
                                @endif
                            </td>
                            <td>{{ $item->nama_px }} ({{ $item->jenis_kelamin }})</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_lahir)->format('Y-m-d') }}
                                ({{ \Carbon\Carbon::parse($item->tgl_lahir)->age }})
                            </td>
                            <td>{{ $item->kecamatans ? $item->kecamatans->nama_kecamatan : '-' }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->tgl_entry }} ({{ $item->pic }})</td>
                            <td>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
                <div class="row">
                    <div class="col-md-5">
                        Tampil data {{ $pasiens->firstItem() }} sampai {{ $pasiens->lastItem() }} dari total
                        {{ $total_pasien }}
                    </div>
                    <div class="col-md-7">
                        <div class="float-right pagination-sm">
                            {{ $pasiens->links() }}
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
