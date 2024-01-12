@extends('adminlte::page')
@section('title', 'Kunjungan Rawat Inap Aktif')
@section('content_header')
    <h1>Kunjungan Rawat Inap Aktif</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Pasien Rawat Inap" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
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
            <x-adminlte-card theme="secondary" icon="fas fa-info-circle"
                title="Total Pasien ({{ $kunjungans ? $kunjungans->count() : 0 }} Orang)">
                @php
                    $heads = ['Tgl Masuk', 'Tgl Keluar (LOS)', 'Kunjungan', 'Pasien', 'No BPJS', 'Dokter', 'Ruangan', 'Kelas / Penjamin', 'No SEP', 'Status', 'Action'];
                    $config['order'] = ['0', 'asc'];
                    $config['paging'] = false;
                    $config['scrollY'] = '400px';
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                    hoverable compressed>
                    @if ($kunjungans)
                        @foreach ($kunjungans as $kunjungan)
                            <tr>
                                <td>{{ $kunjungan->tgl_masuk }}</td>
                                <td>{{ $kunjungan->tgl_keluar }}</td>
                                <td>{{ $kunjungan->counter }} / {{ $kunjungan->kode_kunjungan }}</td>
                                <td>{{ $kunjungan->no_rm }} {{ $kunjungan->pasien->nama_px }}</td>
                                <td>{{ $kunjungan->pasien->no_Bpjs }}</td>
                                <td>{{ $kunjungan->dokter->nama_paramedis }}</td>
                                <td>{{ $kunjungan->unit->nama_unit }}</td>
                                <td>{{ $kunjungan->kelas }} / {{ $kunjungan->penjamin_simrs->group_jaminan }}
                                </td>
                                <td>{{ $kunjungan->no_sep }}</td>
                                <td>{{ $kunjungan->status->status_kunjungan }}</td>
                                <td>
                                    <a href="{{ route('pasienranapprofile') }}?kode={{ $kunjungan->kode_kunjungan }}" class="btn btn-primary btn-xs withLoad"><i class="fas fa-file-medical"></i> Lihat
                                        ERM</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    {{-- @foreach ($kunjungans as $item)
                        @if ($item->budget)
                            @if ($item->budget->diagnosa_kode)
                                @switch($item->budget->status)
                                    @case(1)
                                        <tr class="table-warning">
                                        @break

                                        @case(2)
                                        <tr class="table-success">
                                        @break

                                        @default
                                        <tr>
                                    @endswitch
                                @else
                                <tr class="table-danger">
                            @endif
                        @else
                            <tr class="table-danger">
                        @endif
                        <td>{{ $item->tgl_masuk }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_masuk)->diffInDays() }}</td>
                        <td>{{ $item->no_rm }} {{ $item->pasien->nama_px }}</td>
                        <td> {{ $item->pasien->no_Bpjs }}</td>
                        <td>{{ $item->kelas }} / {{ $item->penjamin_simrs->group_jaminan }}
                        </td>
                        <td>{{ $item->dokter->nama_paramedis }}</td>
                        <td>{{ $item->unit->nama_unit }}</td>
                        <td class="text-right">
                            {{ $item->budget ? money($item->budget->tarif_inacbg, 'IDR') : '-' }}</td>
                        <td class="text-right">
                            {{ $item->tagihan ? money($item->tagihan->total_biaya, 'IDR') : '-' }}
                        </td>
                        <td>
                            @if ($item->budget)
                                @if ($item->budget->tarif_inacbg == 0)
                                    <button class="btn btn-xs btn-danger btnInfoPelayanan">
                                        Error
                                    </button>
                                @else
                                    @if (round(($item->tagihan->total_biaya / $item->budget->tarif_inacbg) * 100) > 100)
                                        <button class="btn btn-xs btn-danger btnInfoPelayanan">
                                            {{ round(($item->tagihan->total_biaya / $item->budget->tarif_inacbg) * 100) }}%

                                        </button>
                                    @else
                                        <button class="btn btn-xs btn-success btnInfoPelayanan">
                                            {{ round(($item->tagihan->total_biaya / $item->budget->tarif_inacbg) * 100) }}%
                                        </button>
                                    @endif
                                @endif
                            @else
                                <button class="btn btn-xs btn-danger btnInfoPelayanan">
                                    0%
                                </button>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-xs btn-warning btnPasien" data-toggle="tooltop"
                                title="Action Pelayanan Ranap" data-id="{{ $item->kode_kunjungan }}"
                                data-nomorkartu="{{ $item->pasien->no_Bpjs }}"
                                data-tgllahir="{{ \Carbon\Carbon::parse($item->pasien->tgl_lahir)->format('Y-m-d') }}"
                                data-nik="{{ $item->pasien->nik_bpjs }}" data-norm="{{ $item->pasien->no_rm }}"
                                data-namapasien="{{ $item->pasien->nama_px }}" data-nomorsep="{{ $item->no_sep }}"
                                data-gender="{{ $item->pasien->jenis_kelamin }}"
                                data-ruangan="{{ $item->unit->nama_unit }}" data-tglmasuk="{{ $item->tgl_masuk }}"
                                data-kelas="{{ $item->kelas }}" data-dokter="{{ $item->dokter->nama_paramedis }}"
                                data-counter="{{ $item->counter }}"
                                data-suratkontrol="{{ $item->surat_kontrol ? $item->surat_kontrol->noSuratKontrol : 'Belum Dibuatkan' }}">
                                Action
                            </button>
                        </td>
                        </tr>
                        <tfoot>
                            <tr>
                                <th colspan="7" class="text-right">Total Laba / Rugi</th>
                                <th class="text-right">{{ money($kunjungans->sum('budget.tarif_inacbg'), 'IDR') }}</th>
                                <th class="text-right">{{ money($kunjungans->sum('tagihan.total_biaya'), 'IDR') }}</th>
                                <th colspan="2" class="text-right">
                                    {{ money($kunjungans->sum('budget.tarif_inacbg') - $kunjungans->sum('tagihan.total_biaya'), 'IDR') }}
                                </th>
                            </tr>
                        </tfoot>
                    @endforeach --}}
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
