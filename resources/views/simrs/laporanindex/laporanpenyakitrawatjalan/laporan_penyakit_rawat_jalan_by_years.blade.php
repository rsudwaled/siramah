@extends('adminlte::page')
@section('title', 'Laporan Penyakit Rawat Jalan')
@section('content_header')
    <h1>Laporan Penyakit Rawat Jalan</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Penyakit Rawat Jalan" theme="secondary" id="hide_div" collapsible>
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
                    <x-adminlte-button label="Excel" class="bg-purple float-right btn btn-sm" id="export" />
                    <button class="btn btn-success float-right btn btn-sm" onclick="printDiv('printMe')">Print <i
                            class="fas fa-print"></i></button>
                </form>
            </x-adminlte-card>
            @if (isset($laporanPenyakitRJ))
                <section class="invoice p-3 mb-3">
                    <div id="printMe">
                        <div class="row p-3 kop-surat">
                            <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                            <div class="col">
                                <b>RUMAH SAKIT UMUM DAERAH WALED KABUPATEN CIREBON</b><br>
                                Jalan Raden Walangsungsang Kecamatan Waled Kabupaten Cirebon 45188<br>
                                www.rsudwaled.id - brsud.waled@gmail.com - Call Center (0231) 661126
                            </div>
                            <div class="col"><i class="fas fa-hospital float-right" style="color: #fcf7f7d7"></i></div>
                            <hr width="100%" hight="20px" class="m-1 " color="black" size="50px" />
                        </div>
                        <div class="row invoice-info p-3">
                            <div class="row">
                                <dt class="col-sm-4 m-0">Judul</dt>
                                <dd class="col-sm-8 m-0"> :
                                    <b> LAPORAN PENYAKIT RAWAT JALAN </b>
                                </dd>
                                <dt class="col-sm-4 m-0">Periode</dt>
                                <dd class="col-sm-8 m-0"> :
                                    <b> {{ $from }} s.d {{ $to }}</b>
                                </dd>
                            </div>

                        </div>
                        <div class="col-12 table-responsive table-laporan mt-10">
                            <table class="table table-sm" style="text-align: center;">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;"
                                            id="no">Nmr</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;"
                                            id="deskripsi">DESKRIPSI
                                        </th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;">NO RM</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;">NAMA PASIEN
                                        </th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;">KELAS</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;">KODEICD</th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;">DIAG SEK
                                        </th>
                                        <th rowspan="4" style="vertical-align : middle;text-align:center;"
                                            id="alamat">Alamat</th>
                                        <th rowspan="2" colspan="2">Tanggal</th>
                                        <th rowspan="2" colspan="2">Kunjungan</th>
                                    </tr>
                                    <tr>
                                        <th colspan="18" style="border-top:1px solid #dee2e6;">Kelompok Umur</th>
                                        <th rowspan="3" style="vertical-align : middle;text-align:center;">DPJP</th>
                                        <th rowspan="3" style="vertical-align : middle;text-align:center;"
                                            id="terapi">TERAPI</th>
                                        <th rowspan="3" style="vertical-align : middle;text-align:center;"
                                            id="hide_print">DESA</th>
                                        <th rowspan="3" style="vertical-align : middle;text-align:center;"
                                            id="hide_print">KEC.</th>
                                        <th rowspan="3" style="vertical-align : middle;text-align:center;"
                                            id="hide_print">KAB. / KOT.</th>
                                        <th rowspan="3" style="vertical-align : middle;text-align:center;">UMUR</th>
                                        <th rowspan="3" style="vertical-align : middle;text-align:center;"
                                            id="hide_print">JENIS KELAMIN</th>
                                    </tr>
                                    <tr>
                                        <td rowspan="2" style="vertical-align : middle;text-align:center;">Masuk</td>
                                        <td rowspan="2" style="vertical-align : middle;text-align:center;">Keluar</td>
                                        <td rowspan="2" style="vertical-align : middle;text-align:center;">Baru</td>
                                        <td rowspan="2" style="vertical-align : middle;text-align:center;">Lama</td>
                                        <th colspan="2">0<br>-28HRP</th>
                                        <th colspan="2">28<br>-1THN</th>
                                        <th colspan="2">1<br>-4THN</th>
                                        <th colspan="2">5<br>-14THN</th>
                                        <th colspan="2">15<br>-24THN</th>
                                        <th colspan="2">25<br>-44THN</th>
                                        <th colspan="2">45<br>-59THN</th>
                                        <th colspan="2">60<br>-64THN</th>
                                        <th colspan="2">>65THN</th>
                                    </tr>
                                    <tr>
                                        <td>L</td>
                                        <td>P</td>
                                        <td>L</td>
                                        <td>P</td>
                                        <td>L</td>
                                        <td>P</td>
                                        <td>L</td>
                                        <td>P</td>
                                        <td>L</td>
                                        <td>P</td>
                                        <td>L</td>
                                        <td>P</td>
                                        <td>L</td>
                                        <td>P</td>
                                        <td>L</td>
                                        <td>P</td>
                                        <td>L</td>
                                        <td>P</td>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporanPenyakitRJ as $item)
                                        <tr>
                                            <td id="no">{{ $item->Nmr }}</td>
                                            <td style="text-align: center" id="deskripsi">{{ $item->DESKRIPSI }}</td>
                                            <td>{{ $item->NO_RM }}</td>
                                            <td style="text-align: left">{{ $item->NAMA_PASIEN }}</td>
                                            <td>{{ $item->KELAS }}</td>
                                            <td>{{ $item->KODEICD }}</td>
                                            <td>{{ $item->DIAGNOSA_SEK == null ? '-' : $item->DIAGNOSA_SEK }}</td>
                                            <td style="text-align: center" id="alamat">{{ $item->ALAMAT }}</td>
                                            <td>{{ $item->TGL_MASUK }}</td>
                                            <td>{{ $item->TGL_KELUAR }}</td>
                                            <td>{{ $item->KUNJUNGAN_BARU }}</td>
                                            <td>{{ $item->KUNJUNGAN_LAMA }}</td>
                                            <td>{{ $item->U0_28HRL }}</td>
                                            <td>{{ $item->U0_28HRP }}</td>
                                            <td>{{ $item->U28_1THL }}</td>
                                            <td>{{ $item->U28_1THP }}</td>
                                            <td>{{ $item->U1_4THL }}</td>
                                            <td>{{ $item->U1_4THP }}</td>
                                            <td>{{ $item->U5_14THL }}</td>
                                            <td>{{ $item->U5_14THP }}</td>
                                            <td>{{ $item->U15_24THL }}</td>
                                            <td>{{ $item->U15_24THP }}</td>
                                            <td>{{ $item->U25_44THL }}</td>
                                            <td>{{ $item->U25_44THP }}</td>
                                            <td>{{ $item->U45_59THL }}</td>
                                            <td>{{ $item->U45_59THP }}</td>
                                            <td>{{ $item->U60_64THL }}</td>
                                            <td>{{ $item->U60_64THP }}</td>
                                            <td>{{ $item->ULB65THL }}</td>
                                            <td>{{ $item->ULB65THP }}</td>
                                            <td>{{ $item->DPJP }}</td>
                                            <td id="terapi" style="text-align: left">{{ $item->TERAPI }}</td>
                                            <td id="hide_print">{{ $item->DESA }}</td>
                                            <td id="hide_print">{{ $item->KECAMATAN }}</td>
                                            <td id="hide_print">{{ $item->KOTA }}</td>
                                            <td id="hide_print">{{ $item->umur }}</td>
                                            <td id="show_print">{{ $item->umur }}
                                                <br>({{ $item->jenis_kelamin == 'Perempuan' ? 'P' : 'L' }})
                                            </td>
                                            <td id="hide_print">{{ $item->jenis_kelamin }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="10">
                                            <h6>Jumlah Total </h6>
                                        </td>
                                        <td>{{ $laporanPenyakitRJ->sum('KUNJUNGAN_BARU') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('KUNJUNGAN_LAMA') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U0_28HRL') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U0_28HRP') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U28_1THL') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U28_1THP') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U1_4THL') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U1_4THP') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U5_14THL') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U5_14THP') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U15_24THL') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U15_24THP') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U25_44THL') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U25_44THP') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U45_59THL') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U45_59THP') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U60_64THL') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('U60_64THP') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('ULB65THL') }}</td>
                                        <td>{{ $laporanPenyakitRJ->sum('ULB65THP') }}</td>
                                        <td colspan="7"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
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
            var url = "{{ route('laporan-rawa-jalanbyYears.export') }}?" + data;
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
