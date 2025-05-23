@extends('print.pdf_layout')
@section('title', 'Print SEP BPJS')

@section('content')
    <table class="table table-sm" style="font-size: 12px;border-bottom: 2px solid black !important">
        <tr>
            <td width="10%" class="text-center" style="vertical-align: bottom;">
                <img src="{{ public_path('logo_sep_bpjs.png') }}" style="height: 28px">
                {{-- <img src="{{ public_path('adminlte/dist/img/rswaled.png') }}" style="height: 25px"> --}}
            </td>
            <td width="30%" style="vertical-align: bottom;">
                <b>SURAT ELEGIBILITAS PESERTA</b><br>
                <b>RSUD WALED KABUPATEN CIREBON</b><br>
            </td>
            <td width="50%" style="vertical-align: bottom;">
                <b>E-SEP NO. {{ $sep->noSep }}</b><br>
            </td>
            <td width="10%" class="text-center" style="vertical-align: bottom;">
                <img src="{{ public_path('vendor/adminlte/dist/img/rswaled.png') }}" style="height: 30px">
            </td>
        </tr>
    </table>
    <table class="table table-sm" style="font-size: 12px">
        <tr>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>No SEP</td>
                        <td>:</td>
                        <td><b>{{ $sep->noSep }}</b></td>
                    </tr>
                    <tr>
                        <td>Tgl SEP</td>
                        <td>:</td>
                        <td><b>{{ $sep->tglSep }}</b></td>
                    </tr>
                    <tr>
                        <td>No Kartu</td>
                        <td>:</td>
                        <td><b>{{ $sep->peserta->noKartu }} (MR. {{ $sep->peserta->noMr }})</b></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><b>{{ $sep->peserta->nama }} ({{ $sep->peserta->kelamin }})</b></td>
                    </tr>
                    <tr>
                        <td>Tgl Lahir</td>
                        <td>:</td>
                        <td><b> {{ Carbon\Carbon::parse($sep->peserta->tglLahir)->translatedFormat('d F Y') }}</b>
                    </tr>
                    <tr>
                        <td>No Telp</td>
                        <td>:</td>
                        <td><b>{{ $peserta->mr->noTelepon }}</b></td>
                    </tr>
                    <tr>
                        <td>Sub/Spesialis</td>
                        <td>:</td>
                        <td><b>{{ $sep->poli }}</b></td>
                    </tr>
                    <tr>
                        <td>Dokter</td>
                        <td>:</td>
                        <td><b>{{ $sep->dpjp->nmDPJP }}</b></td>
                    </tr>
                    <tr>
                        <td>Faskes Perujuk</td>
                        <td>:</td>
                        <td><b>{{ $peserta->provUmum->nmProvider }}</b></td>
                    </tr>
                    <tr>
                        <td>Diagnosa Awal</td>
                        <td>:</td>
                        <td><b>{{ $sep->diagnosa }}</b></td>
                    </tr>
                    <tr>
                        <td>Catatan</td>
                        <td>:</td>
                        <td><b>{{ $sep->catatan }}</b></td>
                    </tr>

                </table>
            </td>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>Jenis Peserta</td>
                        <td>:</td>
                        <td><b>{{ $sep->peserta->jnsPeserta }}</b></td>
                    </tr>
                    <tr>
                        <td>Jns Pelayanan</td>
                        <td>:</td>
                        <td><b>{{ $sep->jnsPelayanan }}</b></td>
                    </tr>
                    <tr>
                        <td>Jns Kunjungan</td>
                        <td>:</td>
                        <td>
                            <b>
                                - {{ $sep->tujuanKunj->nama }} <br>
                                - {{ $sep->flagProcedure->nama }} <br>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td>Poli Perujuk</td>
                        <td>:</td>
                        <td><b>-</b></td>
                    </tr>
                    <tr>
                        <td>Kelas Hak</td>
                        <td>:</td>
                        <td><b>
                                {{ $sep->peserta->hakKelas }}
                            </b></td>
                    </tr>
                    <tr>
                        <td>Kelas Rawat</td>
                        <td>:</td>
                        <td><b>{{ $sep->kelasRawat }}</b></td>
                    </tr>
                    <tr>
                        <td>Penjamin</td>
                        <td>:</td>
                        <td><b>{{ $sep->penjamin }}</b></td>
                    </tr>
                    <tr>
                        <td>No Rujukan</td>
                        <td>:</td>
                        <td><b>{{ $sep->noRujukan }}</b></td>
                    </tr>
                    <tr>
                        <td>No Surat Kontrol</td>
                        <td>:</td>
                        <td><b>{{ $sep->kontrol->noSurat }}</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="50%" style="font-size: 6px">
                *Saya menyetujui BPJS Kesehatan untuk :
                <ol style="margin: 0px; padding-left: 10px; ">
                    <li style="margin: 0px;">
                        <i>Membuka dan atau menggunakan informasi medis pasien untuk keperluan administrasi, pembayaran
                            asuransi atau jaminan pembiayaan kesehatan</i>
                    </li>
                    <li style="margin: 0px;">
                        <i>Memberikan akses informasi medis atau riwayat pelayanan kepada dokter/tenaga medis untuk
                            kepentingan pemeliharaan kesehatan, pengobatan, penyembuhan, dan perawtan pasien</i>
                    </li>
                </ol>
                *Saya mengetahui dan memahami :
                <ol style="margin: 0px; padding-left: 10px; ">
                    <li style="margin: 0px;">
                        <i>Rumah Sakit dapat melakukan koordinasi dengan PT Jasa Raharja / PT Taspen / PT ASABRI / BPJS
                            Ketenagakerjaan atau penjamin lainnya, jika peserta merupakan pasien yang mengalami kecelakaan
                            lalulintas dan atau kecelakaan kerja</i>
                    </li>
                    <li style="margin: 0px;">
                        <i>SEP bukan sebagai bukti penjaminan peserta</i>
                    </li>
                </ol>
                **Dengan tampilnya luaran SEP Elektronik ini merupakan hasil validasi terhadap elegibilitas Pasien secara
                elektronik (validasi fingerprint atau biometrik / sistem validasi lain) dan seharusnya pasien dapat
                mengakses pelayanan kesehatan rujukan sesuai ketentuan yang berlaku.
                Kebenaran dan keaslian atas informasi data pasien menjadi tanggungjawab penuh FKRTL <br>
                Waktu Cetak : {{ now()->timezone('Asia/Jakarta')->format('d F Y H:i:s') }}

            </td>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td style="padding-left: 10px">
                            <b> Pasien/<br>
                                Keluarga Pasien
                            </b>
                            <br>
                            <img src="{{ $qrpasien }}" width="50px">
                        </td>
                        <td style="padding-left: 30px">
                            <b> Petugas<br>
                            </b>
                            <br>
                            <img src="{{ $qrpetugas }}" width="50px">
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
    <style>
        @page {
            size: 240mm 140mm;
            margin-left: 20mm;
            margin-right: 20mm;
                /* Misalnya ukuran A4 */
        }
    </style>
@endsection
