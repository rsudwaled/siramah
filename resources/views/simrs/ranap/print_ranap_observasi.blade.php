@extends('adminlte::print')
@section('title', 'Print Observasi Rawat Inap')
@section('content_header')
    <h1>Print Observasi Rawat Inap</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="printMe">
                <section class="invoice p-3 mb-1">
                    <div class="row">
                        <div class="col-md-2 border border-dark">
                            <div class="m-2  text-center">
                                <img class="" src="{{ asset('vendor/adminlte/dist/img/rswaled.png') }}"
                                    style="height: 80px">
                            </div>
                        </div>
                        <div class="col-md-6  border border-dark">
                            <b>PEMERINTAHAN KABUPATEN CIREBON</b><br>
                            <b>RUMAH SAKIT UMUM DAERAH WALED</b><br>
                            Jl. Prabu Kian Santang No. 4 Kab. Cirebon Jawa Barat 45151<br>
                            www.rsudwaled.id - 0823 1169 6919 - (0231) 8850943
                        </div>
                        <div class="col-md-4  border border-dark">
                            <div class="row">
                                <div class="p-2">
                                    No RM : <b>{{ $pasien->no_rm }}</b> <br>
                                    Nama : <b>{{ $pasien->nama_px }}</b> <br>
                                    Tgl Lahir : <b>{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('d, F Y') }}
                                        ({{ \Carbon\Carbon::parse($pasien->tgl_lahir)->diffInYears($kunjungan->tgl_masuk) }}
                                        tahun)</b> <br>
                                    Kelamin : <b>{{ $pasien->jenis_kelamin }}</b>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 border border-dark text-center bg-warning">
                            <b>OBSERVASI PASIEN RAWAT INAP</b>
                        </div>
                        <div class="col-md-2 border border-dark">
                            <b>Tanggal Jam</b>
                        </div>
                        <div class="col-md-2 border border-dark">
                            <b>Pemeriksaan Vital</b>
                        </div>
                        <div class="col-md-4 border border-dark">
                            <b>Pupil & Kesadaran</b>
                        </div>
                        <div class="col-md-2 border border-dark">
                            <b>Keterangan</b>
                        </div>
                        <div class="col-md-2 border border-dark">
                            <b>Tanda Tangan</b>
                        </div>
                        @foreach ($keperawatan as $item)
                            <div class="col-md-2 border border-dark">
                                {{ $item->tanggal_input }}
                            </div>
                            <div class="col-md-2 border border-dark">
                                <div class="row">
                                    <div class="col-md-6">
                                        Tensi : {{ $item->tensi }} <br>
                                        Nadi : {{ $item->nadi }} <br>
                                        RR : {{ $item->RR }} <br>
                                    </div>
                                    <div class="col-md-6">
                                        Suhu : {{ $item->suhu }} <br>
                                        GDS : {{ $item->gds }} <br>
                                        ECG : {{ $item->ecg }} <br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 border border-dark">
                                Pupil Kanan : {{ $item->pupilkanan }} <br>
                                Pupil Kiri : {{ $item->pupilkiri }} <br>
                                Kesadaran : {{ $item->kesadaran }} <br>
                            </div>
                            <div class="col-md-2 border border-dark">
                                {{ $item->keterangan }}
                            </div>
                            {{-- <div class="col-md-7 border border-dark">
                                <pre>{{ $item->keperawatan }}</pre>
                            </div> --}}
                            <div class="col-md-2 border border-dark">
                                {{ $item->pic }}
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
            {{-- <button class="btn btn-success btnPrint" onclick="printDiv('printMe')"><i class="fas fa-print"> Print
                    Laporan</i> --}}
        </div>
    </div>
@stop
@section('css')
    <style>
        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            font-size: 15px;
        }
    </style>
    <style type="text/css" media="print">
        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }

        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            font-size: 15px;
        }

        #resepobat {
            font-size: 22px !important;
            border: none;
            outline: none;
            padding: 0 !important;
        }

        .main-footer {
            display: none !important;
        }

        .btnPrint {
            display: none !important;
        }
    </style>
@endsection
@section('js')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            tampilan_print = document.body.innerHTML = printContents;
            setTimeout('window.addEventListener("load", window.print());', 1000);
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            window.print();
        });
        setTimeout(function() {
            window.top.close();
        }, 2000);
    </script>
@endsection
