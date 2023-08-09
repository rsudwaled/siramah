@extends('adminlte::page')
@section('title', 'Laporan Penyakit Rawat Inap')
@section('content_header')
    <h1>Laporan Penyakit Rawat Inap</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Penyakit Rawat Inap" theme="secondary" id="hide_div" collapsible>
                <form id="formFilter" action="" method="get">
                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <x-adminlte-input-date name="sampai" id="to" label="Tanggal Selesai" :config="$config"
                                value="{{ $to == null ? \Carbon\Carbon::parse($request->sampai)->format('Y-m-d') : $to }}">
                                {{-- value="2023-06-01"> --}}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select2 name="diagnosa" required id="diagnosa" label="Diagnosa">
                                @if ($selDiag)
                                    <option value="{{$selDiag[0]->diag}}">{{$selDiag[0]->diagnm}}</option>
                                @endif
                            </x-adminlte-select2>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad float-right btn btn-sm" theme="primary"
                        label="Lihat Laporan" />
                    @if (isset($laporanPenyakitRI))
                    <x-adminlte-button label="Excel" class="bg-purple float-right btn btn-sm" id="export" />
                    <button class="btn btn-success float-right btn btn-sm" onclick="printDiv('printMe')">Print <i
                            class="fas fa-print"></i></button>
                    @endif
                </form>
            </x-adminlte-card>
            @if (isset($laporanPenyakitRI))
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
                                    <b> LAPORAN PENYAKIT RAWAT INAP</b>
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
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;" id="no">Diag Utama</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;" id="deskripsi">DESKRIPSI
                                        </th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">NO RM</th>
                                        {{-- <th rowspan="4" style="vertical-align : middle;text-align:left;">NAMA PASIEN</th> --}}
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;"id="alamat">Alamat</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">DIAG SEK</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">KELAS</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">KET</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">JKL</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">JKP</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">KOMPLIKASI</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">OPERASI</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">KODEICD</th>
                                        <th rowspan="2" colspan="2" style="vertical-align : middle;text-align:center;">Tanggal</th>
                                        <th rowspan="2" colspan="2" style="vertical-align : middle;text-align:center;">MATI</th>
                                    </tr>
                                    <tr>
                                        <th colspan="10" style="border-top:1px solid #dee2e6; vertical-align : middle;text-align:center;">Kelompok Umur</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Masuk</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Keluar</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">< 48</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">> 48</th>
                                    </tr>
                                    <tr>
                                        <th >0 - 28HR</th>
                                        <th >28 - 1TH</th>
                                        <th >1 - 4TH</th>
                                        <th >5 - 14TH</th>
                                        <th >15 - 24TH</th>
                                        <th >25 - 44TH</th>
                                        <th >45 - 59TH</th>
                                        <th >60 - 64TH</th>
                                        <th > > 65TH</th>
                                    </tr>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporanPenyakitRI as $item)
                                        <tr>
                                            <td>{{$item->DIAG_UTAMA}}</td>
                                            <td>{{$item->NAMA_DIAG}}</td>
                                            <td>{{$item->NO_RM}}</td>
                                            {{-- <td>{{$item->nama_px}}</td> --}}
                                            <td>{{$item->alamat}}</td>
                                            <td>{{$item->DIAGNOSA_SEK}}</td>
                                            <td>{{$item->KELAS}}</td>
                                            <td>{{$item->ket}}</td>
                                            <td>{{$item->JKL}}</td>
                                            <td>{{$item->JKP}}</td>
                                            <td>{{$item->KOMPLIKASI == Null ? '-' : $item->KOMPLIKASI}}</td>
                                            <td>{{$item->OPERASI == null ? '-' : $item->OPERASI}}</td>
                                            <td>{{$item->KODEICD}}</td>
                                            <td>{{$item->TGL_MASUK}}</td>
                                            <td>{{$item->TGL_KELUAR}}</td>
                                            <td>{{$item->MATIKR48}}</td>
                                            <td>{{$item->MATILB48}}</td>

                                            <td>{{$item->U0_28HR}}</td>
                                            <td>{{$item->U28_1TH}}</td>
                                            <td>{{$item->U1_4TH}}</td>
                                            <td>{{$item->U5_14TH}}</td>
                                            <td>{{$item->U15_24TH}}</td>
                                            <td>{{$item->U25_44TH}}</td>
                                            <td>{{$item->U45_59TH}}</td>
                                            <td>{{$item->U60_64TH}}</td>
                                            <td>{{$item->ULB65TH}}</td>
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
            var url = "{{ route('laporan-rawa-inap.export') }}?" + data;
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
        $(document).ready(function() {
            $('#diagnosa').select2({
                placeholder: 'Pilih Kode Diagnosa',
                ajax: {
                    url: '/LaporanPenyakitRawatInap/Data',
                    dataType: 'json',
                    delay: 150,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
                                return {
                                    text: item.diagnm,
                                    id: item.diag
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection
{{-- @section('css')
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
@endsection --}}

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
