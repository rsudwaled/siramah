@extends('adminlte::page')
@section('title', 'Formulir RL 4B')
@section('content_header')
    <h1>MORBIDITAS PASIEN RAWAT JALAN</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="FILTER MORBIDITAS PASIEN RAWAT JALAN" theme="secondary" id="hide_div" collapsible>
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
                                        @if (isset($laporanFM))
                                        <button class="btn btn-success btn btn-sm m-1" onclick="printDiv('printMe')">Print <i class="fas fa-print"></i></button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
            @if (isset($laporanFM))
                <div id="printMe">
                    <section class="invoice p-3 mb-3">
                        <div class="row p-3 kop-surat" style="vertical-align : middle;text-align:left;">
                            <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                            <div class="col mt-4">
                                <b >Formulir RL 4B</b><br>
                                <b > DATA KEADAAN MORBIDITAS PASIEN RAWAT JALAN RUMAH SAKIT</b>
                            </div>
                            <div class="col"><i class="fas fa-hospital float-right" style="color: #fcf7f7e7"></i></div>
                            <hr width="100%" hight="20px" class="m-1 " color="black" size="50px" />
                        </div>
                        <div class="row invoice-info p-3">
                            <div class="col">
                                <div class="row">
                                    <div class="col-sm-2"><b>Kode RS</b></div>
                                    <div class="col-sm-5"><b>: 3.2.0.9.0.1.4</b></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2"><b>Nama RS</b></div>
                                    <div class="col-sm-5"><b>: RSUD WALED</b></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2"><b>Tahun</b></div>
                                    <div class="col-sm-5"><b>: {{$yearsFrom == $yearsTo ? $yearsFrom : $yearsFrom . ' - ' . $yearsTo}}</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 table-responsive table-laporan">
                            <table class="table table-sm" style="text-align: center;">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;"id="no">No. Urut</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;">No. DTD</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;">No. Daftar terperinci</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;">Golongan Sebab Penyakit</th>
                                    </tr>
                                    <tr>
                                        <th colspan="18" style="border-top:1px solid #dee2e6;">Jumlah Pasien Kasus Menurut Golongan Umur & Sex</th>
                                        <th rowspan="2" colspan="2" style="vertical-align : middle;text-align:center;">Kasus Baru Menurut Jenis Kelamin</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;" id="terapi">Jumlah Kasus Baru (23+24)</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;" id="terapi">Jumlah Kunjungan</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">0<br>6H</th>
                                        <th colspan="2">7<br>28H</th>
                                        <th colspan="2">28H<br>-1THN</th>
                                        <th colspan="2">1<br>-4THN</th>
                                        <th colspan="2">5<br>-14THN</th>
                                        <th colspan="2">15<br>-24THN</th>
                                        <th colspan="2">25<br>-44THN</th>
                                        <th colspan="2">45<br>-64THN</th>
                                        <th colspan="2">>65THN</th>
                                    </tr>
                                    <tr>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th style="vertical-align : middle;text-align:center;">LK</th>
                                        <th style="vertical-align : middle;text-align:center;">PR</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporanFM as $item )
                                        <tr>
                                            <td>{{$item->ID}}</td>
                                            <td>{{$item->NO_DTD}}</td>
                                            <td>{{$item->NO_DAFTAR_TERPERINCI}}</td>
                                            <td>{{$item->GOLONGAN_SEBAB_PENYAKIT}}</td>
                                            <td>{{$item->L_UMUR_0_6HR == 0 ? '-' : $item->L_UMUR_0_6HR}}</td>
                                            <td>{{$item->P_UMUR_0_6HR == 0 ? '-' : $item->P_UMUR_0_6HR}}</td>
                                            <td>{{$item->L_UMUR_7_28HR == 0 ? '-' : $item->L_UMUR_7_28HR}}</td>
                                            <td>{{$item->P_UMUR_7_28HR == 0 ? '-' : $item->P_UMUR_7_28HR}}</td>
                                            <td>{{$item->L_UMUR_28HR_1TH == 0 ? '-' : $item->L_UMUR_28HR_1TH}}</td>
                                            <td>{{$item->P_UMUR_28HR_1TH == 0 ? '-' : $item->P_UMUR_28HR_1TH}}</td>
                                            <td>{{$item->L_UMUR_1_4_TH == 0 ? '-' : $item->L_UMUR_1_4_TH}}</td>
                                            <td>{{$item->P_UMUR_1_4_TH == 0 ? '-' : $item->P_UMUR_1_4_TH}}</td>
                                            <td>{{$item->L_UMUR_5_14_TH == 0 ? '-' : $item->L_UMUR_5_14_TH}}</td>
                                            <td>{{$item->P_UMUR_5_14_TH == 0 ? '-' : $item->P_UMUR_5_14_TH}}</td>
                                            <td>{{$item->L_UMUR_15_24_TH == 0 ? '-' : $item->L_UMUR_15_24_TH}}</td>
                                            <td>{{$item->P_UMUR_15_24_TH == 0 ? '-' : $item->P_UMUR_15_24_TH}}</td>
                                            <td>{{$item->L_UMUR_25_44_TH == 0 ? '-' : $item->L_UMUR_25_44_TH}}</td>
                                            {{-- <td>error!</td> --}}
                                            <td>{{$item->P_UMUR_25_44_TH == 0 ? '-' : $item->P_UMUR_25_44_TH}}</td>
                                            <td>{{$item->L_UMUR_45_64_TH == 0 ? '-' : $item->L_UMUR_45_64_TH}}</td>
                                            <td>{{$item->P_UMUR_45_64_TH == 0 ? '-' : $item->P_UMUR_45_64_TH}}</td>
                                            <td>{{$item->L_UMUR_LB_65_TH == 0 ? '-' : $item->L_UMUR_LB_65_TH}}</td>
                                            <td>{{$item->P_UMUR_LB_65_TH == 0 ? '-' : $item->P_UMUR_LB_65_TH}}</td>
                                            <td>{{$item->L_KASUS_BARU == 0 ? '-' : $item->L_KASUS_BARU}}</td>
                                            <td>{{$item->P_KASUS_BARU == 0 ? '-' : $item->P_KASUS_BARU}}</td>
                                            <td>{{$item->JUMLAH_KASUS_BARU == 0 ? '-' : $item->JUMLAH_KASUS_BARU}}</td>
                                            <td>{{$item->JUMLAH_KUNJUNGAN == 0 ? '-' : $item->JUMLAH_KUNJUNGAN}}</td>
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
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            window.print(printContents);
        }
        $(document).on('click', '#export', function(e) {
            $.LoadingOverlay("show");
            var data = $('#formFilter').serialize();
            var url = "{{ route('laporan-survailans.export') }}?" + data;
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

        .table-laporan #golumr {
            font-size: 6px;
        }

        .table-laporan #alamat {
            width: 80px;
        }

        .table-laporan #terapi {
            width: 90px;
        }

        .table-laporan #hide_print {
            display: none;
        }

        .table-laporan #show_print {
            display: block;
        }

        .table-laporan #terapi {
            width: 45px;
        }

        .table-laporan #deskripsi {
            width: 40px;
        }

        .table-laporan #alamat {
            width: 40px;
        }

        .table-laporan #no {
            width: 10px;
        }

        #hide_div {
            display: none;
        }
    </style>
    <style>
        #golumr {
            font-size: 7px;
        }

        #show_print {
            display: none;
        }
        thead, th, tbody {
            border: 1px solid #dfdcdc !important;
        }
    </style>

@endsection
