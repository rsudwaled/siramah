@extends('adminlte::page')
@section('title', 'Kunjungan Poliklinik')
@section('content_header')
    <h1>Kunjungan Poliklinik</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($kunjungans)
                <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $kunjungans->count() }}" text="Total Kunjungan Pasien" theme="primary"
                            icon="fas fa-user-injured" />
                    </div>
                </div>
            @endif
            <x-adminlte-card title="Filter Data Kunjungan" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <x-adminlte-select2 fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="kode_unit" label="Poliklinik">
                                <option value="-">SEMUA POLIKLINIK
                                </option>
                                @foreach ($unit as $item)
                                    <option value="{{ $item->kode_unit }}"
                                        {{ $item->kode_unit == $request->kode_unit ? 'selected' : null }}>
                                        {{ $item->nama_unit }}
                                    </option>
                                @endforeach

                            </x-adminlte-select2>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select2 fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="kode_paramedis" label="Dokter">
                                <option value="-">SEMUA DOKTER</option>
                                @foreach ($dokters as $item)
                                    <option value="{{ $item->kode_paramedis }}"
                                        {{ $item->kode_paramedis == $request->kode_paramedis ? 'selected' : null }}>
                                        {{ $item->nama_paramedis }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                        <div class="col-md-4">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="tgl_masuk" label="Tanggal Antrian" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button class="btn-sm" icon="fas fa-search" theme="primary"
                                        label="Submit Pencarian" type="submit" />
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>
                </form>
                @if ($kunjungans)
                    @php
                        $heads = [
                            'Tgl Masuk',
                            'No RM',
                            'Pasien',
                            'No BPJS',
                            'Status',
                            'Action',
                            'Penjamin',
                            'No SEP',
                            'Surat Kontrol',
                            'Antrian Farmasi',
                            'Dokter',
                            'Poliklinik',
                            'Kode',
                            'Kodebooking',
                            'Method',
                            'Jns Pasien',
                            'Jns Kunjungan',
                            'No Referensi',
                            'Jns Rujukan',
                            'No Rujukan',
                        ];
                        $config['order'] = [['0', 'asc']];
                        $config['fixedColumns'] = [
                            'leftColumns' => 6,
                        ];
                        $config['paging'] = false;
                        $config['scrollX'] = true;
                        $config['scrollY'] = '400px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($kunjungans as $item)
                            <tr>
                                <td>{{ $item->tgl_masuk }}</td>
                                <td>{{ $item->no_rm }}</td>
                                <td>{{ $item->pasien->nama_px }}</td>
                                <td>{{ $item->pasien->no_Bpjs }}</td>
                                <td>
                                    {{ $item->antrian->taskid ?? '-' }}
                                </td>
                                <td>
                                    <a href="{{ route('ermrajal') }}?kode={{ $item->kode_kunjungan }}"
                                        class="btn btn-xs btn-primary">ERM</a>
                                </td>
                                <td>{{ $item->penjamin_simrs->nama_penjamin }}</td>
                                <td>{{ $item->no_sep }}</td>
                                <td>{{ $item->surat_kontrol->noSuratKontrol ?? '-' }}</td>
                                <td>
                                    @if ($item->order_obat_header)
                                        {{ substr($item->order_obat_header->kode_layanan_header, 12) }}
                                        @if ($item->order_obat_header->kode_unit == 4008)
                                            DEPO 2
                                        @else
                                            DEPO 1
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->dokter->nama_paramedis }}</td>
                                <td>{{ $item->unit->nama_unit }}</td>
                                <td>{{ $item->kode_kunjungan }}</td>
                                <td>{{ $item->antrian->kodebooking ?? '-' }}</td>
                                <td>{{ $item->antrian->method ?? '-' }}</td>
                                <td>{{ $item->antrian->jenispasien ?? '-' }}</td>
                                <td>{{ $item->antrian->jeniskunjungan ?? '-' }}</td>
                                <td>{{ $item->antrian->nomorreferensi ?? '-' }}</td>
                                <td>{{ $item->antrian->jenisrujukan ?? '-' }}</td>
                                <td>{{ $item->antrian->nomorrujukan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                    <br>
                    Catatan : <br>
                    - Baris Berwana Merah : belum groupping <br>
                    - Baris Berwana Kuning : pasien sudah pulang tapi belum diisi erm resume<br>
                    - Baris Berwana Hijau : pasien sudah pulang dan resumenya sudah diisi<br>
                @endif
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesFixedColumns', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
