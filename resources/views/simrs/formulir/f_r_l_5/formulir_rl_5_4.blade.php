@extends('adminlte::page')
@section('title', 'Formulir RL 5.4')
@section('content_header')
    <h1>Daftar Penyakit Rawat Jalan </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row" id="hide_div" >
                <div class="col-lg-12">
                    <x-adminlte-card title="Penyakit Rawat Jalan" theme="purple" >
                        <form action="{{route('get-rl-5-4-u')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    @php
                                        $config = ['format' => 'YYYY-MM-DD'];
                                    @endphp
                                    <x-adminlte-input-date name="dari" id="from" label="Tanggal Mulai" :config="$config"
                                        value="{{ $from == null ? \Carbon\Carbon::parse($request->dari)->format('Y-m-d') : $from }}">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-purple">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                    <x-adminlte-input-date name="sampai" id="to" label="Tanggal Selesai" :config="$config"
                                        value="{{ $to == null ? \Carbon\Carbon::parse($request->sampai)->format('Y-m-d') : $to }}">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-purple">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                                <div class="col-lg-6">
                                    <x-adminlte-input name="jumlah" label="Jumlah Data" placeholder="jumlah data yang akan ditampilkan..." >
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text">
                                                <i class="fas fa-user text-purple"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="dataperunitC" name="dataperunit" onclick="myFunctionUnit()">
                                        <label for="dataperunitC" class="custom-control-label">Laporan Perunit</label>
                                    </div>
                                    <div class="unit-group" id="unitopt" style="display:none">
                                        <x-adminlte-select2 name="unit" label="Pilih Unit" id="valueopt">
                                            <option value="" id="opt_null">--Pilih Unit--</option>
                                            @foreach ($unit as $item)
                                                <option value="{{ $item->KODE_UNIT}}">{{$item->KODE_UNIT}} | {{$item->NAMA_UNIT}}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                    <x-adminlte-button type="submit" class="withLoad float-right btn btn-sm m-1 mt-4 bg-purple" label="Lihat Laporan" />
                                    @if (isset($laporanFM))
                                    <button class="btn btn-success btn btn-sm m-1 mt-4 float-right" onclick="printDiv('printMe')">Print <i class="fas fa-print"></i></button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </x-adminlte-card>
                </div>
            </div>
            @if (isset($laporanFM))
                @if ($kode_unit)
                <div id="printMe">
                    <section class="invoice p-3 mb-3">
                        <div class="row p-3 kop-surat" style="vertical-align : middle;text-align:left;">
                            <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                            <div class="col mt-4">
                                <b >Formulir RL 5.4</b><br>
                                <b > DAFTAR {{$jml}} BESAR PENYAKIT RAWAT JALAN PERUNIT</b>
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
                                    <div class="col-sm-5"><b>: {{$th}}</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 table-responsive table-laporan">
                            <table class="table table-sm" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;" id="no">No. Urut</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Kode ICD 10</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Deskripsi</th>

                                        <th colspan="2" style="vertical-align : middle;text-align:center;" id="terapi">Kasus Baru</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;" id="terapi">Jumlah Kasus Baru</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;" id="terapi">Jumlah</th>
                                    </tr>
                                    <tr>
                                        <th>LK</th>
                                        <th>PR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporanFM as $item )
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->kode_icd}}</td>
                                            <td style="vertical-align : middle;text-align:left;">{{$item->Nama_Penyakit}}</td>
                                            <td>{{$item->Kasus_Baru_LK}}</td>
                                            <td>{{$item->Kasus_Baru_PR}}</td>
                                            <td>{{$item->JML_KASUS_BARU}}</td>
                                            <td>{{$item->Jumlah}}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                @else
                <div id="printMe">
                    <section class="invoice p-3 mb-3">
                        <div class="row p-3 kop-surat" style="vertical-align : middle;text-align:left;">
                            <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                            <div class="col mt-4">
                                <b >Formulir RL 5.4</b><br>
                                <b > DAFTAR {{$jml}} BESAR PENYAKIT RAWAT JALAN</b>
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
                                    <div class="col-sm-5"><b>: {{$th}}</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 table-responsive table-laporan">
                            <table class="table table-sm" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;"id="no">No. Urut</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Kode ICD 10</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Deskripsi</th>
                                        <th colspan="2" style="vertical-align : middle;text-align:center;" >Pasien Kasus Baru Menurut Jenis Kelamin</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;" >Jumlah Kasus Baru</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;" >Jumlah Kunjungan</th>
                                    </tr>
                                    <tr>
                                        <th >LK</th>
                                        <th >PR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporanFM as $item )
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->kode_icd}}</td>
                                            <td style="vertical-align : middle;text-align:left;">{{$item->Nama_Penyakit}}</td>
                                            <td>{{$item->Kasus_Baru_LK}}</td>
                                            <td>{{$item->Kasus_Baru_PR}}</td>
                                            <td>{{$item->JML_KASUS_BARU}}</td>
                                            <td>{{$item->Jumlah}}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                @endif
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
        function myFunctionUnit() {
            var checkBox = document.getElementById("dataperunitC");
            var unit1 = document.getElementById("unitopt");
            const changeSelected = (e) => {
            const $select = document.querySelector('#valueopt');
                $select.value = ''
            };
            if (checkBox.checked == true){
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
        .invoice{
            width: 100%;
            height: auto;
        }
        #show_print {
            display: none;
        }
        thead, th, tbody {
            border: 1px solid #dfdcdc !important;
        }
    </style>

@endsection
