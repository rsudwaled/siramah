@extends('adminlte::page')
@section('title', 'Formulir RL 5.1')
@section('content_header')
    <h1>Formulir RL 5.1</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Formulir RL 5.1" theme="secondary" id="hide_div" collapsible>
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
                                        <x-adminlte-button type="submit" label="Excel"
                                                class="bg-purple btn btn-sm m-1" target="_blank"
                                                onclick="javascript: form.action='{{ route('frl-5-1.export') }}';" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
           @if ($rekap)
               <div class="col-12">
                <table style="border: 1px solid black;" cellpadding="6" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="2">Diagnosa</th>
                            {{-- Header kelompok umur --}}
                            @foreach ($kelompokUmurList as $umur)
                                <th colspan="2">{{ $umur }}</th>
                            @endforeach
                            <th rowspan="2">Total Kunjungan Baru (L)</th>
                            <th rowspan="2">Total Kasus Baru (L)</th>
                            <th rowspan="2">Total Kunjungan Baru (P)</th>
                            <th rowspan="2">Total Kasus Baru (P)</th>
                        </tr>
                        <tr>
                            {{-- Sub header untuk L/P --}}
                            @foreach ($kelompokUmurList as $umur)
                                <th>L</th>
                                <th>P</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($rekap as $kode_diag => $data)
                            @php
                                // Inisialisasi total per jenis kelamin (L/P) untuk kolom kanan
                                $totalKunjunganL = 0;
                                $totalKasusL = 0;
                                $totalKunjunganP = 0;
                                $totalKasusP = 0;
                            @endphp

                            <tr style="border: 1px solid rgb(140, 140, 140);">
                                <td style="border: 1px solid rgb(140, 140, 140);">
                                    {{ $kode_diag }}
                                    <br><small>{{ implode(', ', $data['deskripsi']) }}</small>
                                </td>

                                {{-- Iterasi kelompok umur --}}
                                @foreach ($kelompokUmurList as $umur)
                                    {{-- @php
                                        // Ambil data untuk Laki-laki dan Perempuan
                                        $laki = $data['L'][$umur] ?? ['total_kasus_baru' => 0];
                                        $perempuan = $data['P'][$umur] ?? ['total_kasus_baru' => 0];

                                        // Update total kasus per jenis kelamin
                                        $totalKasusL += $laki['total_kasus_baru'];
                                        $totalKasusP += $perempuan['total_kasus_baru'];
                                    @endphp --}}

                                    @php
                                        // Ambil data untuk Laki-laki dan Perempuan
                                        $laki = $data['L'][$umur] ?? ['total_kunjungan_baru' => 0, 'total_kasus_baru' => 0];
                                        $perempuan = $data['P'][$umur] ?? ['total_kunjungan_baru' => 0, 'total_kasus_baru' => 0];

                                        // Update total per jenis kelamin
                                        $totalKunjunganL += $laki['total_kunjungan_baru'];
                                        $totalKasusL += $laki['total_kasus_baru'];
                                        $totalKunjunganP += $perempuan['total_kunjungan_baru'];
                                        $totalKasusP += $perempuan['total_kasus_baru'];
                                    @endphp

                                    {{-- Tampilkan hanya kasus baru untuk Laki-laki dan Perempuan --}}
                                    <td style="border: 1px solid rgb(140, 140, 140);">
                                        {{ $laki['total_kasus_baru'] == 0 ? '-' : $laki['total_kasus_baru'] }}
                                    </td>
                                    <td style="border: 1px solid rgb(140, 140, 140);">
                                        {{ $perempuan['total_kasus_baru'] == 0 ? '-' : $perempuan['total_kasus_baru'] }}
                                    </td>
                                @endforeach

                                {{-- Kolom total kunjungan baru dan kasus baru per jenis kelamin --}}
                                <td style="border: 1px solid rgb(140, 140, 140);"><strong>{{ $totalKunjunganL == 0 ? '-' : $totalKunjunganL }}</strong></td>
                                <td style="border: 1px solid rgb(140, 140, 140);"><strong>{{ $totalKasusL == 0 ? '-' : $totalKasusL }}</strong></td>
                                <td style="border: 1px solid rgb(140, 140, 140);"><strong>{{ $totalKunjunganP == 0 ? '-' : $totalKunjunganP }}</strong></td>
                                <td style="border: 1px solid rgb(140, 140, 140);"><strong>{{ $totalKasusP == 0 ? '-' : $totalKasusP }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

