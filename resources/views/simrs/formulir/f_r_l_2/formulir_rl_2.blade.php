@extends('adminlte::page')
@section('title', 'Formulir RL 2')
@section('content_header')
    <h1>Formulir RL 2</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="KETENAGAAN" theme="purple" >
                <form id="formFilter" action="" method="get">
                {{-- <form action="{{route('get-rl-5-3-d')}}" method="post">
                    @csrf --}}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="unit-group" id="tingkatpendidikan">
                                <x-adminlte-select2 name="tingkat" label="Tingkat Pendidikan">
                                    <option value="" >--Pilih Tingkat Pendidikan--</option>
                                    @foreach ($tingkat as $item)
                                        @if ($idt)
                                        <option {{$item->id_tingkat == $idt->id_tingkat ? 'selected' : ''}} value="{{ $item->id_tingkat }}">{{$item->nama_tingkat}}</option>
                                        @else
                                        <option value="{{ $item->id_tingkat }}">{{$item->nama_tingkat}}</option>
                                        @endif
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <x-adminlte-button type="submit" class="withLoad float-right btn btn-sm m-1 mt-4 bg-purple" label="Lihat Laporan" />
                            <button class="btn btn-success btn btn-sm m-1 mt-4 float-right" onclick="printDiv('printMe')">Print <i class="fas fa-print"></i></button>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
            {{-- @if (isset($dataGM)) --}}
                <div id="printMe">
                    <section class="invoice p-3 mb-3">
                        <div class="row p-3 kop-surat">
                            <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                            <div class="col mt-4">
                                <b >Formulir RL 2</b><br>
                                <b >KETENAGAAN</b>
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
                            <table class="table table-sm" >
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">No Kode</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Kualifikasi Pendidikan</th>
                                        <th colspan="2" style="text-align: center;">Keadaan</th>
                                        <th colspan="2" style="text-align: center;">Kebutuhan</th>
                                        <th colspan="2" style="text-align: center;">Kekurangan</th>
                                    </tr>
                                    <tr>
                                        <th>Laki-Laki</th>
                                        <th>Perempuan</th>
                                        <th>Laki-Laki</th>
                                        <th>Perempuan</th>
                                        <th>Laki-Laki</th>
                                        <th>Perempuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $bidang)
                                        <tr>
                                            <th></th>
                                            <th  colspan="7" style="vertical-align : middle;text-align:left;">{{$bidangd->where('id', $key)->first()->nama_bidang}}</th>
                                            
                                        </tr>
                                        @foreach ($bidang as $key_jurusan => $jurusan)
                                        <tr>
                                            <td></td>
                                            <td>{{$key_jurusan}}</td>
                                            <td style="text-align:center;">{{$jurusan->where('jenis_kelamin','L')->count()}}</td>
                                            <td style="text-align:center;">{{$jurusan->where('jenis_kelamin','P')->count()}}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <th style="vertical-align : middle;text-align:left;">Total</th>
                                            <td style="background-color: rgb(212, 211, 211)"></td>
                                            <td style="background-color: rgb(212, 211, 211)"></td>
                                            <td style="background-color: rgb(212, 211, 211)"></td>
                                            <td style="background-color: rgb(212, 211, 211)"></td>
                                            <td style="background-color: rgb(212, 211, 211)"></td>
                                            <td style="background-color: rgb(212, 211, 211)"></td>
                                        </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            {{-- @endif --}}
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
            var url = "{{ route('laporan-survailans.export') }}?" + data;
            window.location = url;
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
        thead, th, tbody {
            border: 1px solid #dfdcdc !important;
        }
    </style>

@endsection


