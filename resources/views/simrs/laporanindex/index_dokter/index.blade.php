@extends('adminlte::page')
@section('title', 'Laporan Index Dokter')
@section('content_header')
    <h1>Laporan Index Dokter</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="secondary" id="hide_div" collapsible>
                <form id="formFilter" action="" method="get">
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <div class="row">
                        <div class="col-md-4">
                            <x-adminlte-input-date name="dari" id="from" label="Periode Awal" :config="$config"
                                value="{{ $from == null ? \Carbon\Carbon::parse($request->dari)->format('Y') : $from }}">
                                {{-- value="2023-06-01"> --}}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-input-date name="selesai" id="to" label="Periode Akhir" :config="$config"
                                value="{{ $to == null ? \Carbon\Carbon::parse($request->sampai)->format('Y') : $to }}">
                                {{-- value="2023-06-01"> --}}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select2 name="kode_paramedis" required id="kode_paramedis" label="Kode Tarif">
                                <option value=" "> -Semua Kode-</option>
                                @foreach ($paramedis as $kode)
                                    <option value="{{ $kode->kode_paramedis }}"
                                        {{ $request->kode_paramedis == $kode->kode_paramedis ? 'selected' : '' }}>
                                        {{ $kode->kode_paramedis }} |
                                        {{ $kode->nama_paramedis }}</option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad float-right btn btn-sm" theme="primary"
                        label="Lihat Laporan" />
                    @if (isset($findReport))
                        <button type="button" onclick="submitForm()"
                            class="btn btn-success float-right btn-sm btn-export mr-2">
                            Export
                        </button>
                    @endif

                </form>
            </x-adminlte-card>
            @if (isset($findReport))
                <div id="printMe">
                    <section class="invoice p-3 mb-3">
                        <div class="row p-3 kop-surat">
                            <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                            <div class="col">
                                <b>RUMAH SAKIT UMUM DAERAH WALED KABUPATEN CIREBON</b><br>
                                Jalan Raden Walangsungsang Kecamatan Waled Kabupaten Cirebon 45188<br>
                                www.rsudwaled.id - brsud.waled@gmail.com - Call Center (0231) 661126
                            </div>
                            <div class="col"><i class="fas fa-hospital float-right" style="color: #fcf7f7e7"></i></div>
                            <hr width="100%" hight="20px" class="m-1 " color="black" size="50px" />
                        </div>
                        <div class="row invoice-info p-3">
                            <div class="col-12 row">
                                <div class="col-10"><b>Dokter: {{ $dokterFind->nama_paramedis }}</b></div>
                                <div class="col-2"><b>Bulan : {{ $bulanSelesai }} Tahun : {{ $tahunSelesai }}</b></div>
                            </div>
                        </div>
                        <div class="col-12 table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-sm" id="table-laporan">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align : middle;text-align:left;">
                                            NO</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:left;">
                                            No RM</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:left;">
                                            PASIEN</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:left;">
                                            POLIKLINIK</th>
                                    </tr>
                                    <tr>
                                        <th>28H (L)</th>
                                        <th>28H (P)</th>
                                        <th>
                                            < 1TH(L)</th>
                                        <th>
                                            < 1TH(P)</th>
                                        <th> 1-5 (L)</th>
                                        <th> 1-5 (P)</th>
                                        <th> 5-14 (L)</th>
                                        <th> 5-14 (P)</th>
                                        <th> 15-24 (L)</th>
                                        <th> 15-24 (P)</th>
                                        <th> 25-44 (L)</th>
                                        <th> 25-44 (P)</th>
                                        <th> 45-64 (L)</th>
                                        <th> 45-64 (P)</th>
                                        <th> > 65 (L)</th>
                                        <th> > 65 (P)</th>
                                        <th rowspan="2"> Kunjungan</th>
                                        <th rowspan="2"> Diagnosa</th>
                                        <th rowspan="2"> Ket</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($findReport as $report)
                                        <tr>
                                            <td style="vertical-align : middle;text-align:left;">
                                                {{ $loop->iteration }}</td>
                                            <td style="vertical-align : middle;text-align:left;">
                                                {{ $report->no_rm }}
                                            </td>
                                            <td style="vertical-align : middle;text-align:left;">
                                                {{ $report->nama_px }}
                                            </td>
                                            <td style="vertical-align : middle;text-align:left;">
                                                {{ $report->nama_unit ?? '-' }}
                                            </td>
                                            <td>{{ $report->age_group == '0_28HL' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == '0_28HP' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == 'kurang_1TL' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == 'kurang_1TP' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == '1_5TL' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == '1_5TP' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == '5_14TL' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == '5_14TP' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == '15_24TL' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == '15_24TP' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == '25_44TL' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == '25_44TP' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == '45_64TL' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == '45_64TP' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == 'lebih_65TL' ? '1' : '-' }}</td>
                                            <td>{{ $report->age_group == 'lebih_65TP' ? '1' : '-' }}</td>

                                            <td> In: {{ \Carbon\Carbon::parse($report->tgl_masuk)->format('d-m-Y') }} <br>
                                                Out: {{ \Carbon\Carbon::parse($report->tgl_keluar)->format('d-m-Y') }}</td>
                                            <td> utama: {{ $report->diag_utama_desc ?? '-' }} <br> Sekunder:
                                                {{ $report->diag_sekunder1_desc ?? '-' }} </td>
                                            <td> -</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
<script>
    function submitForm() {
        document.getElementById('formFilter').action = '{{ route('laporanindex.index_dokter.export') }}';
        document.getElementById('formFilter').submit();
    }
</script>

@endsection
