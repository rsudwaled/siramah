@if ($kunjungan->asesmen_ranap)
    <table class="table table-sm table-bordered" style="font-size: 11px">
        <tr style="background-color: #ffc107">
            <td width="100%" colspan="2" class="text-center">
                <b>ASEMEN AWAL RAWAT INAP</b><br>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                Tiba di Ruang Perawatan <b>{{ $kunjungan->asesmen_ranap->nama_unit }}</b> Tanggal
                <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->tgl_masuk_ruangan)->format('d F Y') }}</b> Jam
                <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->tgl_masuk_ruangan)->format('H:i:s') }}</b>.
                Tanggal Pengkajian
                <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->tgl_asesmen_awal)->format('d F Y') }}</b> Jam
                <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->tgl_asesmen_awal)->format('H:i:s') }}</b>. <br>
                Sumber Data <b>{{ $kunjungan->asesmen_ranap->sumber_data }}</b>, Nama Keluarga
                <b>{{ $kunjungan->asesmen_ranap->nama_keluarga }}</b> Hubungan
                <b>{{ $kunjungan->asesmen_ranap->hubungan_keluarga }}</b>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                <b><u>ANAMNESIS</u></b><br>
                <b>Keluhan Utama :</b><br>
                <pre>{{ $kunjungan->asesmen_ranap->keluhan_utama }}</pre> <br>
                <b>Riwayat Penyakit Utama :</b><br>
                <pre>{{ $kunjungan->asesmen_ranap->riwayat_penyakit_utama }}</pre> <br>
                <b>Riwayat Penyakit Dahulu :</b><br>
                <pre>{{ $kunjungan->asesmen_ranap->riwayat_penyakit_dahulu }}</pre> <br>
                <b>Riwayat Penyakit Keluarga :</b><br>
                <pre>{{ $kunjungan->asesmen_ranap->riwayat_penyakit_keluarga }}</pre>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                <b><u>TANDA-TANDA VITAL</u></b><br>
                <table class="table-borderless">
                    <tr>
                        <td>Keadaan Umum</td>
                        <td>:</td>
                        <td><b>{{ $pasien->no_rm }}</b></td>
                    </tr>
                    <tr>
                        <td>Kesadaran</td>
                        <td>:</td>
                        <td><b>{{ $kunjungan->asesmen_ranap->kesadaran }}</b></td>
                    </tr>
                    <tr>
                        <td>Tekanan Darah</td>
                        <td>:</td>
                        <td>
                            <b>{{ $kunjungan->asesmen_ranap->diastole }} /
                                {{ $kunjungan->asesmen_ranap->sistole }}</b> mmHg
                        </td>
                    </tr>
                    <tr>
                        <td>Suhu</td>
                        <td>:</td>
                        <td>
                            <b>{{ $kunjungan->asesmen_ranap->suhu }}</b> Celcius
                        </td>
                    </tr>
                    <tr>
                        <td>Pernapasan</td>
                        <td>:</td>
                        <td>
                            <b>{{ $kunjungan->asesmen_ranap->pernapasan }}</b> x/menit
                        </td>
                    </tr>
                    <tr>
                        <td>Denyut Nadi</td>
                        <td>:</td>
                        <td>
                            <b>{{ $kunjungan->asesmen_ranap->denyut_nadi }}</b> x/menit
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                <b><u>PEMERIKSAAN FISIK</u></b><br>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                <b><u>PEMERIKSAAN PENUNJANG</u></b><br>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                <b><u>DIAGNOSA KERJA</u></b><br>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                <b><u>DIAGNOSA BANDING</u></b><br>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                <b><u>PROGNOSIS</u></b><br>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                <b><u>RENCANA ASUHAN</u></b><br>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                <b><u>RENCANA ASUHAN TERPADU</u></b><br>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                <b><u>RENCANA KEPULANGAN PASIEN</u></b><br>
            </td>
        </tr>
        <tr>
            <td width="50%" class="text-center">
                <b>Tanggal & Jam Selesai Asesmen</b>
            </td>
            <td width="50%" class="text-center">
                <b>Nama & Tanda Tangan DPJP</b>
            </td>
        </tr>
        <tr>
            <td width="50%" class="text-center">
                <b>Tanggal</b> <br>
                <b>Pukul</b> <br>
            </td>
            <td width="50%" class="text-center">
                <br>
                <br>
                <br>
                <br>
                <br>
            </td>
        </tr>
    </table>
@else
    <table class="table table-sm table-bordered" style="font-size: 11px">
        <table class="table table-sm table-bordered" style="font-size: 11px">
            <tr style="background-color: #ffc107">
                <td width="100%" class="text-center">
                    <b>ASEMEN AWAL RAWAT INAP</b><br>
                </td>
            </tr>
        </table>
        <tr>
            <td width="100%" class="text-center">
                <b>Belum Diisi</b><br>
            </td>
        </tr>
    </table>
@endif
