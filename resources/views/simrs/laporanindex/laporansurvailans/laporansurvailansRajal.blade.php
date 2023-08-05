@extends('adminlte::page')
@section('title', 'Laporan Diagnosa Survailans Rawat Jalan')
@section('content_header')
    <h1>Laporan Diagnosa Survailans Rawat Jalan</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Diagnosa Survailans Rawat Jalan" theme="secondary" id="hide_div" collapsible>
                <form id="formFilter" action="" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="dari" id="from" label="Tanggal Mulai" :config="$config"
                                value="{{ $from == null ? \Carbon\Carbon::parse($request->dari)->format('Y-m-d') : $from }}">
                                {{-- value="2023-06-01"> --}}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <x-adminlte-input-date name="sampai" id="to" label="Tanggal Selesai" :config="$config"
                                        value="{{ $to == null ? \Carbon\Carbon::parse($request->sampai)->format('Y-m-d') : $to }}">
                                        {{-- value="2023-06-30"> --}}
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-primary">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                                <div class="col-md-8">
                                    <div class="row mt-4 float-right">
                                        <x-adminlte-button type="submit" class="withLoad btn btn-sm m-1" theme="primary" label="Lihat Laporan" />
                                        <x-adminlte-button label="Excel" class="bg-purple btn btn-sm m-1" id="export" />
                                        <button class="btn btn-success btn btn-sm m-1" onclick="printDiv('printMe')">Print <i class="fas fa-print"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
            @if (isset($laporanDSRAJAL))
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
                            <div class="row">
                                <dt class="col-sm-4 m-0">Judul</dt>
                                <dd class="col-sm-8 m-0"> :
                                    <b> LAPORAN DIAGNOSA SURVAILANS RAWAT JALAN</b>
                                </dd>
                                <dt class="col-sm-4 m-0">Periode</dt>
                                <dd class="col-sm-8 m-0"> :
                                    <b> {{ $from }} s.d {{ $to }}</b>
                                </dd>
                            </div>
                        </div>
                        <div class="col-12 table-responsive table-laporan">
                            <table class="table table-sm" id="table-laporan">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">KODE</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">DIAG UTAMA</th>
                                        <th rowspan="2" colspan="2" style="vertical-align : middle;text-align:center;">TOTAL KB</th>
                                        <th rowspan="2" colspan="2" style="vertical-align : middle;text-align:center;">TOTAL KL</th>
                                    </tr>
                                    <tr>
                                        <th colspan="12" style="border-top:1px solid #dee2e6; vertical-align : middle;text-align:center;">Kelompok Umur</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;">TOTAL KUNJUNGAN</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">L</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">P</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">L</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">P</th>
                                    </tr>
                                    <tr>
                                        <th>U0_7HR</th>
                                        <th>U8_28HR</th>
                                        <th>UKR_1TH</th>
                                        <th>U1_4TH</th>
                                        <th>U5_9TH</th>
                                        <th>U10_14TH</th>
                                        <th>U15_19TH</th>
                                        <th>U20_24TH</th>
                                        <th>U25_54TH</th>
                                        <th>U55_59TH</th>
                                        <th>U60_69TH</th>
                                        <th>ULB_70TH</th>
                                    </tr>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporanDSRAJAL as $item)
                                        <tr>
                                            <td>{{$item->KODE}}</td>
                                            <td>{{$item->DIAG_UTAMA}}</td>
                                            <td style="text-align:center;">{{$item->TOTAL_KB_L == 0 ? '-' : $item->TOTAL_KB_L }}</td>
                                            <td style="text-align:center;">{{$item->TOTAL_KB_P == 0 ? '-' : $item->TOTAL_KB_P }}</td>
                                            <td style="text-align:center;">{{$item->TOTAL_KL_L == 0 ? '-' : $item->TOTAL_KL_L }}</td>
                                            <td style="text-align:center;">{{$item->TOTAL_KL_P == 0 ? '-' : $item->TOTAL_KL_P }}</td>

                                            <td style="text-align:center;"> {{$item->U0_7HR == 0 ? '-' : $item->U0_7HR }}</td>
                                            <td style="text-align:center;"> {{$item->U8_28HR == 0 ? '-' : $item->U8_28HR }}</td>
                                            <td style="text-align:center;"> {{$item->UKR_1TH == 0 ? '-' : $item->UKR_1TH }}</td>
                                            <td style="text-align:center;"> {{$item->U1_4TH == 0 ? '-' : $item->U1_4TH }}</td>
                                            <td style="text-align:center;"> {{$item->U5_9TH == 0 ? '-' : $item->U5_9TH }}</td>
                                            <td style="text-align:center;"> {{$item->U10_14TH == 0 ? '-' : $item->U10_14TH }}</td>
                                            <td style="text-align:center;"> {{$item->U15_19TH == 0 ? '-' : $item->U15_19TH }}</td>
                                            <td style="text-align:center;"> {{$item->U20_24TH == 0 ? '-' : $item->U20_24TH }}</td>
                                            <td style="text-align:center;"> {{$item->U25_54TH == 0 ? '-' : $item->U25_54TH }}</td>
                                            <td style="text-align:center;"> {{$item->U55_59TH == 0 ? '-' : $item->U55_59TH }}</td>
                                            <td style="text-align:center;"> {{$item->U60_69TH == 0 ? '-' : $item->U60_69TH }}</td>
                                            <td style="text-align:center;"> {{$item->ULB_70TH == 0 ? '-' : $item->ULB_70TH }}</td>
                                            <td style="text-align:center;"> {{$item->TOTAL_KUNJUNGAN == 0 ? '-' : $item->TOTAL_KUNJUNGAN}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2" style="text-align:center;  font-weight: bold;">Jumlah Total</td>
                                        <td style="text-align:center;  font-weight: bold;">{{$laporanDSRAJAL->sum('TOTAL_KB_L') ==0 ? '-' : $laporanDSRAJAL->sum('TOTAL_KB_L')}}</td>
                                        <td style="text-align:center;  font-weight: bold;">{{$laporanDSRAJAL->sum('TOTAL_KB_P') ==0 ? '-' : $laporanDSRAJAL->sum('TOTAL_KB_P')}}</td>
                                        <td style="text-align:center;  font-weight: bold;">{{$laporanDSRAJAL->sum('TOTAL_KL_L') ==0 ? '-' : $laporanDSRAJAL->sum('TOTAL_KL_L')}}</td>
                                        <td style="text-align:center;  font-weight: bold;">{{$laporanDSRAJAL->sum('TOTAL_KL_P') ==0 ? '-' : $laporanDSRAJAL->sum('TOTAL_KL_P')}}</td>

                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('U0_7HR') ==0 ? '-' : $laporanDSRAJAL->sum('U0_7HR')}}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('U8_28HR') ==0 ? '-' : $laporanDSRAJAL->sum('U8_28HR')}}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('UKR_1TH') ==0 ? '-' : $laporanDSRAJAL->sum('UKR_1TH')}}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('U1_4TH') ==0 ? '-' : $laporanDSRAJAL->sum('U1_4TH')}}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('U5_9TH') ==0 ? '-' : $laporanDSRAJAL->sum('U5_9TH')}}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('U10_14TH') ==0 ? '-' : $laporanDSRAJAL->sum('U10_14TH') }}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('U15_19TH') ==0 ? '-' : $laporanDSRAJAL->sum('U15_19TH') }}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('U20_24TH') ==0 ? '-' : $laporanDSRAJAL->sum('U20_24TH') }}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('U25_54TH') ==0 ? '-' : $laporanDSRAJAL->sum('U25_54TH') }}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('U55_59TH') ==0 ? '-' : $laporanDSRAJAL->sum('U55_59TH') }}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('U60_69TH') ==0 ? '-' : $laporanDSRAJAL->sum('U60_69TH') }}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('ULB_70TH') ==0 ? '-' : $laporanDSRAJAL->sum('ULB_70TH') }}</td>
                                        <td style="text-align:center;  font-weight: bold;"> {{$laporanDSRAJAL->sum('TOTAL_KUNJUNGAN') ==0 ? '-' : $laporanDSRAJAL->sum('TOTAL_KUNJUNGAN') }}</td>
                                    </tr>
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
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            window.print(printContents);
        }
        $(document).on('click', '#export', function(e) {
            $.LoadingOverlay("show");
            var data = $('#formFilter').serialize();
            var url = "{{ route('laporan-survailans-rajal.export') }}?" + data;
            window.location = url;
            $.ajax({
                    data: data,
                    url: url,
                    type: "GET",
                    success: function(data) {
                        setInterval(() => {
                            $.LoadingOverlay("hide");
                        }, 7000);
                    },
                }).then(function() {
                    setInterval(() => {
                        $.LoadingOverlay("hide");
                    }, 2000);
                });
        })
    </script>
@endsection
@section('css')
    <style type="text/css" media="print">
        @media print {
            @page {
                size: Legal landscape;
            }
        }

        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }

        .table-laporan {
            font-size: 9px;
            margin-left: -5px;
        }

        #hide_div {
            display: none;
        }
    </style>
    <style>
        #show_print {
            display: none;
        }
    </style>

@endsection
