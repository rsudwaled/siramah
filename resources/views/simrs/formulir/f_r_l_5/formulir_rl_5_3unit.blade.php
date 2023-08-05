@extends('adminlte::page')
@section('title', 'Formulir RL 5.3')
@section('content_header')
    <h1>Daftar Penyakit Rawat Inap Perunit </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Daftar Penyakit Rawat Inap Perunit" theme="secondary" id="hide_div" collapsible>
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
                                    <x-adminlte-input-date name="sampai" id="to" label="Tanggal Selesai" :config="$config"
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
                                    <div class="row">
                                        <div class="col-">
                                            <x-adminlte-input name="jumlah" label="Jumlah" placeholder="jumlah data yang akan ditampilkan..." value={{$jml}} >
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-user text-lightblue"></i>
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-input>
                                        </div>
                                        <div class="col- ml-2">
                                            <x-adminlte-select2 name="unit" required id="unit" label="Pilih Unit">
                                                @foreach ($unit as $item)
                                                    <option {{ $item->KODE_UNIT == $sel ? 'selected':'' }} value="{{$item->KODE_UNIT}}">{{$item->KODE_UNIT}} | {{$item->NAMA_UNIT}}</option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </div>
                                    </div>
                                    <div class="row mt-4 float-right">
                                        <a class="btn btn-sm m-1 btn-warning" href="{{ route('frl-5.get') }}">Kembali</a>
                                        @if (isset($laporanFM))
                                        <button class="btn btn-success btn btn-sm m-1" onclick="printDiv('printMe')">Print <i class="fas fa-print"></i></button>
                                        @endif
                                        <x-adminlte-button type="submit" class="btn btn-sm m-1 bg-primary" theme="primary" label="Lihat Laporan" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
            @if (isset($laporanFM))
                <div id="printMe">
                    <section class="invoice p-3 mb-3">
                        <div class="row p-3 kop-surat" style="vertical-align : middle;text-align:left;">
                            <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                            <div class="col mt-4">
                                <b >Formulir RL 5.3</b><br>
                                <b > DAFTAR {{$jml}} BESAR PENYAKIT RAWAT INAP</b>
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
                                    <tr>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;"id="no">No. Urut</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Kode ICD 10</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Deskripsi</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;" id="terapi">Jumlah Keluar Hidup</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;" id="terapi">Jumlah Keluar Mati</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="vertical-align : middle;text-align:center;" id="terapi">Pasien Hidup & Mati Menurut Jenis Kelamin</th>
                                        <th colspan="2" style="vertical-align : middle;text-align:center;" id="terapi">Jumlah</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>LK</th>
                                        <th>PR</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporanFM as $item )
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->kode_icd}}</td>
                                            <td style="vertical-align : middle;text-align:left;">{{$item->Nama_Penyakit}}</td>
                                            <td>{{$item->Jumlah_KELUAR_HIDUP}}</td>
                                            <td>{{$item->Jumlah_KELUAR_MATI}}</td>
                                            <td>{{$item->HIDUP_MATI_LK}}</td>
                                            <td>{{$item->HIDUP_MATI_PR}}</td>
                                            <td>{{$item->JUMLAH}}</td>

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
        $(document).on('click', '#perunit', function(e) {
            $.LoadingOverlay("show");
            var data = $('#formFilter').serialize();
            var url = "{{ route('frl-5perunit.get') }}?" + data;
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
    </style>

@endsection
