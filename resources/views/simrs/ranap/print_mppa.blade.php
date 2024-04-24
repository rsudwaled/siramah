@extends('adminlte::print')
@section('title', 'Print MPPA')
@section('content_header')
    <h1>
        Print MPPA</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="printMe">
                <section class="invoice p-3 mb-1">
                    <div class="row">
                        <div class="col-md-2 border border-dark">
                            <div class="m-2  text-center">
                                <img class="" src="{{ public_path('vendor/adminlte/dist/img/rswaled.png') }}"
                                    style="height: 80px">
                            </div>
                        </div>
                        <div class="col-md-6  border border-dark">
                            <b>PEMERINTAHAN KABUPATEN CIREBON</b><br>
                            <b>RUMAH SAKIT UMUM DAERAH WALED</b><br>
                            Jl. Prabu Kian Santang No. 4 Kab. Cirebon Jawa Barat 45151<br>
                            www.rsudwaled.id - 0823 1169 6919 - (0231) 8850943
                        </div>
                        {{-- <div class="col-md-4  border border-dark">
                            No RM : <b>{{ $pasien->no_rm }}</b> <br>
                            Nama : <b>{{ $pasien->nama_px }}</b> <br>
                            Tgl Lahir : <b>{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('d, F Y') }}
                                ({{ \Carbon\Carbon::parse($pasien->tgl_lahir)->diffInYears($kunjungan->tgl_masuk) }}
                                tahun)</b> <br>
                            Kelamin : <b>{{ $pasien->jenis_kelamin }}</b>
                        </div>
                        <div class="col-md-12 border border-dark text-center bg-warning">
                            <b>EVALUASI AWAL MPP (FORM A)</b><br>
                            <i>Diisi oleh Case Manager</i>
                        </div>
                        <div class="col-md-12 border border-dark" style="font-size: 12px">
                            <b>Tanggal </b> : {{ $mppa->created_at }} <br>
                            <b>Catatan </b> : {{ $mppa->catatan }} <br>
                        </div>
                        <div class="col-md-6 border border-dark" style="font-size: 12px">
                            <b>1. Identifikasi / skrining pasien terdapat jawaban </b><br>
                            <pre>{{ $mppa->skiring ?? '.........' }}</pre>
                            <b>2. Assesmen Meliputi</b> <br>
                            <b>a. Fisik, fungsional, kekuatan / kemampuan / kemandirian</b><br>
                            @if ($mppa->kemampuan == 'Mandiri Penuh')
                                &#x1F5F9; Mandiri Penuh
                            @else
                                &#x25A2; Mandiri Penuh
                            @endif
                            @if ($mppa->kemampuan == 'Mandiri Sebagian')
                                &#x1F5F9; Mandiri Sebagian
                            @else
                                &#x25A2; Mandiri Sebagian
                            @endif <br>
                            @if ($mppa->kemampuan == 'Total Bantuan')
                                &#x1F5F9; Total Bantuan
                            @else
                                &#x25A2; Total Bantuan
                            @endif
                            @if ($mppa->kemampuan_text)
                                &#x1F5F9; {{ $mppa->kemampuan_text }}
                            @else
                                &#x25A2; .............
                            @endif
                            <br>
                            <b>b. Riwayat Kesehatan</b> <br>
                            <pre>{{ $mppa->riwayat_kesehatan ?? '.........' }}</pre>
                            <b>c. Perilaku psiko-spiritual-sosio-kultural</b><br>
                            <pre>{{ $mppa->psikologi ?? '.........' }}</pre>
                            <b>d. Kesehatan mental dan kognitif</b><br>
                            <pre>{{ $mppa->mental ?? '.........' }}</pre>
                            <b>e. Lingkungan tempat tinggal</b><br>
                            <pre>{{ $mppa->lingkungan ?? '.........' }}</pre>
                            <b>f. Dukungan keluarga, kemampuan merawat dari pemberi asuhan</b><br>
                            @if ($mppa->dukungan == 'Ya')
                                &#x1F5F9; Ya
                            @else
                                &#x25A2; Ya
                            @endif
                            @if ($mppa->dukungan == 'Tidak')
                                &#x1F5F9; Tidak
                            @else
                                &#x25A2; Tidak
                            @endif <br>
                            <b>g. Finansial</b>
                            @if ($mppa->finansial == 'Baik')
                                &#x1F5F9; Baik
                            @else
                                &#x25A2; Baik
                            @endif
                            @if ($mppa->finansial == 'Sedang')
                                &#x1F5F9; Sedang
                            @else
                                &#x25A2; Sedang
                            @endif
                            @if ($mppa->finansial == 'Buruk')
                                &#x1F5F9; Buruk
                            @else
                                &#x25A2; Buruk
                            @endif
                            <b> Jaminan</b>
                            @if ($mppa->jaminan == 'Pribadi')
                                &#x1F5F9; Pribadi
                            @else
                                &#x25A2; Pribadi
                            @endif
                            @if ($mppa->jaminan == 'Asuransi')
                                &#x1F5F9; Asuransi
                            @else
                                &#x25A2; Asuransi
                            @endif
                            @if ($mppa->jaminan == 'JKN / BPJS')
                                &#x1F5F9; JKN / BPJS
                            @else
                                &#x25A2; JKN / BPJS
                            @endif <br>
                            <b>h. Riwayat Pengobatan Alternatif</b>
                            @if ($mppa->pengobatan_alt == 'Tidak')
                                &#x1F5F9; Tidak
                            @else
                                &#x25A2; Tidak
                            @endif
                            @if ($mppa->pengobatan_alt == 'Ya')
                                &#x1F5F9; Ya
                            @else
                                &#x25A2; Ya
                            @endif <br>
                            <b>i. Riwayat Trauma / Kekerasan</b>
                            @if ($mppa->trauma == 'Tidak')
                                &#x1F5F9; Tidak
                            @else
                                &#x25A2; Tidak
                            @endif
                            @if ($mppa->trauma == 'Ada')
                                &#x1F5F9; Ada
                            @else
                                &#x25A2; Ada
                            @endif <br>
                            <b>j. Pemahaman Tentang Kesehatan</b>
                            @if ($mppa->paham == 'Tidak Tahu')
                                &#x1F5F9; Tidak Tahu
                            @else
                                &#x25A2; Tidak Tahu
                            @endif
                            @if ($mppa->paham == 'Tahu')
                                &#x1F5F9; Tahu
                            @else
                                &#x25A2; Tahu
                            @endif <br>
                            <b>k. Harapan terhadap hasil asuhan, kemampuan menerima perubahan</b>
                            @if ($mppa->harapan == 'Tidak')
                                &#x1F5F9; Tidak
                            @else
                                &#x25A2; Tidak
                            @endif
                            @if ($mppa->harapan == 'Ada')
                                &#x1F5F9; Ada
                            @else
                                &#x25A2; Ada
                            @endif <br>
                            <b>l. Perkiraan Lama Ranap (Hari) ? </b> {{ $mppa->perkiraan_inap ?? '.........' }} hari<br>
                            <b>m. Discharge Plan </b>
                            @if ($mppa->discharge_plan == 'Tidak')
                                &#x1F5F9; Tidak
                            @else
                                &#x25A2; Tidak
                            @endif
                            @if ($mppa->discharge_plan == 'Ada')
                                &#x1F5F9; Ada
                            @else
                                &#x25A2; Ada
                            @endif <br>
                            <b>n. Perencanaan Lanjutan </b> <br>
                            @if ($mppa->rencana_lanjutan == 'Home Care')
                                &#x1F5F9; Home Care
                            @else
                                &#x25A2; Home Care
                            @endif
                            @if ($mppa->rencana_lanjutan == 'Rujuk')
                                &#x1F5F9; Rujuk
                            @else
                                &#x25A2; Rujuk
                            @endif
                            @if ($mppa->rencana_lanjutan == 'Pengobatan/Perawatan')
                                &#x1F5F9; Pengobatan/Perawatan
                            @else
                                &#x25A2; Pengobatan/Perawatan
                            @endif
                            @if ($mppa->rencana_lanjutan == 'Komunitas')
                                &#x1F5F9; Komunitas
                            @else
                                &#x25A2; Komunitas
                            @endif <br>
                            <b>o. Aspek Legal </b>
                            @if ($mppa->legalitas == 'Tidak')
                                &#x1F5F9; Tidak
                            @else
                                &#x25A2; Tidak
                            @endif
                            @if ($mppa->legalitas == 'Ada')
                                &#x1F5F9; Ada
                            @else
                                &#x25A2; Ada
                            @endif <br>
                        </div>
                        <div class="col-md-6 border border-dark" style="font-size: 12px">
                            <b>3. Identifikasi Masalah - Resiko - Kesempatan </b> <br>
                            @if (in_array('Tidak sesuai dengan CP / PPK', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                                &#x1F5F9; Tidak sesuai dengan CP / PPK
                            @else
                                &#x25A2; Tidak sesuai dengan CP / PPK
                            @endif <br>
                            @if (in_array('Adanya Komplikasi', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                                &#x1F5F9; Adanya Komplikasi
                            @else
                                &#x25A2; Adanya Komplikasi
                            @endif <br>
                            @if (in_array(
                                    'Pemahaman pasien kurang tentang penyakit, kondisi terkini, obat-obatan',
                                    json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                                &#x1F5F9; Pemahaman pasien kurang tentang penyakit, kondisi terkini, obat-obatan
                            @else
                                &#x25A2; Pemahaman pasien kurang tentang penyakit, kondisi terkini, obat-obatan
                            @endif <br>
                            @if (in_array(
                                    'Ketidakpatuhan pasien kendala keuangan ketika keparahan / komplikasi meningkat',
                                    json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                                &#x1F5F9; Ketidakpatuhan pasien kendala keuangan ketika keparahan / komplikasi meningkat
                            @else
                                &#x25A2; Ketidakpatuhan pasien kendala keuangan ketika keparahan / komplikasi meningkat
                            @endif <br>
                            @if (in_array('Terjadi Konflik', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                                &#x1F5F9; Terjadi Konflik
                            @else
                                &#x25A2; Terjadi Konflik
                            @endif <br>
                            @if (in_array(
                                    'Pemulangan / rujukan belum memenuhi kriteria / sebaliknya / ditunda',
                                    json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                                &#x1F5F9; Pemulangan / rujukan belum memenuhi kriteria / sebaliknya / ditunda
                            @else
                                &#x25A2; Pemulangan / rujukan belum memenuhi kriteria / sebaliknya / ditunda
                            @endif <br>
                            @if (in_array(
                                    'Tindakan / pengobatan yang tertunda / dibatalkan',
                                    json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                                &#x1F5F9; Tindakan / pengobatan yang tertunda / dibatalkan
                            @else
                                &#x25A2; Tindakan / pengobatan yang tertunda / dibatalkan
                            @endif <br>
                            <b>4. Perencanaan MPP </b> <br>
                            @if (in_array('Kebutuhan asuhan', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)))
                                &#x1F5F9; Kebutuhan asuhan
                            @else
                                &#x25A2; Kebutuhan asuhan
                            @endif <br>
                            @if (in_array('Kebutuhan edukasi', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)))
                                &#x1F5F9; Kebutuhan edukasi
                            @else
                                &#x25A2; Kebutuhan edukasi
                            @endif <br>
                            @if (in_array('Solusi konflik', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)))
                                &#x1F5F9; Solusi konflik
                            @else
                                &#x25A2; Solusi konflik
                            @endif <br>
                            @if (in_array('Diagnosis', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)))
                                &#x1F5F9; Diagnosis
                            @else
                                &#x25A2; Diagnosis
                            @endif <br>
                            <b>Jangka Pendek</b> <br>
                            <pre>{{ $mppa->jangka_pendek ?? '.........' }}</pre>
                            <b>Jangka Panjang</b> <br>
                            <pre>{{ $mppa->jangka_panjang ?? '.........' }}</pre>
                            <b>Kebutuhan Berjalan</b> <br>
                            <pre>{{ $mppa->kebutuhan_berjalan ?? '.........' }}</pre>
                            <b>Lain-lain</b> <br>
                            <pre>{{ $mppa->lain_lain ?? '.........' }}</pre>
                        </div>
                        <div class="col-md-8" style="font-size: 12px">
                        </div>
                        <div class="col-md-4" style="font-size: 12px">
                            <center>
                                Waled, ..... ..............

                                <br><br><br>
                                <b><u>{{ $mppa->pic }}</u></b>
                            </center>
                        </div> --}}
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
            margin-bottom: 0px;
            padding: 0 !important;
            font-size: 12px;
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
            margin-bottom: 0px;
            padding: 0 !important;
            font-size: 12px;
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
        // $(document).ready(function() {
        //     window.print();
        // });
        // setTimeout(function() {
        //     window.top.close();
        // }, 2000);
    </script>
@endsection
