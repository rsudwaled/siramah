@extends('adminlte::page')
@section('title', 'Formulir RL 5.3')
@section('content_header')
    <h1>Daftar Penyakit Rawat Inap </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card title=" 10 Besar Kunjungan Penyakit Rawat Jalan " theme="primary">
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
                                    <x-adminlte-input-date name="sampai" id="to" label="Tanggal Selesai"
                                        :config="$config"
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
                                        <x-adminlte-button type="submit" class="withLoad btn btn-sm m-1" theme="primary"
                                            label="Lihat Laporan" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>

        @if ($rekap)
            <div class="card">
                <div class="card-body">
                    <div class="col-12">
                        <table style="border: 1px solid black;" cellpadding="6" cellspacing="0"
                            style="border-collapse: collapse; width: 100%;">
                            <thead>
                                <tr>
                                    <th rowspan="2">Kelompok ICD-10</th>
                                    <th rowspan="2">Kelompok Diagnosis Penyakit</th>
                                    <th colspan="3">Jumlah Kasus Baru</th>
                                    <th colspan="3">Jumlah Kunjungan Baru</th>
                                </tr>
                                <tr>
                                    <th>Laki-laki</th>
                                    <th>Perempuan</th>
                                    <th>Total</th>
                                    <th>Laki-laki</th>
                                    <th>Perempuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekap as $kode_diag => $data)
                                    @php
                                        $deskripsi = implode(', ', $data['deskripsi']);
                                        $kasusL = $data['L'] ?? [];
                                        $kasusP = $data['P'] ?? [];

                                        $totalKasusL = collect($kasusL)->sum('total_kasus_baru');
                                        $totalKasusP = collect($kasusP)->sum('total_kasus_baru');
                                        $totalKunjunganL = collect($kasusL)->sum('total_kunjungan_baru');
                                        $totalKunjunganP = collect($kasusP)->sum('total_kunjungan_baru');

                                        $totalKasus = $totalKasusL + $totalKasusP;
                                        $totalKunjungan = $totalKunjunganL + $totalKunjunganP;
                                    @endphp
                                    <tr>
                                        <td>{{ $kode_diag }}</td>
                                        <td>{{ $deskripsi }}</td>
                                        <td style="text-align: center;">{{ $totalKasusL }}</td>
                                        <td style="text-align: center;">{{ $totalKasusP }}</td>
                                        <td style="text-align: center;"><strong>{{ $totalKasus }}</strong></td>
                                        <td style="text-align: center;">{{ $totalKunjunganL }}</td>
                                        <td style="text-align: center;">{{ $totalKunjunganP }}</td>
                                        <td style="text-align: center;"><strong>{{ $totalKunjungan }}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

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

        function myFunctionUnit() {
            var checkBox = document.getElementById("dataperunitC");
            var unit1 = document.getElementById("unitopt");
            const changeSelected = (e) => {
                const $select = document.querySelector('#valueopt');
                $select.value = ''
            };
            if (checkBox.checked == true) {
                unit1.style.display = "block";
            } else {
                unit1.style.display = "none";
                $('#valueopt').addEventListener('click', changeSelected);
            }
        }
    </script>
@endsection
@section('css')
    <style type="text/css" media="print">
        /* @media print {
                                @page {
                                    size: A4;
                                }
                            } */

        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }


        #hide_div {
            display: none;
        }
    </style>
    <style>
        .invoice {
            width: 100%;
            height: auto;
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
