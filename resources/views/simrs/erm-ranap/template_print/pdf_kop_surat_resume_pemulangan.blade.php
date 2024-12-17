<div class="col-12" style="font-size: 11px; text-align:right"><strong>RM.15.01-RI/Rev.03/24</strong></div>
<table class="table table-sm table-bordered" style="font-size: 11px">
    <tr>
        <td width="10%">
            <img class="" src="{{ public_path('vendor/adminlte/dist/img/rswaled.png') }}" style="height: 50px">
        </td>
        <td width="50%">
            <b>PEMERINTAHAN KABUPATEN CIREBON</b><br>
            <b>RUMAH SAKIT UMUM DAERAH WALED</b><br>
            Jl. Prabu Kian Santang No. 4 Kab. Cirebon Jawa Barat 45151
            www.rsudwaled.id - 0823 1169 6919 - (0231) 8850943
        </td>
        <td width="40%">
            <table class="table-borderless">
                <tr>
                    <td>No RM</td>
                    <td>:</td>
                    <td><b>{{ $kunjungan->pasien->no_rm }}</b></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><b>{{ $kunjungan->pasien->nama_px }}</b></td>
                </tr>
                <tr>
                    <td>Tgl Lahir</td>
                    <td>:</td>
                    <td>
                        <b>{{ \Carbon\Carbon::parse($kunjungan->pasien->tgl_lahir)->format('d, F Y') }}
                            ({{ \Carbon\Carbon::parse($kunjungan->pasien->tgl_lahir)->diffInYears($kunjungan->tgl_masuk) }}
                            tahun)</b>
                    </td>
                </tr>
                <tr>
                    <td>Kelamin</td>
                    <td>:</td>
                    <td>
                        <b>{{ $kunjungan->pasien->jenis_kelamin }}</b>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
