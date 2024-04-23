@extends('adminlte::page')
@section('title', 'Laporan Index Operasi')
@section('content_header')
    <h1>Laporan Index Operasi</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Penyakit Inap Penelitian" theme="secondary" id="hide_div" collapsible>
                <form id="formFilter" action="" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            @php
                                $config = ['format' => 'YYYY'];
                            @endphp
                            <x-adminlte-input-date name="tahun" id="years" label="Filter Tahun" :config="$config"
                                value="{{ $years == null ? \Carbon\Carbon::parse($request->tahun)->format('Y') : $years }}">
                                {{-- value="2023-06-01"> --}}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select2 name="kode_tarif" required id="kode_tarif" label="Kode Tarif">
                                <option value=" "> -Semua Kode-</option>
                                @foreach ($tarif as $kodeTarif)
                                <option value="{{$kodeTarif->KODE_TARIF_HEADER}}">{{$kodeTarif->KODE_TARIF_HEADER}} | {{$kodeTarif->NAMA_TARIF}}</option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad float-right btn btn-sm" theme="primary"
                        label="Lihat Laporan" />
                    @if (isset($findReport))
                    <x-adminlte-button label="Excel" class="bg-purple float-right btn btn-sm" id="export" />
                    <button class="btn btn-success float-right btn btn-sm" onclick="printDiv('printMe')">Print <i
                            class="fas fa-print"></i></button>
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
                            <div class="row">
                                <dt class="col-sm-4 m-0">Judul</dt>
                                <dd class="col-sm-8 m-0"> :
                                    <b> LAPORAN INDEX OPERASI</b>
                                </dd>
                                <dt class="col-sm-4 m-0">Periode</dt>
                                <dd class="col-sm-8 m-0"> :
                                    <b> TAHUN</b>
                                </dd>
                            </div>
                        </div>
                        <div class="col-12 table-responsive table-laporan">
                            <table class="table table-sm" id="table-laporan">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;" id="no">NO RM</th>
                                        <th rowspan="2" colspan="3" style="vertical-align : middle;text-align:center;">TINDAKAN</th>
                                        <th rowspan="2" colspan="2" style="vertical-align : middle;text-align:center;">TANGGAL</th>
                                        <th rowspan="2" colspan="2" style="vertical-align : middle;text-align:center;">LAMA DIRAWAT</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">KELAS RAWAT</th>
                                        <th rowspan="2" colspan="3" style="vertical-align : middle;text-align:center;">JENIS OPERASI</th>
                                        <th rowspan="2" colspan="2" style="vertical-align : middle;text-align:center;">SEKS</th>
                                    </tr>
                                    <tr>
                                        <th colspan="7" style="border-top:1px solid #dee2e6; vertical-align : middle;text-align:center;">Kelompok Umur</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">KOMPLIKASI</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">DIAGNOSA</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">KODE ICD</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">ASAL PASIEN</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">KETERANGAN</th>
                                    </tr>
                                    
                                    <tr>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">URJ</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">UGD</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">UGI</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">TGL MASUK</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">TGL KELUAR</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">PRE-OPERASI</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">POST-OPERASI</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">KECIL</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">SEDANG</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">BESAR</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">L</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">P</th>
                                    </tr>
                                    <tr>
                                        <th >< 1</th>
                                        <th >1 - 4TH</th>
                                        <th >5 - 14TH</th>
                                        <th >15 - 24TH</th>
                                        <th >25 - 44TH</th>
                                        <th >45 - 64TH</th>
                                        <th > > 65TH</th>
                                    </tr>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($findReport as $report)
                                        <tr>
                                            <td>{{$report->NO_RM}}</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>{{$report->TGL_MASUK}}</td>
                                            <td>{{$report->TGL_KELUAR}}</td>
                                            <td>{{$report->NO_RM}}</td>
                                            <td>{{$report->NO_RM}}</td>
                                            <td>{{$report->KELAS_RAWAT}}</td>
                                            <td>{{$report->OPS_KECIL}}</td>
                                            <td>{{$report->OPS_SEDANG}}</td>
                                            <td>{{$report->OPS_BESAR}}</td>
                                            <td>{{$report->L=='1'?'L':'-'}}</td>
                                            <td>{{$report->P=='1'?'P':'-'}}</td>
                                            <td>{{$report->NO_RM}}</td>
                                            <td>{{$report->u_28h_1th}}</td>
                                            <td>{{$report->NO_RM}}</td>
                                            <td>{{$report->NO_RM}}</td>
                                            <td>{{$report->NO_RM}}</td>
                                            <td>{{$report->NO_RM}}</td>
                                            <td>{{$report->NO_RM}}</td>
                                            <td>{{$report->KOMPLIKASI??'-'}}</td>
                                            <td>{{$report->DIAGNOSA}}</td>
                                            <td>{{$report->KODE_ICD}}</td>
                                            <td>{{$report->ASAL_PASIEN}}</td>
                                            <td>{{$report->NAMA_TARIF}}</td>
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
            var url = "{{ route('laporan-rawa-inapByYear.export') }}?" + data;
            window.location = url;
            // $.get(url, function() {
            //     setInterval(() => {
            //         $.LoadingOverlay("hide");
            //     }, 5000);
            // })

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
                    // setTimeout('#export', 30000);
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
                size: Letter landscape;
            }
        }

        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }
        .table-laporan{
            font-size: 7px;
            margin-left: -5px;
        }
        .table-laporan #golumr{
            font-size: 4px;
        }
        .table-laporan #terapi{
            width: 100px;
        }
        #hide_div {
            display: none;
        }
    </style>
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
    </style>

@endsection

@endsection
