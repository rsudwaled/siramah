@extends('adminlte::page')
@section('title', 'Kunjungan Rawat Inap')
@section('content_header')
    <h1>Kunjungan Rawat Inap</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Pasien Rawat Inap" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        @php
                            $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <x-adminlte-input-date fgroup-class="col-md-3" igroup-size="sm" name="tanggal" label="Tanggal Antrian"
                            :config="$config" value="{{ $request->tanggal }}" />
                        <x-adminlte-select2 fgroup-class="col-md-3" name="kodeunit" label="Ruangan">
                            <option value="-" {{ $request->kodeunit ? '-' : 'selected' }}>SEMUA RUANGAN (-)
                            </option>
                            @foreach ($units as $key => $item)
                                <option value="{{ $key }}" {{ $key == $request->kodeunit ? 'selected' : null }}>
                                    {{ $item }} ({{ $key }})
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Pencarian" />
                </form>
            </x-adminlte-card>
        </div>
        @if ($kunjungans)
            <div class="col-md-3">
                <x-adminlte-small-box title="{{ $kunjungans->where('status_kunjungan', 1)->count() }}"
                    text="Pasien Ranap Aktif" theme="warning" icon="fas fa-user-injured" />
            </div>
            <div class="col-md-12">
                <x-adminlte-card theme="secondary" icon="fas fa-info-circle"
                    title="Total Pasien ({{ $kunjungans ? $kunjungans->count() : 0 }} Orang)">
                    @php
                        $heads = ['Tgl Masuk', 'Tgl Keluar (LOS)', 'Kunjungan', 'Pasien', 'No BPJS', 'Ruangan', 'No SEP', 'Status', 'Action'];
                        $config['order'] = [['7', 'asc']];
                        $config['paging'] = false;
                        $config['scrollY'] = '400px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($kunjungans as $kunjungan)
                            <tr>
                                <td>{{ $kunjungan->tgl_masuk }}</td>
                                <td>{{ $kunjungan->tgl_keluar }}</td>
                                <td>{{ $kunjungan->counter }} / {{ $kunjungan->kode_kunjungan }}</td>
                                <td>{{ $kunjungan->no_rm }} {{ $kunjungan->pasien->nama_px }}</td>
                                <td>{{ $kunjungan->pasien->no_Bpjs }}</td>
                                <td>{{ $kunjungan->unit->nama_unit }}</td>
                                <td>{{ $kunjungan->no_sep }}</td>
                                <td>
                                    @if ($kunjungan->status_kunjungan == 1)
                                        <span class="badge badge-success">{{ $kunjungan->status_kunjungan }}.
                                            {{ $kunjungan->status->status_kunjungan }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $kunjungan->status_kunjungan }}.
                                            {{ $kunjungan->status->status_kunjungan }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pasienranapprofile') }}?kode={{ $kunjungan->kode_kunjungan }}"
                                        class="btn btn-primary btn-xs"><i class="fas fa-file-medical"></i> Lihat
                                        ERM</a>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        @endif
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
