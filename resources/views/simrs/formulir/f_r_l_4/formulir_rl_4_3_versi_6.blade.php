@extends('adminlte::page')
@section('title', 'Formulir RL 4.3')
@section('content_header')
    <h1>10 BESAR KEMATIAN PENYAKIT RAWAT INAP</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="FILTER DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT" theme="secondary"
                id="hide_div" collapsible>
                <form id="formFilter" action="" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="dari" id="from" label="Tanggal Mulai" :config="$config"
                                value="{{ $from == null ? \Carbon\Carbon::parse($request->dari)->format('Y-m-d') : $from }}">
                                {{-- value="2023-06-01"> --}}
                                {{-- value="-"> --}}
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
                                        {{-- value="-"> --}}
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-primary">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                                <div class="col-md-8">
                                    <div class="row mt-4 float-right">
                                        <x-adminlte-button type="submit" class="withLoad btn btn-sm m-1 bg-primary"
                                            id="ranap" label="Lihat Data" />
                                        {{-- <x-adminlte-button label="Morbiditas Ranap K" class="float-right btn btn-sm m-1 bg-primary"  id="ranap_k" /> --}}
                                        @if (isset($laporanFM))
                                            <button class="btn btn-success btn btn-sm m-1"
                                                onclick="printDiv('printMe')">Print <i class="fas fa-print"></i></button>
                                        @endif

                                        <x-adminlte-button type="submit" label="Excel" class="bg-purple btn btn-sm m-1"
                                            target="_blank"
                                            onclick="javascript: form.action='{{ route('frl-4-3.export') }}';" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>

        </div>
    </div>
@endsection

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)

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
