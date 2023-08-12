@extends('adminlte::page')
@section('title', 'Formulir RL 3.2')
@section('content_header')
    <h1>Formulir RL 3.2</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Formulir RL 3.2" theme="secondary" id="hide_div" collapsible>
                <form id="formFilter" action="" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="dari" id="from" label="Tanggal Mulai" :config="$config"
                                {{-- value="{{ $from == null ? \Carbon\Carbon::parse($request->dari)->format('Y-m-d') : $from }}"> --}}
                                value="2023-06-01">
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
                                        {{-- value="{{ $to == null ? \Carbon\Carbon::parse($request->sampai)->format('Y-m-d') : $to }}"> --}}
                                        value="2023-06-30">
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
                                        @if (isset($kunjunganRD))
                                        <x-adminlte-button label="Excel" class="bg-purple btn btn-sm m-1" id="export" />
                                        <button class="btn btn-success btn btn-sm m-1" onclick="printDiv('printMe')">Print <i class="fas fa-print"></i></button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
            @if (isset($kunjunganRD))
                <div id="printMe">
                    <section class="invoice p-3 mb-3">
                        <div class="row p-3 kop-surat">
                            <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                            <div class="col mt-4">
                                <b >Formulir RL 3.2</b><br>
                                <b >KUNJUNGAN RAWAT DARURAT</b>
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
                                    <div class="col-sm-5"><b>: 2023</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 table-responsive table-laporan">
                            <table class="table table-sm" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;" id="no">No</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Jenis Pelayanan</th>
                                        <th colspan="2" style="vertical-align : middle;text-align:center;" id="terapi">Total Pasien</th>
                                        <th colspan="3" style="vertical-align : middle;text-align:center;" id="terapi">Tindak Lanjut Pelayanan</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Mati di IGD</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">DOA</th>
                                    </tr>
                                    <tr>
                                        <th>RUJUKAN</th>
                                        <th>NON RUJUKAN</th>
                                        <th>DIRAWAT</th>
                                        <th>DIRUJUK</th>
                                        <th>PULANG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kunjunganRD as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->JENIS_PELAYANAN}}</td>
                                        <td>{{$item->RUJUKAN}}</td>
                                        <td>{{$item->NON_RUJUKAN}}</td>
                                        <td>{{$item->DIRAWAT}}</td>
                                        <td>{{$item->RUJUK}}</td>
                                        <td>{{$item->PELAYANAN_PULANG}}</td>
                                        <td>{{$item->MATI_PRA_PERAWATAN}}</td>
                                        <td>{{$item->DOA}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <td>{{$kunjunganRD->sum('RUJUKAN')}}</td>
                                        <td>{{$kunjunganRD->sum('NON_RUJUKAN')}}</td>
                                        <td>{{$kunjunganRD->sum('DIRAWAT')}}</td>
                                        <td>{{$kunjunganRD->sum('RUJUK')}}</td>
                                        <td>{{$kunjunganRD->sum('PELAYANAN_PULANG')}}</td>
                                        <td>{{$kunjunganRD->sum('MATI_PRA_PERAWATAN')}}</td>
                                        <td>{{$kunjunganRD->sum('DOA')}}</td>
                                    </tr>
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


