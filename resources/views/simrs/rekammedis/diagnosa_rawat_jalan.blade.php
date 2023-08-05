@extends('adminlte::page')
@section('title', 'Diagnosa Rawat Jalan')
@section('content_header')
    <h1>Diagnosa Rawat Jalan</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Data Kunjungan" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" label="Tanggal Antrian" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-select2 name="kodepoli" label="Poliklinik">
                                @foreach ($unit as $item)
                                    <option value="{{ $item->KDPOLI }}"
                                        {{ $item->KDPOLI == $request->kodepoli ? 'selected' : null }}>
                                        {{ $item->nama_unit }} ({{ $item->KDPOLI }})
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Laporan" />
                </form>
            </x-adminlte-card>
            @if (isset($kunjungans))
                <div id="printMe">
                    <section class="invoice p-3 mb-3">
                        <div class="row">
                            <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                            <div class="col">
                                <b>RUMAH SAKIT UMUM DAERAH WALED KABUPATEN CIREBON</b><br>
                                Jalan Raden Walangsungsang Kecamatan Waled Kabupaten Cirebon 45188<br>
                                www.rsudwaled.id - brsud.waled@gmail.com - Call Center (0231) 661126
                            </div>
                            <hr width="100%" hight="20px" class="m-1 " color="black" size="50px" />
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-12 invoice-col text-center">
                                <b class="text-lg">DIAGNOSA RAWAT JALAN</b>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <dl class="row">
                                    <dt class="col-sm-4 m-0">Poliklinik</dt>
                                    <dd class="col-sm-8 m-0"> :
                                        <b>{{ $unit->firstWhere('KDPOLI', $request->kodepoli)->nama_unit }}</b>
                                    </dd>
                                    <dt class="col-sm-4 m-0">Tanggal</dt>
                                    <dd class="col-sm-8 m-0"> :
                                        <b>{{ \Carbon\Carbon::parse($request->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</b>
                                    </dd>
                                    {{-- <dt class="col-sm-4  m-0">User</dt>
                                    <dd class="col-sm-8  m-0"> :
                                        <b>{{ Auth::user()->name }}</b>
                                    </dd>
                                    <dt class="col-sm-4  m-0">Waktu Cetak</dt>
                                    <dd class="col-sm-8  m-0"> :
                                        <b>{{ Carbon\Carbon::now() }}</b>
                                    </dd> --}}
                                </dl>
                            </div>
                        </div>
                        <div class="col-12 table-responsive">
                            <table class="table table-sm text-xs">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Diagnosa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kunjungans as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->no_rm }}</td>
                                            <td>{{ $item->pasien->nama_px }}</td>
                                            <td>
                                                @if ($item->assesmen_dokter)
                                                    {{ $item->assesmen_dokter->diagnosakerja }}
                                                @else
                                                    <i>belum diisi</i>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <button class="btn btn-success" onclick="printDiv('printMe')">Print<i class="fas fa-print"></i>
                    Print
                    Laporan</button>
            @endif
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            tampilan_print = document.body.innerHTML = printContents;
            setTimeout('window.addEventListener("load", window.print());', 1000);
        }
    </script>
@endsection
@section('css')
    <style type="text/css" media="print">
        @media print {
            @page {
                size: landscape
            }
        }

        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }

        table,
        th,
        td {
            border: 1px solid #333333 !important;
            font-size: 10px !important;
            padding: 2px !important;
        }
    </style>

@endsection
