@php
    use Carbon\Carbon;
@endphp
<div class="scaled-content">
    <table style="font-size: 12px; margin-top:50px; width:100%;">
        <tr>
            <td colspan="2" style="padding-left:50px;">
                <table>
                    <td><img src="{{ asset('logo_sep_bpjs.png') }}" style="height:40px; padding-righ:5px;"></td>
                    <td><span style="font-size: 18px; padding-left:10px; padding-bottom:0px; ">SURAT ELEGIBILITAS PESERTA
                            <br>&nbsp;&nbsp;RSUD WALED</span></td>
                    <td style="text-align: right;"></td>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding-left:50px; width:60%;">
                <table cellspacing="0" cellpadding="5" style="width:100%">
                    <tr>
                        <td>No. SEP</td>
                        <td>:</td>
                        <td>{{ $data->noSep }}</td>
                    </tr>
                    <tr>
                        <td>Tgl. SEP</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($data->tglSep)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>No. Kartu</td>
                        <td>:</td>
                        <td>{{ $data->peserta->noKartu }} (MR. {{ $data->peserta->noMr }})</td>
                    </tr>
                    <tr>
                        <td>Nama Peserta</td>
                        <td>:</td>
                        <td>{{ $data->peserta->nama }}</td>
                    </tr>
                    <tr>
                        <td>Tgl. Lahir</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($data->peserta->tglLahir)->format('d-m-Y') }} &nbsp;&nbsp;Kelamin :
                            {{ $data->peserta->kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Sub/Spesialis</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Dokter</td>
                        <td>:</td>
                        <td>{{ $data->kontrol->nmDokter }}</td>
                    </tr>
                    <tr>
                        <td>Faskes Perujuk</td>
                        <td>:</td>
                        {{-- <td>RSUD WALED</td> --}}
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Diagnosa Awal</td>
                        <td>:</td>
                        <td>{{ $data->diagnosa }}</td>
                    </tr>
                </table>
            </td>
            <td style="width:40%;">
                <table cellspacing="0" cellpadding="5" style="width:60%">
                    <tr>
                        <td>Peserta</td>
                        <td>:</td>
                        <td>{{ $data->peserta->jnsPeserta }}</td>
                    </tr>
                    <tr>
                        <td>Jns. Rawat</td>
                        <td>:</td>
                        <td>{{ $data->jnsPelayanan }}</td>
                    </tr>
                    <tr>
                        <td>Jns. Kunjungan</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Poli Perujuk</td>
                        <td>:</td>
                        <td>{{ $data->seppoli ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Kls. Hak</td>
                        <td>:</td>
                        <td>{{ $data->peserta->hakKelas }}</td>
                    </tr>
                    <tr>
                        <td>Kls. Rawat</td>
                        <td>:</td>
                        <td>Kelas {{ $data->kelasRawat }}</td>
                    </tr>
                    <tr>
                        <td>Penjamin</td>
                        <td>:</td>
                        <td>{{ $data->penjamin??'-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding-left:50px; width:60%;">
                <table style="font-size: 7px; ">
                    <tr>
                        <td colspan="2">*Saya menyetujui BPJS Kesehatan untuk :</td>
                    </tr>
                    <tr>
                        <td style="width:4px;">a. </td>
                        <td>membuka dan atau menggunakan informasi medis Pasien untuk keperluan administrasi, pembayaran
                            asuransi atau jaminan pembiayaan kesehatan</td>
                    </tr>
                    <tr>
                        <td>b. </td>
                        <td>memberikan akses informasi medis atau riwayat pelayanan kepada dokter/tenaga medis pada RSUD
                            WALED untuk kepentingan pemeliharaan kesehatan, pengobatan, penyembuhan, dan perawatan
                            pasien.</td>
                    </tr>
                    <tr>
                        <td colspan="2">*Saya mengetahui dan memahami :</td>
                    </tr>
                    <tr>
                        <td>a. </td>
                        <td>Rumah Sakit dapat melakukan koordinasi dengan PT Jasa Raharja / PT Taspen / PT ASABRI / BPJS
                            Ketenagakerjaan atau Penjamin lainnya, jika Peserta merupakan pasien yang mengalami
                            kecelakaan lalulintas dan / atau kecelakaan kerja.</td>
                    </tr>
                    <tr>
                        <td>b. </td>
                        <td>SEP bukan sebagai bukti penjamin peserta.</td>
                    </tr>
                </table>
            </td>
            <td style="width:40%;">
                <table style="font-size: 12px; width:100%;">
                    <tr>
                        <td colspan="2" style="text-align: center; ">Persetujuan <br>Pasien/Keluarga Pasien</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;font-size: 8px;">
                            {{ $qrCode }}<br>
                            {{ $data->peserta->nama }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<style>
    @page {
        margin: 0px;
    }

    body {
        margin: 3px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
    }

    .scaled-content {
        transform: scale(0.85);
        transform-origin: 0 0;
        /* Ensure scaling starts from the top-left */
        width: 117.65%;
        /* Adjust width to compensate for scaling */
    }
</style>
