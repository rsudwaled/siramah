<header class="page-header">
    <div class="col-12" style="font-size: 11px; text-align:right"><strong>RM.15.01-RI/Rev.03/24</strong></div>
    <table class="table table-sm table-bordered" style="font-size: 11px">
        <tr style="margin: 0px; padding:0px;">
            <td width="10%" style="border-right: 1px solid black; margin:0px; padding:0px; text-align:center">
                <img class="" src="{{ public_path('vendor/adminlte/dist/img/rswaled.png') }}" style="height: 50px">
            </td>
            <td width="50%" style="border-right: 1px solid black; margin:0px; padding:4px;">
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
</header>
<div class="content">
    <table class="table table-bordered" style="width: 100%; font-size:11px;">
        <tbody>
            <tr style="background-color: #ffc107; margin:0; border-bottom: 1px solid black;">
                <td colspan="3" style="margin: 0; padding:5px; text-align:center;">
                    <b>RINGKASAN PASIEN PULANG</b><br>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center; margin:2px; padding:2px;">
                    <b>BELUM DI ISI!</b>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<footer class="page-footer">
</footer>
