@extends('adminlte::page')
@section('title', 'Pasien Rawat Jalan')
@section('content_header')
    <h1>Pasien Rawat Jalan</h1>
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
                                value="{{ \Carbon\Carbon::parse($request->tgl_masuk)->format('Y-m-d') }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button class="btn-sm withLoad" icon="fas fa-search" theme="primary"
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
                                    @if ($item->antrian)
                                        @if ($item->antrian->taskid == 0)
                                            <span class="badge bg-secondary">Belum Checkin</span>
                                        @endif
                                        @if ($item->antrian->taskid == 1)
                                            <span class="badge bg-secondary">{{ $item->antrian->taskid }}. Chekcin</span>
                                        @endif
                                        @if ($item->antrian->taskid == 2)
                                            <span class="badge bg-secondary">{{ $item->antrian->taskid }}.
                                                Pendaftaran</span>
                                        @endif
                                        @if ($item->antrian->taskid == 3)
                                            @if ($item->antrian->status_api == 0)
                                                <span class="badge bg-warning">{{ $item->antrian->taskid }}. Belum
                                                    Pembayaran</span>
                                            @else
                                                <span class="badge bg-warning">{{ $item->antrian->taskid }}. Tunggu
                                                    Poli</span>
                                            @endif
                                        @endif
                                        @if ($item->antrian->taskid == 4)
                                            <span class="badge bg-success">{{ $item->antrian->taskid }}. Periksa
                                                Poli</span>
                                        @endif
                                        @if ($item->antrian->taskid == 5)
                                            @if ($item->antrian->status_api == 0)
                                                <span class="badge bg-success">{{ $item->antrian->taskid }}. Tunggu
                                                    Farmasi</span>
                                            @endif
                                            @if ($item->antrian->status_api == 1)
                                                <span class="badge bg-success">{{ $item->antrian->taskid }}. Selesai</span>
                                            @endif
                                        @endif
                                        @if ($item->antrian->taskid == 6)
                                            <span class="badge bg-success">{{ $item->antrian->taskid }}. Racik Obat</span>
                                        @endif
                                        @if ($item->antrian->taskid == 7)
                                            <span class="badge bg-success">{{ $item->antrian->taskid }}. Selesai</span>
                                        @endif
                                        @if ($item->antrian->taskid == 99)
                                            <span class="badge bg-danger">{{ $item->antrian->taskid }}. Batal</span>
                                        @endif
                                    @else
                                        -
                                    @endif
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
