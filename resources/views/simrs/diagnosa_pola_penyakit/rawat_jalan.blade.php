@extends('adminlte::page')
@section('title', 'Diagnosa Pola Penyakit')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Diagnosa Pola Penyakit Rawat Jalan</h5>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="DIAGNOSA POLA PENYAKIT PENDERITA RAJAL BY PERIODE DAN UMUR" theme="secondary"
                id="hide_div" collapsible>
                <form id="formFilter" action="" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="first" id="from" label="Tanggal Mulai" :config="$config"
                                {{-- value="{{ $from == null ? \Carbon\Carbon::parse($request->dari)->format('Y-m-d') : $from }}"> --}} value="2022-01-01">
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
                                    <x-adminlte-input-date name="last" id="to" label="Tanggal Selesai"
                                        :config="$config" {{-- value="{{ $to == null ? \Carbon\Carbon::parse($request->sampai)->format('Y-m-d') : $to }}"> --}} value="2023-01-01">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-primary">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-select name="data_umur" label="Pilih Data">
                                            <option value="" {{$request->data_umur==null?'selected':''}} >SEMUA UMUR</option>
                                            <option value="k1" {{$request->data_umur=='k1'?'selected':''}} >< 1 TAHUN</option>
                                            <option value="umr1_4" {{$request->data_umur=='umr1_4'?'selected':''}}>1 - 4 TAHUN</option>
                                            <option value="umr5_14"  {{$request->data_umur=='umr5_14'?'selected':''}}>5 - 14 TAHUN</option>
                                            <option value="umr15_44"  {{$request->data_umur=='umr15_44'?'selected':''}}>15 - 44 TAHUN</option>
                                            <option value="umr45_75"  {{$request->data_umur=='umr45_75'?'selected':''}}>45 - 75 TAHUN</option>
                                            <option value="lb75"  {{$request->data_umur=='lb75'?'selected':''}}> > 75 TAHUN</option>
                                        </x-adminlte-select>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mt-4 float-right">
                                        <x-adminlte-button type="submit" class="withLoad btn btn-sm m-1" id="diagnosa_pola"
                                            theme="primary" label="Lihat Data" />
                                        <x-adminlte-button type="submit" label="Excel" class="bg-purple btn btn-sm m-1" target="_blank"
                                        onclick="javascript: form.action='{{ route('diagnosa-pola-penyakit-rajal.export') }}';" />
                                        <button class="btn btn-success btn btn-sm m-1" onclick="printDiv('printMe')">Print
                                            <i class="fas fa-print"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
            @if (isset($diagnosa))
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
                                    <b> DIAGNOSA POLA PENYAKIT PENDERITA RANAP SEMUA UMUR</b>
                                </dd>
                                <dt class="col-sm-4 m-0">Periode</dt>
                                <dd class="col-sm-8 m-0"> :
                                    <b> {{ Carbon\Carbon::parse($request->first)->locale('id')->format('d M Y') }} s.d
                                        {{ Carbon\Carbon::parse($request->last)->locale('id')->format('d M Y') }}</b>
                                </dd>
                            </div>
                        </div>
                        <div class="col-12 table-responsive table-laporan">
                            <table class="table table-sm" id="table-laporan">
                                <thead>
                                    <th>No</th>
                                    <th>Kode Diagnosa</th>
                                    <th>Diagnosa</th>
                                    <th>Jumlah</th>
                                    <th>Persen (%)</th>
                                </thead>
                                <tbody>
                                    @foreach ($diagnosa as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->diag_utama }}</td>
                                            <td>{{ $item->diag_utama_desc }}</td>
                                            <td>{{ $item->KB }}</td>
                                            <td>{{ round($item->persen, 2) }} %</td>
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
        $(document).on('click', '#diagnosa_pola', function(e) {
            $.LoadingOverlay("show");
            var data = $('#formFilter').serialize();
            var url = "{{ route('diagnosa-pola-penyakit-rawat-jalan') }}?" + data;
            window.location = url;
            $.ajax({
                data: data,
                url: url,
                type: "GET",

            });
        });
       
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

        thead,
        th,
        tbody {
            border: 1px solid #dfdcdc !important;
        }
    </style>

@endsection
