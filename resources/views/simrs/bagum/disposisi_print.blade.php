@extends('adminlte::print')
@section('title', 'Disposisi ' . $surat->asal_surat)
@section('content_header')
    <h1>Disposisi {{ $surat->asal_surat }}</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div id="printMe">
                <section class="invoice p-3 mb-1">
                    <div class="row">
                        <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                        <div class="col">
                            <b>RUMAH SAKIT UMUM DAERAH WALED KABUPATEN CIREBON</b><br>
                            Jl. Prabu Kiansantang No.4 Desa Waled Kota Kec. Waled Kab. Cirebon 45187
                            <br>
                            www.rsudwaled.id - brsud.waled@gmail.com - Call Center (0231) 661126
                        </div>
                        <hr width="100%" hight="20px" class="m-1 " color="black" size="50px" />
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col text-center">
                            <b class="text-xl">LEMBAR DISPOSISI</b> <br>
                            <br>
                        </div>
                    </div>
                    <div class="col-12 table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td style="width: 450px">
                                        <dl class="row">
                                            <dt class="col-sm-4 ">Surat Dari : </dt>
                                            <dd class="col-sm-8 ">{{ $surat->asal_surat }}</b></dd>
                                            <dt class="col-sm-4 ">No Surat : </dt>
                                            <dd class="col-sm-8 ">{{ $surat->no_surat }}</b></dd>
                                            <dt class="col-sm-4 ">Tanggal Surat : </dt>
                                            <dd class="col-sm-8 ">
                                                {{ Carbon\Carbon::parse($surat->tgl_surat)->translatedFormat('l, d F Y') }}</b>
                                                <br>
                                            </dd>
                                            <dt class="col-sm-4 ">Url Lampiran :</dt>
                                            <dd class="col-sm-8 ">
                                                {!! $surat->lampiran ? QrCode::size(100)->generate($surat->lampiran->fileurl) : '-' !!}
                                            </dd>

                                        </dl>
                                    </td>
                                    <td>
                                        <dl class="row">
                                            <dt class="col-sm-4 ">No. Disposisi</dt>
                                            <dd class="col-sm-8 ">:
                                                {{ str_pad($surat->no_urut, 3, '0', STR_PAD_LEFT) }}/{{ $surat->kode }}/{{ Carbon\Carbon::parse($surat->tgl_disposisi)->translatedFormat('m/Y') }}
                                            </dd>
                                            <dt class="col-sm-4 ">Tgl. Disposisi </dt>
                                            <dd class="col-sm-8 ">:
                                                {{ Carbon\Carbon::parse($surat->tgl_disposisi)->translatedFormat('l, d F Y') }}
                                                </b></dd>
                                        </dl>
                                        <div class="row">
                                            <dt class="col-sm-4 ">Sifat </dt>
                                            <dd class="col-sm-8 ">: </b></dd>
                                            <div class="col-md-4">
                                                <input type="checkbox">
                                                Sangat Segera
                                                {{-- <label>
                                                    Sangat Segera
                                                </label> --}}
                                            </div>
                                            <div class="col-md-4">
                                                <input type="checkbox">
                                                Segera
                                                {{-- <label>
                                                    Segera
                                                </label> --}}
                                            </div>
                                            <div class="col-md-4">
                                                <input type="checkbox">
                                                Rahasia
                                                {{-- <label>
                                                    Rahasia
                                                </label> --}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height: 100px"><b>Perihal : </b>
                                        <pre>{{ $surat->perihal }}</pre>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Diteruskan kepada Sdr. : </b></td>
                                    <td><b>Dengan harap hormat : </b></td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="vertical-align:bottom;">
                                        {{ $surat->pengolah ? $surat->pengolah : '.........................................................' }}
                                        <br>
                                    </td>
                                    <td>
                                        <div>
                                            @if ($surat->tindakan->contains('Untuk ditindaklanjuti'))
                                                <input type="checkbox" checked>
                                                <b>
                                                    Untuk ditindaklanjuti
                                                </b>
                                            @else
                                                <input type="checkbox">
                                                Untuk ditindaklanjuti
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            @if ($surat->tindakan->contains('Proses sesuai kemampuan / peraturan yang berlaku'))
                                                <input type="checkbox" checked>
                                                <b>
                                                    Proses sesuai kemampuan / peraturan yang berlaku
                                                </b>
                                            @else
                                                <input type="checkbox">
                                                Proses sesuai kemampuan / peraturan yang berlaku
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="vertical-align:bottom;">
                                        .........................................................</td>
                                    <td>
                                        <div>
                                            @if ($surat->tindakan->contains('Koordinasikan / konfirmasi dengan ybs / instansi terkait'))
                                                <input type="checkbox" checked>
                                                <b>
                                                    Koordinasikan / konfirmasi dengan ybs / instansi terkait
                                                </b>
                                            @else
                                                <input type="checkbox">
                                                Koordinasikan / konfirmasi dengan ybs / instansi terkait
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            @if ($surat->tindakan->contains('Untuk dibantu / difasilitasi / dipenuhi sesuai kebutuhan'))
                                                <input type="checkbox" checked>
                                                <b>
                                                    Untuk dibantu / difasilitasi / dipenuhi sesuai kebutuhan
                                                </b>
                                            @else
                                                <input type="checkbox">
                                                Untuk dibantu / difasilitasi / dipenuhi sesuai kebutuhan
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="vertical-align:bottom;">
                                        .........................................................</td>
                                    <td>
                                        <div>
                                            @if ($surat->tindakan->contains('Pelajari / telaah / sarannya'))
                                                <input type="checkbox" checked>
                                                <b>
                                                    Pelajari / telaah / sarannya
                                                </b>
                                            @else
                                                <input type="checkbox">
                                                Pelajari / telaah / sarannya
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            @if ($surat->tindakan->contains('Wakili / hadiri / terima / laporkan hasilnya'))
                                                <input type="checkbox" checked>
                                                <b>
                                                    Wakili / hadiri / terima / laporkan hasilnya
                                                </b>
                                            @else
                                                <input type="checkbox">
                                                Wakili / hadiri / terima / laporkan hasilnya
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="vertical-align:bottom;">
                                        .........................................................</td>
                                    <td>
                                        <div>
                                            @if ($surat->tindakan->contains('Agendakan / persiapkan / koordinasikan'))
                                                <input type="checkbox" checked>
                                                <b>
                                                    Agendakan / persiapkan / koordinasikan
                                                </b>
                                            @else
                                                <input type="checkbox">
                                                Agendakan / persiapkan / koordinasikan
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            @if ($surat->tindakan->contains('Jadwalkan ingatkan waktunya'))
                                                <input type="checkbox" checked>
                                                <b>
                                                    Jadwalkan ingatkan waktunya
                                                </b>
                                            @else
                                                <input type="checkbox">
                                                Jadwalkan ingatkan waktunya
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="vertical-align:bottom;">
                                        <b>Tgl Diteruskan :</b>
                                        {{ $surat->tgl_diteruskan ? \Carbon\Carbon::parse($surat->tgl_diteruskan)->translatedFormat('l, d F Y') : '...................' }}
                                    </td>
                                    <td>
                                        <div>
                                            @if ($surat->tindakan->contains('Siapkan pointer / sambutan / bahan'))
                                                <input type="checkbox" checked>
                                                <b>
                                                    Siapkan pointer / sambutan / bahan
                                                </b>
                                            @else
                                                <input type="checkbox">
                                                Siapkan pointer / sambutan / bahan
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            @if ($surat->tindakan->contains('Simpan / arsipkan'))
                                                <input type="checkbox" checked>
                                                <b>
                                                    Simpan / arsipkan
                                                </b>
                                            @else
                                                <input type="checkbox">
                                                Simpan / arsipkan
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>Catatan Disposisi :</b>
                                        <pre>{{ $surat->disposisi }}</pre>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <div class="text-center">
                                                    <b>Telah diterima oleh</b>
                                                    <br>
                                                    @if ($surat->tanda_terima)
                                                        {!! $surat->tanda_terima ? QrCode::size(100)->generate($pernyataan_penerima) : '-' !!}
                                                    @else
                                                        <br><br><br>
                                                    @endif
                                                    <br>
                                                    <u>
                                                        <b>
                                                            {{ $surat->tanda_terima }}
                                                        </b>
                                                    </u>
                                                    <br>
                                                </div>
                                                <div>
                                                    Tgl. Diterima :
                                                    {{ $surat->tgl_terima_surat ? Carbon\Carbon::parse($surat->tgl_terima_surat)->translatedFormat('l, d F Y') : '..............' }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="text-center">
                                                    <b>Plt. Direktur RSUD Waled</b>
                                                    <br>
                                                    @if ($surat->ttd_direktur)
                                                        {!! $surat->ttd_direktur ? QrCode::size(100)->generate($pernyataan_direktur) : '-' !!}
                                                    @else
                                                        <br><br><br>
                                                    @endif
                                                    <br>
                                                    <u>
                                                        <b>dr. Hj. Dwi Sudarni, MARS</b>
                                                    </u>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="footer-space">&nbsp;</div> --}}
                    <div class="footer">E-DISPOSISI RSUD WALED</div>



                </section>
            </div>
            <button class="btn btn-success btnPrint" onclick="printDiv('printMe')"><i class="fas fa-print"> Print
                    Laporan</i>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Select2', true)
@section('css')
    <style type="text/css" media="print">
        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }

        .main-footer {
            display: none !important;
        }

        .btnPrint {
            display: none !important;
        }

        .footer {
            position: fixed;
            bottom: 0;
        }

        .footer-space {
            height: 100px;
        }
    </style>
    <style type="text/css">
        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }

        table,
        th,
        td {
            border: 1px solid #333333 !important;
            font-size: 16px !important;
            padding: 3px !important;
        }

        pre {
            padding: 2 !important;
            font-size: 19px !important;
            border: none
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
    </script>
@endsection
