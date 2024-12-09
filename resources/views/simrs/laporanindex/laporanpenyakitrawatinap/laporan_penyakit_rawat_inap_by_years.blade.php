@extends('adminlte::page')
@section('title', 'Laporan Penyakit Rawat Inap Penelitian')
@section('content_header')
    <h1>Laporan Penyakit Rawat Inap Penelitian</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Penyakit Inap Penelitian" theme="secondary" id="hide_div" collapsible>
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
                            <x-adminlte-select2 name="diagnosa" required id="diagnosa_utama" label="Diagnosa">
                                <option value=" "> -Semua Diagnosa-</option>
                                <option {{ old('diagnosa', $diagnosa) == 'A' ? 'selected' : '' }} value="A">A</option>
                                <option {{ old('diagnosa', $diagnosa) == 'B' ? 'selected' : '' }} value="B">B</option>
                                <option {{ old('diagnosa', $diagnosa) == 'C' ? 'selected' : '' }} value="C">C</option>
                                <option {{ old('diagnosa', $diagnosa) == 'D' ? 'selected' : '' }} value="D">D</option>
                                <option {{ old('diagnosa', $diagnosa) == 'E' ? 'selected' : '' }} value="E">E</option>
                                <option {{ old('diagnosa', $diagnosa) == 'F' ? 'selected' : '' }} value="F">F</option>
                                <option {{ old('diagnosa', $diagnosa) == 'G' ? 'selected' : '' }} value="G">G</option>
                                <option {{ old('diagnosa', $diagnosa) == 'H' ? 'selected' : '' }} value="H">H</option>
                                <option {{ old('diagnosa', $diagnosa) == 'I' ? 'selected' : '' }} value="I">I</option>
                                <option {{ old('diagnosa', $diagnosa) == 'J' ? 'selected' : '' }} value="J">J</option>
                                <option {{ old('diagnosa', $diagnosa) == 'K' ? 'selected' : '' }} value="K">K</option>
                                <option {{ old('diagnosa', $diagnosa) == 'L' ? 'selected' : '' }} value="M">L</option>
                                <option {{ old('diagnosa', $diagnosa) == 'M' ? 'selected' : '' }} value="M">M</option>
                                <option {{ old('diagnosa', $diagnosa) == 'N' ? 'selected' : '' }} value="N">N</option>
                                <option {{ old('diagnosa', $diagnosa) == 'O' ? 'selected' : '' }} value="O">O</option>
                                <option {{ old('diagnosa', $diagnosa) == 'P' ? 'selected' : '' }} value="P">P</option>
                                <option {{ old('diagnosa', $diagnosa) == 'Q' ? 'selected' : '' }} value="Q">Q</option>
                                <option {{ old('diagnosa', $diagnosa) == 'R' ? 'selected' : '' }} value="R">R</option>
                                <option {{ old('diagnosa', $diagnosa) == 'S' ? 'selected' : '' }} value="S">S</option>
                                <option {{ old('diagnosa', $diagnosa) == 'T' ? 'selected' : '' }} value="T">T</option>
                                <option {{ old('diagnosa', $diagnosa) == 'U' ? 'selected' : '' }} value="U">U</option>
                                <option {{ old('diagnosa', $diagnosa) == 'V' ? 'selected' : '' }} value="V">V</option>
                                <option {{ old('diagnosa', $diagnosa) == 'W' ? 'selected' : '' }} value="W">W</option>
                                <option {{ old('diagnosa', $diagnosa) == 'X' ? 'selected' : '' }} value="X">X</option>
                                <option {{ old('diagnosa', $diagnosa) == 'Y' ? 'selected' : '' }} value="Y">Y</option>
                                <option {{ old('diagnosa', $diagnosa) == 'Z' ? 'selected' : '' }} value="Z">Z</option>
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
                                    <b> LAPORAN PENYAKIT RAWAT INAP Penelitian</b>
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
                                        <th rowspan="4" style="vertical-align : middle;text-align:left;">NAMA PASIEN
                                        </th>
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
                                            <td>{{ $item->nama_px }} <br>NIK: {{ $item->NIK }} <br>TGL: {{Carbon\Carbon::parse($item->TGL_LAHIR)->format('d-m-Y')}} </td>
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
