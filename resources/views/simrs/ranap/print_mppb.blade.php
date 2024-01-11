@extends('adminlte::print')
@section('title', 'Print MPPB')
@section('content_header')
    <h1>
        Print MPPB</h1>
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
                            No RM : <b>{{ $pasien->no_rm }}</b> <br>
                            Nama : <b>{{ $pasien->nama_px }}</b> <br>
                            Tgl Lahir : <b>{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('d, F Y') }}
                                ({{ \Carbon\Carbon::parse($pasien->tgl_lahir)->diffInYears($kunjungan->tgl_masuk) }}
                                tahun)</b> <br>
                            Kelamin : <b>{{ $pasien->jenis_kelamin }}</b>
                        </div>
                        <div class="col-md-12 border border-dark text-center bg-warning">
                            <b>EVALUASI AWAL MPP (FORM B)</b><br>
                            <i>Diisi oleh Case Manager</i>
                        </div>
                        <div class="col-md-12 border border-dark" style="font-size: 12px">
                            <b>Tanggal </b> : {{ $mppb->created_at }} <br>
                            <b>Catatan </b> : {{ $mppb->catatan }} <br>
                        </div>
                        <div class="col-md-6 border border-dark" style="font-size: 12px">
                            <b>1. Rencana Pelayanan Pasien</b><br>
                            <pre>{{ $mppb->rencana ?? '.........' }}</pre>
                            <b>2. Monitoring pelayanan / asuhan pasien seluruh PPA (perkembangan, kolaborasi) verifikasi
                                respon terhadap intervensi yang diberikan, revisi rencana asuhan termasuk preferensi
                                perubahan, transisi pelayanan dan kendala pelayanan.</b><br>
                            <pre>{{ $mppb->monitoring ?? '.........' }}</pre>
                            <b>3. Memfasilitasi pelayanan</b> <br>
                            <b>- Konsultasi / Kolaborasi</b> <br>
                            <pre>{{ $mppb->konsultasi ?? '.........' }}</pre>
                            <b>- Second Opinion</b> <br>
                            <pre>{{ $mppb->second_opsi ?? '.........' }}</pre>
                            <b>- Rawat bersama / alih rawat</b> <br>
                            <pre>{{ $mppb->rawat_bersama ?? '.........' }}</pre>
                            <b>- Komunikasi / edukasi</b> <br>
                            <pre>{{ $mppb->komunikasi ?? '.........' }}</pre>
                            <b>- Rujukan</b> <br>
                            <pre>{{ $mppb->rujukan ?? '.........' }}</pre>
                        </div>
                        <div class="col-md-6 border border-dark" style="font-size: 12px">
                            <b>4. Advokasi pelayanan pasien</b> <br>
                            @if (in_array('Diskusi', json_decode($kunjungan->erm_ranap_mppb->advokasi)))
                                &#x1F5F9; Diskusi dengan PPA staff lain tentang kebutuhan pasien
                            @else
                                &#x25A2; Diskusi dengan PPA staff lain tentang kebutuhan pasien
                            @endif <br>
                            @if (in_array('Memfasilitasi', json_decode($kunjungan->erm_ranap_mppb->advokasi)))
                                &#x1F5F9; Memfasilitasi akses pelayanan sesuai kebutuhan pasien berkoodinasi dengan PPA dan
                                pemangku kepentingan
                            @else
                                &#x25A2; Memfasilitasi akses pelayanan sesuai kebutuhan pasien berkoodinasi dengan PPA dan
                                pemangku kepentingan
                            @endif <br>
                            @if (in_array('Meningkatkan', json_decode($kunjungan->erm_ranap_mppb->advokasi)))
                                &#x1F5F9; Meningkatkan kemandirian untuk menentukan pilihan / pengambilan keputusan
                            @else
                                &#x25A2; Meningkatkan kemandirian untuk menentukan pilihan / pengambilan keputusan
                            @endif <br>
                            @if (in_array('Mengenali', json_decode($kunjungan->erm_ranap_mppb->advokasi)))
                                &#x1F5F9; Mengenali, mencegah, menghindari
                                disparatis untuk mengakses mutu dan hasil pelayanan terkait ras, etnik, agama,
                                gender, budaya, status pernikahan, umur, politik, disabilitas fisik-mental-kognitif
                            @else
                                &#x25A2; Mengenali, mencegah, menghindari
                                disparatis untuk mengakses mutu dan hasil pelayanan terkait ras, etnik, agama,
                                gender, budaya, status pernikahan, umur, politik, disabilitas fisik-mental-kognitif
                            @endif <br>
                            @if (in_array('pemenuhan', json_decode($kunjungan->erm_ranap_mppb->advokasi)))
                                &#x1F5F9; Untuk pemenuhan kebutuhan pelayanan yang berkembang / bertambah karena perubahan
                                kondisi
                            @else
                                &#x25A2; Untuk pemenuhan kebutuhan pelayanan yang berkembang / bertambah karena perubahan
                                kondisi
                            @endif <br>
                            <b>5. Informasi pelayanan / hasil pelayanan </b> <br>
                            <b>a. Sasaran</b> <br>
                            <pre>{{ $mppb->sasaran ?? '.........' }}</pre>
                            <b>b. Keberhasilan, kualitas, kendali biaya efektif dari intervensi MPP mencapai sasaran asuhan
                                pasien</b> <br>
                            <pre>{{ $mppb->keberhasilan ?? '.........' }}</pre>
                            <b>c. Nilai / laporan dampak pelaksanaan asuhan pasien</b> <br>
                            <pre>{{ $mppb->nilai ?? '.........' }}</pre>
                            <b>d. Catatan utilisasi sesuai panduan / norma</b> <br>
                            <pre>{{ $mppb->utilitas ?? '.........' }}</pre>
                            <b>6. Terminasi pelayanan pasien catatan keputusan pasien / keluarga dengan MPP</b><br>
                            @if ($mppb->terminasi == 'Puas')
                                &#x1F5F9; Puas
                            @else
                                &#x25A2; Puas
                            @endif
                            @if ($mppb->terminasi == 'Tidak Puas')
                                &#x1F5F9; Tidak Puas
                            @else
                                &#x25A2; Tidak Puas
                            @endif
                            @if ($mppb->terminasi == 'Abstain')
                                &#x1F5F9; Abstain
                            @else
                                &#x25A2; Abstain
                            @endif
                            @if ($mppb->terminasi == 'Bermasalah')
                                &#x1F5F9; Bermasalah
                            @else
                                &#x25A2; Bermasalah
                            @endif
                            @if ($mppb->terminasi == 'Konflik / Komplain')
                                &#x1F5F9; Konflik / Komplain
                            @else
                                &#x25A2; Konflik / Komplain
                            @endif
                            <br>
                            <b>Kepulangan</b><br>
                            @if ($mppb->kepulangan == 'Pasien Pulang Perbaikan')
                                &#x1F5F9; Pasien Pulang Perbaikan
                            @else
                                &#x25A2; Pasien Pulang Perbaikan
                            @endif
                            @if ($mppb->kepulangan == 'Rujuk')
                                &#x1F5F9; Rujuk
                            @else
                                &#x25A2; Rujuk
                            @endif
                            @if ($mppb->kepulangan == 'Meninggal')
                                &#x1F5F9; Meninggal
                            @else
                                &#x25A2; Meninggal
                            @endif
                            @if ($mppb->kepulangan == 'Lain-lain')
                                &#x1F5F9; Lain-lain
                            @else
                                &#x25A2; Lain-lain
                            @endif
                        </div>
                        <div class="col-md-8" style="font-size: 12px">
                        </div>
                        <div class="col-md-4" style="font-size: 12px">
                            <center>
                                Waled, ..... ..............

                                <br><br><br>
                                <b><u>{{ $mppb->pic }}</u></b>
                            </center>
                        </div>
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
