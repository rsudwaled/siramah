@extends('simrs.ranap.pdf_print')
@section('title', 'Asesmen Awal Rawat Inap')

@section('content')
    <table class="table table-sm" style="font-size: 11px;border-bottom: 2px solid black !important">
        <tr>
            <td width="10%" class="text-center">
                <img class="" src="{{ public_path('vendor/adminlte/dist/img/rswaled.png') }}" style="height: 40px">
            </td>
            <td width="80%" class="text-center">
                <b>RUMAH SAKIT UMUM DAERAH WALED KABUPATEN CIREBON</b><br>
                Jalan Raden Walangsungsang Kecamatan Waled Kabupaten Cirebon 45188<br>
                www.rsudwaled.id - brsud.waled@gmail.com - Whatasapp 0895 4000 60700 - Call Center (0231)661126
            </td>
            <td width="10%" class="text-center">
                <img class="" src="{{ public_path('logo_bpjs.png') }}" style="height: 40px">
            </td>
        </tr>
    </table>
    <table class="table table-sm" style="font-size: 11px">
        <tr>
            <td width="100%" colspan="2" class="text-center">
                <b class="text-md">SURAT KONTROL RAWAT JALAN</b> <br>
                <b class="text-md">No. {{ $suratkontrol->noSuratKontrol }}</b>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>No RM</td>
                        <td>:</td>
                        <td><b>{{ $pasien->no_rm }}</b></td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><b>{{ $peserta->nama }}</b></td>
                    </tr>
                    <tr>
                        <td>Nomor BPJS</td>
                        <td>:</td>
                        <td><b>{{ $peserta->noKartu }}</b></td>
                    </tr>
                    <tr>
                        <td>No HP / Telp</td>
                        <td>:</td>
                        <td><b>{{ $pasien->no_hp }}</b></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td><b>{{ $peserta->kelamin }}</b></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td><b>{{ $peserta->tglLahir }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3"> -</td>
                    </tr>
                    <tr>
                        <td>Tanggal Kontrol</td>
                        <td>:</td>
                        <td><b>{{ $suratkontrol->tglRencanaKontrol }}</b></td>
                    </tr>
                    <tr>
                        <td>Tanggal Terbit</td>
                        <td>:</td>
                        <td><b>{{ $suratkontrol->tglTerbit }}</b></td>
                    </tr>
                    <tr>
                        <td>Jenis Kontrol</td>
                        <td>:</td>
                        <td><b>{{ $suratkontrol->namaJnsKontrol }}</b></td>
                    </tr>
                    <tr>
                        <td>Poliklinik Tujuan</td>
                        <td>:</td>
                        <td><b>{{ $suratkontrol->namaPoliTujuan }}</b></td>
                    </tr>
                    <tr>
                        <td>Dokter</td>
                        <td>:</td>
                        <td><b>{{ $dokter->nama_paramedis }}</b></td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>No SEP</td>
                        <td>:</td>
                        <td><b>{{ $sep->noSep }}</b></td>
                    </tr>
                    <tr>
                        <td>Tanggal SEP</td>
                        <td>:</td>
                        <td><b>{{ $sep->tglSep }}</b></td>
                    </tr>
                    <tr>
                        <td>Jenis Pelayanan</td>
                        <td>:</td>
                        <td><b>{{ $sep->jnsPelayanan }}</b></td>
                    </tr>
                    <tr>
                        <td>Poliklinik</td>
                        <td>:</td>
                        <td><b>{{ $sep->poli }}</b></td>
                    </tr>
                    <tr>
                        <td>Diagnosa</td>
                        <td>:</td>
                        <td><b>{{ $sep->diagnosa }}</b></td>
                    </tr>
                    <tr>
                        <td>Prov. Perujuk</td>
                        <td>:</td>
                        <td><b>{{ $sep->provPerujuk->nmProviderPerujuk }}</b></td>
                    </tr>
                    <tr>
                        <td>Asal Rujukan</td>
                        <td>:</td>
                        <td><b>{{ $sep->provPerujuk->asalRujukan }}</b></td>
                    </tr>
                    <tr>
                        <td>No Rujukan</td>
                        <td>:</td>
                        <td><b>{{ $sep->provPerujuk->noRujukan }}</b></td>
                    </tr>
                    <tr>
                        <td>Tanggal Rujukan</td>
                        <td>:</td>
                        <td><b>{{ $sep->provPerujuk->tglRujukan }}</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                Dengan ini pasien diatas belum dapat dikembalikan ke Fasilitas Kesehatan Perujuk. Rencana tindak
                lanjut akan dilanjutkan pada kunjungan selanjutnya.
                Surat Keterangan ini hanya dapat digunakan 1 (satu) kali pada kunjungan dengan diagnosa diatas.
            </td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td width="50%">
                <b> Waled, {{ Carbon\Carbon::now()->translatedFormat('d F Y') }} <br>
                    DPJP,</b>

                <br><br><br>
                <b><u>{{ $dokter->nama_paramedis }}</u></b>
            </td>
        </tr>
    </table>
@endsection
