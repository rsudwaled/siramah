@php
    use Carbon\Carbon;
@endphp
{{-- <div class="col-lg-12">
    <div class="row">
        <div class="col-lg-5">
            <img src="">
        </div>
        <div class="col-lg-7">
            <h5 style=" padding-left:50px;">SURAT ELEGIBILITAS PESERTA RSUD WALED</h5>
        </div>
    </div>
</div> --}}
<div class="col-lg-12">
    <h5 style=" padding-left:50px;">SURAT ELEGIBILITAS PESERTA RSUD WALED</h5>
</div>
<table style="font-size: 10px; ">
    <tr>
        <td style="padding-left:50px; ">
            <table cellspacing="0" cellpadding="5" style="margin-top: 5px;">
                <tr>
                    <td>No. SEP</td>
                    <td>:</td>
                    <td>{{ $seppasien->respon_nosep }}</td>
                </tr>
                <tr>
                    <td>Tgl. SEP</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($seppasien->tglSep)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>No. Kartu</td>
                    <td>:</td>
                    <td>{{ $seppasien->noKartu }}</td>
                </tr>
                <tr>
                    <td>Nama Peserta</td>
                    <td>:</td>
                    <td>{{ $pasien->nama_px }}</td>
                </tr>
                <tr>
                    <td>Tgl. Lahir</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('d-m-Y') }} Kelamin :
                        {{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td>{{ $seppasien->noTelp }}</td>
                </tr>
                <tr>
                    <td>Sub/Spesialis</td>
                    <td>:</td>
                    <td>INSTALASI GAWAT DARURAT</td>
                </tr>
                <tr>
                    <td>Dokter</td>
                    <td>:</td>
                    <td>Doddy</td>
                </tr>
                <tr>
                    <td>Faskes Perujuk</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Diagnosa Awal</td>
                    <td>:</td>
                    <td>{{ $seppasien->diagAwal }}</td>
                </tr>
            </table>
        </td>
        <td style="padding-left:200px; ">
            <table cellspacing="0" cellpadding="5" style="width:100%;">
                <tr>
                    <td>Peserta</td>
                    <td>:</td>
                    <td>{{ $seppasien->respon_nosep }}</td>
                </tr>
                <tr>
                    <td>Jns. Rawat</td>
                    <td>:</td>
                    <td>{{ $seppasien->tglSEP }}</td>
                </tr>
                <tr>
                    <td>Jns. Kunjungan</td>
                    <td>:</td>
                    <td>{{ $seppasien->noKartu }}</td>
                </tr>
                <tr>
                    <td>Poli Perujuk</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Kls. Rawat</td>
                    <td>:</td>
                    <td>Kelas -</td>
                </tr>
                <tr>
                    <td>Penjamin</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<style>
    @page {
        margin: 0px;
    }

    body {
        margin: 3px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
    }
</style>
