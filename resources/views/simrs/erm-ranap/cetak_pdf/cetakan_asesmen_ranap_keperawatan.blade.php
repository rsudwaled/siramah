@extends('simrs.erm-ranap.template_print.pdf_print')
@section('title', 'Asesmen Awal Rawat Inap')

@section('content')
    @include('simrs.erm-ranap.template_print.pdf_kop_surat')
    @if ($kunjungan->asesmen_ranap_keperawatan)
        <table class="table table-sm table-bordered" style="font-size: 11px">
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-center">
                    <b>ASEMEN AWAL KEPERAWATAN RAWAT INAP</b><br>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <table class="table-borderless" width="100%" style="margin: 0; padding:0;">
                        <tr>
                            <td>Tiba di Ruangan Tanggal</td>
                            <td>:</td>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap_keperawatan->tgl_tiba_ruangan)->format('d F Y') }}</strong>
                                Jam: <strong>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap_keperawatan->waktu_tiba)->format('H:i:s') }}
                                    WIB</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Ruang Perawatan</td>
                            <td>:</td>
                            <td><strong>{{ $kunjungan->asesmen_ranap_keperawatan->nama_unit }}</strong></td>
                        </tr>
                        <tr>
                            <td>Nama Keluarga</td>
                            <td>:</td>
                            <td><strong>{{ $kunjungan->asesmen_ranap_keperawatan->nama_keluarga ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Cara Masuk</td>
                            <td>:</td>
                            <td><strong>{{ $kunjungan->asesmen_ranap_keperawatan->cara_masuk ?? '-' }}</strong></td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table class="table-borderless" width="100%" style="margin: 0; padding:0;">
                        <tr>
                            <td>Tanggal Pengkajian</td>
                            <td>:</td>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap_keperawatan->tgl_pengkajian)->format('d F Y') }}</strong>
                                Jam: <strong>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap_keperawatan->waktu_pengkajian)->format('H:i:s') }}
                                    WIB</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Sumber Data</td>
                            <td>:</td>
                            <td><strong>{{ $kunjungan->asesmen_ranap_keperawatan->sumber_data }}</strong></td>
                        </tr>
                        <tr>
                            <td>Hubungan Keluarga</td>
                            <td>:</td>
                            <td><strong>{{ $kunjungan->asesmen_ranap_keperawatan->hubungan_keluarga ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Asal Masuk</td>
                            <td>:</td>
                            <td><strong>{{ $kunjungan->asesmen_ranap_keperawatan->asal_masuk ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-left">
                    <b>A. KEADAAN UMUM</b><br>
                </td>
            </tr>
            <tr>
                <td width="50%">Kesadaran : {{ $kunjungan->asesmen_ranap_keperawatan->kesadaran }}</td>
                <td width="50%">
                    <table class="table-borderless" width="100%">
                        <tr>
                            <td width="50%">Tekanan Darah : {{ $kunjungan->asesmen_ranap_keperawatan->tekanan_darah }}
                                mmHg</td>
                            <td width="50%">Respirasi : {{ $kunjungan->asesmen_ranap_keperawatan->respirasi }} x/menit
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">Nadi : {{ $kunjungan->asesmen_ranap_keperawatan->denyut_nadi }} x/menit</td>
                            <td width="50%">Suhu : {{ $kunjungan->asesmen_ranap_keperawatan->suhu }} °C</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-left">
                    <b>SKRINING NYERI</b><br>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <img src="{{ public_path('nyeri_nrs.png') }}" width="100%" alt="">
                    <table class="table-borderless">
                        <tr>
                            <td><strong>Skala Nyeri</strong></td>
                            <td>:</td>
                            <td><strong>{{ $skriningNyeri['skala_nyeri'] }}</strong></td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <b>Asesmen Nyeri Lanjutan</b>
                    <table class="table-borderless">
                        <tr>
                            <td>Provocation</td>
                            <td>:</td>
                            <td><strong>{{ is_array($skriningNyeri['provocation'] ?? null) ? implode(', ', $skriningNyeri['provocation']) : $skriningNyeri['provocation'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Quality</td>
                            <td>:</td>
                            <td><strong>{{ is_array($skriningNyeri['quality'] ?? null) ? implode(', ', $skriningNyeri['quality']) : $skriningNyeri['quality'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Region</td>
                            <td>:</td>
                            <td><strong>{{ is_array($skriningNyeri['region'] ?? null) ? implode(', ', $skriningNyeri['region']) : $skriningNyeri['region'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Severity</td>
                            <td>:</td>
                            <td><strong>{{ is_array($skriningNyeri['severity'] ?? null) ? implode(', ', $skriningNyeri['severity']) : $skriningNyeri['severity'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td>:</td>
                            <td><strong>{{ is_array($skriningNyeri['time'] ?? null) ? implode(', ', $skriningNyeri['time']) : $skriningNyeri['time'] ?? '-' }}</strong>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-left">
                    <b>PEMERIKSAAN FISIK</b><br>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>SISTEM RESPIRASI & OKSIGENASI</b><br>
                    <table class="table-borderless" width="100%">
                        <tr>
                            <td>a.</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">Obstruksi Saluran Napas Atas
                            </td>
                            <td style="text-align: center; vertical-align: middle;">:</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">
                                <strong>{{ is_array($sistemRespirasiOksigenasi['obstruksi'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['obstruksi']) : $sistemRespirasiOksigenasi['obstruksi'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">Sesak Napas (Dyspnea)</td>
                            <td style="text-align: center; vertical-align: middle;">:</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">
                                <strong>{{ is_array($sistemRespirasiOksigenasi['dyspnea'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['dyspnea']) : $sistemRespirasiOksigenasi['dyspnea'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>c.</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">Pemakaian alata bantu napas:
                                Binasal Canule/Simple Mask/Rebreathing
                                Mask/Non Rebreathing Mask/Endotrachel Tube/Trachea Canule/Ventilator</td>
                            <td style="text-align: center; vertical-align: middle;">:</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;"> Oksigen
                                <strong>{{ is_array($sistemRespirasiOksigenasi['alat_bantu_napas'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['alat_bantu_napas']) : $sistemRespirasiOksigenasi['alat_bantu_napas'] ?? '-' }}
                                    lpm (jika menggunakan ventilator, lanjutkan ke chart ventilator)</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>d.</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">Batuk :
                                <strong>{{ is_array($sistemRespirasiOksigenasi['batuk'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['batuk']) : $sistemRespirasiOksigenasi['batuk'] ?? '-' }}</strong>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">-</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">Sputum:
                                <strong>{{ is_array($sistemRespirasiOksigenasi['sputum'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['sputum']) : $sistemRespirasiOksigenasi['sputum'] ?? '-' }}</strong>
                                ( WARNA :
                                {{ is_array($sistemRespirasiOksigenasi['warna_sputum'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['warna_sputum']) : $sistemRespirasiOksigenasi['warna_sputum'] ?? '-' }})
                            </td>
                        </tr>
                        <tr>
                            <td>e.</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">Bunyi Napas</td>
                            <td style="text-align: center; vertical-align: middle;">:</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">
                                <strong>{{ is_array($sistemRespirasiOksigenasi['bunyi_napas'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['bunyi_napas']) : $sistemRespirasiOksigenasi['bunyi_napas'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>f.</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">Thorax :
                                <strong>{{ is_array($sistemRespirasiOksigenasi['thorax'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['thorax']) : $sistemRespirasiOksigenasi['thorax'] ?? '-' }}</strong>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">-</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">
                                Krepitasi:
                                <strong>{{ is_array($sistemRespirasiOksigenasi['krepitasi'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['krepitasi']) : $sistemRespirasiOksigenasi['krepitasi'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>g.</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">CTT</td>
                            <td style="text-align: center; vertical-align: middle;">:</td>
                            <td style="width: 49%; text-align: left; vertical-align: middle;">
                                <strong>{{ is_array($sistemRespirasiOksigenasi['ctt'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['ctt']) : $sistemRespirasiOksigenasi['ctt'] ?? '-' }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>SISTEM KARDIOVASKULER</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>a.</td>
                            <td>Nadi</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemKardioVaskuler['nadi'] ?? null) ? implode(', ', $sistemKardioVaskuler['nadi']) : $sistemKardioVaskuler['nadi'] ?? '-' }}
                                    x/menit (Reguler/Irreguler)</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>Konjungtiva</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemKardioVaskuler['konjungtiva'] ?? null) ? implode(', ', $sistemKardioVaskuler['konjungtiva']) : $sistemKardioVaskuler['konjungtiva'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>c.</td>
                            <td>Riwayat Pemasangan Alat</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemKardioVaskuler['pasang_alat'] ?? null) ? implode(', ', $sistemKardioVaskuler['pasang_alat']) : $sistemKardioVaskuler['pasang_alat'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>d.</td>
                            <td>Kulit</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemKardioVaskuler['kulit'] ?? null) ? implode(', ', $sistemKardioVaskuler['kulit']) : $sistemKardioVaskuler['kulit'] ?? '-' }}</strong>
                            </td>
                        </tr>

                        <tr>
                            <td>e.</td>
                            <td>Temperatur</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemKardioVaskuler['temperatur'] ?? null) ? implode(', ', $sistemKardioVaskuler['temperatur']) : $sistemKardioVaskuler['temperatur'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>f.</td>
                            <td>Bunyi Jantung</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemKardioVaskuler['bunyi_jantung'] ?? null) ? implode(', ', $sistemKardioVaskuler['bunyi_jantung']) : $sistemKardioVaskuler['bunyi_jantung'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>g.</td>
                            <td>Ekstrimitas</td>
                            <td>:</td>
                            <td><strong>CRT
                                    {{ is_array($sistemKardioVaskuler['ekstremis'] ?? null) ? implode(', ', $sistemKardioVaskuler['ekstremis']) : $sistemKardioVaskuler['ekstremis'] ?? '-' }}
                                    detik</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>h.</td>
                            <td>Terpasang Nichiban / TR Band</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemKardioVaskuler['nichiban'] ?? null) ? implode(', ', $sistemKardioVaskuler['nichiban']) : $sistemKardioVaskuler['nichiban'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>i.</td>
                            <td>Edema</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemKardioVaskuler['edema'] ?? null) ? implode(', ', $sistemKardioVaskuler['edema']) : $sistemKardioVaskuler['edema'] ?? '-' }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PEMERIKSAAN SISTEM GASTRO INTESTINAL</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>a.</td>
                            <td>Makan</td>
                            <td>:</td>
                            <td><strong>Frekuensi
                                    {{ is_array($sistemGastroIntestinal['makan_frekuensi'] ?? null) ? implode(', ', $sistemGastroIntestinal['makan_frekuensi']) : $sistemGastroIntestinal['makan_frekuensi'] ?? '-' }}x/hari</strong>
                                (Jumlah:
                                {{ is_array($sistemGastroIntestinal['makan_jumlah'] ?? null) ? implode(', ', $sistemGastroIntestinal['makan_jumlah']) : $sistemGastroIntestinal['makan_jumlah'] ?? '-' }})
                            </td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>Mual :
                                <strong>{{ is_array($sistemGastroIntestinal['mual'] ?? null) ? implode(', ', $sistemGastroIntestinal['mual']) : $sistemGastroIntestinal['mual'] ?? '-' }}</strong>
                            </td>
                            <td>-</td>
                            <td>Muntah :
                                <strong>{{ is_array($sistemGastroIntestinal['muntah'] ?? null) ? implode(', ', $sistemGastroIntestinal['muntah']) : $sistemGastroIntestinal['muntah'] ?? '-' }}</strong>
                                (Warna:
                                {{ is_array($sistemGastroIntestinal['warna_muntah'] ?? null) ? implode(', ', $sistemGastroIntestinal['warna_muntah']) : $sistemGastroIntestinal['warna_muntah'] ?? '-' }})
                            </td>
                        </tr>
                        <tr>
                            <td>c.</td>
                            <td>BAB</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemGastroIntestinal['bab'] ?? null) ? implode(', ', $sistemGastroIntestinal['bab']) : $sistemGastroIntestinal['bab'] ?? '-' }}
                                    x/hari</strong>
                                (Warna:
                                {{ is_array($sistemGastroIntestinal['warna_bab'] ?? null) ? implode(', ', $sistemGastroIntestinal['warna_bab']) : $sistemGastroIntestinal['warna_bab'] ?? '-' }}
                                | Konsistensi :
                                {{ is_array($sistemGastroIntestinal['konsistensi_bab'] ?? null) ? implode(', ', $sistemGastroIntestinal['konsistensi_bab']) : $sistemGastroIntestinal['konsistensi_bab'] ?? '-' }})
                            </td>
                        </tr>
                        <tr>
                            <td>d.</td>
                            <td>Sklera</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemGastroIntestinal['sklera'] ?? null) ? implode(', ', $sistemGastroIntestinal['sklera']) : $sistemGastroIntestinal['sklera'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>e.</td>
                            <td>Mulut & Faring</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemGastroIntestinal['mukosa'] ?? null) ? implode(', ', $sistemGastroIntestinal['mukosa']) : $sistemGastroIntestinal['mukosa'] ?? '-' }}</strong>
                                (Warna Lidah :
                                {{ is_array($sistemGastroIntestinal['warna_lidah'] ?? null) ? implode(', ', $sistemGastroIntestinal['warna_lidah']) : $sistemGastroIntestinal['warna_lidah'] ?? '-' }}
                                |
                                {{ is_array($sistemGastroIntestinal['lidah_warna'] ?? null) ? implode(', ', $sistemGastroIntestinal['lidah_warna']) : $sistemGastroIntestinal['lidah_warna'] ?? '-' }})
                            </td>
                        </tr>
                        <tr>
                            <td>f.</td>
                            <td>Reflreksi Menelan</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemGastroIntestinal['reflek_menelan'] ?? null) ? implode(', ', $sistemGastroIntestinal['reflek_menelan']) : $sistemGastroIntestinal['reflek_menelan'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>g.</td>
                            <td>Reflreksi Menguyah</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemGastroIntestinal['reflek_mengunyah'] ?? null) ? implode(', ', $sistemGastroIntestinal['reflek_mengunyah']) : $sistemGastroIntestinal['reflek_mengunyah'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>h.</td>
                            <td>Alat Bantu</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemGastroIntestinal['alat_bantu'] ?? null) ? implode(', ', $sistemGastroIntestinal['alat_bantu']) : $sistemGastroIntestinal['alat_bantu'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>i.</td>
                            <td>Abdomen</td>
                            <td>:</td>
                            <td>
                                <strong>
                                    Bising usu
                                    {{ is_array($sistemGastroIntestinal['bising_usu'] ?? null) ? implode(', ', $sistemGastroIntestinal['bising_usu']) : $sistemGastroIntestinal['bising_usu'] ?? '-' }}
                                    x/menit
                                </strong>
                                (Bentuk :
                                {{ is_array($sistemGastroIntestinal['bentuk_abdomen'] ?? null) ? implode(', ', $sistemGastroIntestinal['bentuk_abdomen']) : $sistemGastroIntestinal['bentuk_abdomen'] ?? '-' }})
                            </td>
                        </tr>
                        <tr>
                            <td>j.</td>
                            <td>Stoma</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemGastroIntestinal['stomata'] ?? null) ? implode(', ', $sistemGastroIntestinal['stomata']) : $sistemGastroIntestinal['stomata'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>k.</td>
                            <td>Drain</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemGastroIntestinal['drain'] ?? null) ? implode(', ', $sistemGastroIntestinal['drain']) : $sistemGastroIntestinal['drain'] ?? '-' }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PEMERIKSAAN SISTEM MUSKOLO SKELETAL</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>a.</td>
                            <td>Fraktur</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemMuskuloSkeletal['fraktur'] ?? null) ? implode(', ', $sistemMuskuloSkeletal['fraktur']) : $sistemMuskuloSkeletal['fraktur'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>Mobilitas</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemMuskuloSkeletal['mobilitas'] ?? null) ? implode(', ', $sistemMuskuloSkeletal['mobilitas']) : $sistemMuskuloSkeletal['mobilitas'] ?? '-' }}</strong>
                                (Alat Bantu:
                                {{ is_array($sistemMuskuloSkeletal['mobilitas_alat_bantu'] ?? null) ? implode(', ', $sistemMuskuloSkeletal['mobilitas_alat_bantu']) : $sistemMuskuloSkeletal['mobilitas_alat_bantu'] ?? '-' }})
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PEMERIKSAAN SISTEM NEUROLOGI</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>a.</td>
                            <td>Kesulitan Bicara</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemNeurologi['kesulitan_bicara'] ?? null) ? implode(', ', $sistemNeurologi['kesulitan_bicara']) : $sistemNeurologi['kesulitan_bicara'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>Kelemahan alat gerak</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemNeurologi['kelemahan_alat_gerak'] ?? null) ? implode(', ', $sistemNeurologi['kelemahan_alat_gerak']) : $sistemNeurologi['kelemahan_alat_gerak'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>c.</td>
                            <td>Terpasang EVD</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemNeurologi['evd'] ?? null) ? implode(', ', $sistemNeurologi['evd']) : $sistemNeurologi['evd'] ?? '-' }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PEMERIKSAAN SISTEM UROGENITAL</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>a.</td>
                            <td>Perubahan Pola BAK</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemUrogenital['pola_bak'] ?? null) ? implode(', ', $sistemUrogenital['pola_bak']) : $sistemUrogenital['pola_bak'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>Frekuensi BAK</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemUrogenital['frekuensi_bak'] ?? null) ? implode(', ', $sistemUrogenital['frekuensi_bak']) : $sistemUrogenital['frekuensi_bak'] ?? '-' }}
                                    x/hari</strong>
                                (Warna urina:
                                {{ is_array($sistemUrogenital['warna_urina'] ?? null) ? implode(', ', $sistemUrogenital['warna_urina']) : $sistemUrogenital['warna_urina'] ?? '-' }})
                            </td>
                        </tr>
                        <tr>
                            <td>c.</td>
                            <td>Alat Bantu</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemUrogenital['uro_alat_bantu'] ?? null) ? implode(', ', $sistemUrogenital['uro_alat_bantu']) : $sistemUrogenital['uro_alat_bantu'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>d.</td>
                            <td>Stoma</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemUrogenital['uro_stomata'] ?? null) ? implode(', ', $sistemUrogenital['uro_stomata']) : $sistemUrogenital['uro_stomata'] ?? '-' }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PEMERIKSAAN SISTEM INTEGUMEN</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>a.</td>
                            <td>Luka</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemIntegumen['integumen_luka'] ?? null) ? implode(', ', $sistemIntegumen['integumen_luka']) : $sistemIntegumen['integumen_luka'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>Benjolan</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemIntegumen['integumen_benjolan'] ?? null) ? implode(', ', $sistemIntegumen['integumen_benjolan']) : $sistemIntegumen['integumen_benjolan'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>c.</td>
                            <td>Suhu</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemIntegumen['integumen_suhu'] ?? null) ? implode(', ', $sistemIntegumen['integumen_suhu']) : $sistemIntegumen['integumen_suhu'] ?? '-' }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>HYGIENE</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>a.</td>
                            <td>Aktifitas Sehari-hari</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemHygiene['aktivitas_hygiene'] ?? null) ? implode(', ', $sistemHygiene['aktivitas_hygiene']) : $sistemHygiene['aktivitas_hygiene'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>Penampilan</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemHygiene['penampilan_hygiene'] ?? null) ? implode(', ', $sistemHygiene['penampilan_hygiene']) : $sistemHygiene['penampilan_hygiene'] ?? '-' }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PSIKOSISIAL & BUDAYA</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>a.</td>
                            <td>Ekspresi Wajah</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemPsikobudaya['ekspresi_wajah'] ?? null) ? implode(', ', $sistemPsikobudaya['ekspresi_wajah']) : $sistemPsikobudaya['ekspresi_wajah'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>Kemampuan Bicara</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemPsikobudaya['kemampuan_bicara_psiko_sosbud'] ?? null) ? implode(', ', $sistemPsikobudaya['kemampuan_bicara_psiko_sosbud']) : $sistemPsikobudaya['kemampuan_bicara_psiko_sosbud'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>c.</td>
                            <td>Koping Mekanisme</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemPsikobudaya['koping_mekanisme'] ?? null) ? implode(', ', $sistemPsikobudaya['koping_mekanisme']) : $sistemPsikobudaya['koping_mekanisme'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>d.</td>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemPsikobudaya['pekerjaan'] ?? null) ? implode(', ', $sistemPsikobudaya['pekerjaan']) : $sistemPsikobudaya['pekerjaan'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>e.</td>
                            <td>Tinggal Bersama</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemPsikobudaya['tinggal_bersama'] ?? null) ? implode(', ', $sistemPsikobudaya['tinggal_bersama']) : $sistemPsikobudaya['tinggal_bersama'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>f.</td>
                            <td>Suku</td>
                            <td>:</td>
                            <td><strong>{{ is_array($sistemPsikobudaya['suku'] ?? null) ? implode(', ', $sistemPsikobudaya['suku']) : $sistemPsikobudaya['suku'] ?? '-' }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>SPIRITUAL & NILAI-NILAI KEPERCAYAAN</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>a.</td>
                            <td>Agama</td>
                            <td>:</td>
                            <td><strong>{{ is_array($spiritualKepercayaan['agama'] ?? null) ? implode(', ', $spiritualKepercayaan['agama']) : $spiritualKepercayaan['agama'] ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>Keprihatinan</td>
                            <td>:</td>
                            <td>
                                <strong>{{ ($spiritualKepercayaan['keprihatinan']['jawaban'] ?? '') == 'Ya' ? 'Ya' : '' }}</strong>
                                |
                                {{ is_array($spiritualKepercayaan['keprihatinan']['detail']) && isset($spiritualKepercayaan['keprihatinan']['detail'][0]) ? $spiritualKepercayaan['keprihatinan']['detail'][0] : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>c.</td>
                            <td>Nilai-Nilai Kepercayaan</td>
                            <td>:</td>
                            <td><strong>{{ is_array($spiritualKepercayaan['nilai_kepercayaan'] ?? null) ? implode(', ', $spiritualKepercayaan['nilai_kepercayaan']) : $spiritualKepercayaan['nilai_kepercayaan'] ?? '-' }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-left" style="text-align: center; vertical-align: middle;">
                    <b>B. ASESMEN RESIKO</b><br>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <table class="table table-xs table-bordered">
                        <tbody>
                            <tr style="background-color: #fff4d3">
                                <td colspan="3"><strong>ASESMEN RESIKO JATUH PASIEN DEWASA <i>(Morse Falls
                                            Scale)</i></strong></td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;"><strong>Faktor Resiko</strong></td>
                                <td style="text-align: center; vertical-align: middle;"><strong>Skala</strong></td>
                                <td style="text-align: center; vertical-align: middle;"><strong>Skor Pasien</strong></td>
                            </tr>
                            <tr>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">Riwayat jatuh</td>
                                <td>Tidak</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_riwayat_jatuh_tidak }}</td>
                            </tr>
                            <tr>
                                <td>Ya</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_riwayat_jatuh_ya }}</td>
                            </tr>
                            <tr>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">Diagnosa sekunder
                                </td>
                                <td>Tidak</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_diagnosa_sekunder_tidak }}</td>
                            </tr>
                            <tr>
                                <td>Ya</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_diagnosa_sekunder_ya }}</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">Menggunakan alat
                                    bantu</td>
                                <td>Tidak ada /Bedtest/Dibantu perawat</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_alat_bantu_tidak }}</td>
                            </tr>
                            <tr>
                                <td>Kruk/Tongkat</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_alat_bantu_kruk }}</td>
                            </tr>
                            <tr>
                                <td>Kursi/Perabot</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_alat_bantu_kursi }}</td>
                            </tr>
                            <tr>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">Menggunakan
                                    infus/heprin/pengencer darah/obat risiko jatuh</td>
                                <td>Tidak</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_infus_tidak }}</td>
                            </tr>
                            <tr>
                                <td>Ya</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_infus_ya }}</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">Gaya berjalan</td>
                                <td>Normal/Bedtest/kursi roda</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_gaya_berjalan_normal }}</td>
                            </tr>
                            <tr>
                                <td>Lemah</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_gaya_berjalan_lemah }}</td>
                            </tr>
                            <tr>
                                <td>Terganggu</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_gaya_berjalan_terganggu }}</td>
                            </tr>
                            <tr>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">Status Mental</td>
                                <td>Menyadari kemampuan</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_status_mental_menyadari }}</td>
                            </tr>
                            <tr>
                                <td>Lupa akan keterbatasan/pelupa</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $faktorResiko?->skor_status_mental_lupa }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong>
                                        KESIMPULAN:
                                        @if ($faktorResiko?->total_skor >= 0 && $faktorResiko?->total_skor <= 24)
                                            Pasien tidak beresiko (0-24)
                                        @elseif($faktorResiko?->total_skor >= 25 && $faktorResiko?->total_skor <= 44)
                                            Pasien risiko rendah-sedang (25-44)
                                        @elseif($faktorResiko?->total_skor > 44)
                                            Pasien risiko tinggi (> 44)*
                                        @else
                                            -
                                        @endif
                                    </strong>
                                </td>
                                <td><strong>TOTAL SKOR: {{ $faktorResiko?->total_skor }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <table class="table table-xs table-bordered">
                        <tbody>
                            <tr style="background-color: #fff4d3">
                                <td colspan="5"><strong>ASESMEN RESIKO JATUH PASIEN GERIATRI <i>(Ontario Modified Sydney
                                            Scoring)</i></strong></td>
                            </tr>
                            <tr>
                                <td><strong>Parameter</strong></td>
                                <td><strong>Skrining</strong></td>
                                <td><strong>Ket</strong></td>
                                <td><strong>Keterangan</strong> Nilai</td>
                                <td><strong>Skor</strong></td>
                            </tr>
                            <tr>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">Riwayat jatuh</td>
                                <td>Apakah pasien datang kerumah sakit karena jatuh?</td>
                                <td style="text-align: center; vertical-align: middle;">tidak/ya</td>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">jawaban ya = 6</td>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningResiko?->skor_riwayat_jatuh }}</td>
                            </tr>
                            <tr>
                                <td>Jika tidak, apakah pasien mengalami jatuh dalam 2 bulan terakhir?</td>
                                <td style="text-align: center; vertical-align: middle;">ya/tidak</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">Status mental</td>
                                <td>apakah pasien delirium? (tidak dapat membuat keputusan, pola pikir tidak teroganisir,
                                    gangguan daya ingat)</td>
                                <td style="text-align: center; vertical-align: middle;">tidak/ya</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">jawaban ya = 14
                                </td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningResiko?->skor_status_mental }}</td>
                            </tr>
                            <tr>
                                <td>apakah pasien disorientasi? (salah menyebutkan waktu, tempat, atau orang)</td>
                                <td style="text-align: center; vertical-align: middle;">ya/tidak</td>
                            </tr>
                            <tr>
                                <td>apakah pasien mengalami agitasi? (ketakutan, gelisah dan cemas)</td>
                                <td style="text-align: center; vertical-align: middle;">ya/tidak</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">Penglihatan</td>
                                <td>apakah pasien memakai kacamata?</td>
                                <td style="text-align: center; vertical-align: middle;">tidak/ya</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">jawaban ya = 1</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningResiko?->skor_penglihatan }}</td>
                            </tr>
                            <tr>
                                <td>apakah pasien mengeluh adanya penglihatan buram?</td>
                                <td style="text-align: center; vertical-align: middle;">ya/tidak</td>
                            </tr>
                            <tr>
                                <td>apakah pasien mempunyai glukoma, katarak, atau degenerasi makula?</td>
                                <td style="text-align: center; vertical-align: middle;">ya/tidak</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">Kebiasaan berkemih</td>
                                <td>apakah terdapat perubahan perilaku berkemih? (frekuensi, urgensi, inkontinensia,
                                    nokturia)</td>
                                <td style="text-align: center; vertical-align: middle;">tidak/ya</td>
                                <td style="text-align: center; vertical-align: middle;">jawaban ya = 2</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $skriningResiko?->skor_kebiasaan_berkemih }}</td>
                            </tr>
                            <tr>
                                <td rowspan="4" style="text-align: center; vertical-align: middle;">Transfer (dari
                                    tempat tidur ke kursi dan kembali ke tempat tidur)</td>
                                <td>mandiri (boleh menggunakan alt bantu jalan)</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td rowspan="8" style="text-align: center; vertical-align: middle;">jika total nilai
                                    transfer dan mobilitas 0-3 maka skor = 0 <br> jika nilai 4-6 maka nilai skor = 7</td>
                                <td rowspan="8" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningResiko?->transfer_mobilitas }}</td>
                            </tr>
                            <tr>
                                <td>memerlukan sedikit bantuan (1orang)/dalam pengawasan</td>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                            </tr>
                            <tr>
                                <td>memerlukan bantuan yang nyata (2orang)</td>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                            </tr>
                            <tr>
                                <td>tidak dapat duduk dengan seimbang, perlu bantuan total</td>
                                <td style="text-align: center; vertical-align: middle;">3</td>
                            </tr>
                            <tr>
                                <td rowspan="4" style="text-align: center; vertical-align: middle;">Mobilitas</td>
                                <td>mandiri (boleh menggunakan alat bantu jalan)</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                            </tr>
                            <tr>
                                <td>berjalan dengan bantuan 1 orang (verbal/fisik)</td>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                            </tr>
                            <tr>
                                <td>menggunakan kursi roda</td>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                            </tr>
                            <tr>
                                <td>imobilitas</td>
                                <td style="text-align: center; vertical-align: middle;">3</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: left; vertical-align: middle;">
                                    <strong>
                                        KESIMPULAN:
                                        @if ($skriningResiko?->total_skor >= 0 && $skriningResiko?->total_skor <= 5)
                                            Skor 0-5 risiko rendah jatuh
                                        @elseif($skriningResiko?->total_skor >= 6 && $skriningResiko?->total_skor <= 16)
                                            Skor 6-16 risiko jatuh sedang
                                        @elseif($skriningResiko?->total_skor >= 17)
                                            Skor 17-30 risiko jatuh tinggi
                                        @else
                                            -
                                        @endif
                                    </strong>
                                </td>
                                <td><strong>TOTAL SKOR:</strong></td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <strong>{{ $skriningResiko?->total_skor }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="50%" class="text-left">
                    <b>C. DATA DIAGNOSTIK</b><br>
                </td>
                <td width="50%" class="text-left">
                    <b>D. KEBUTUHAN EDUKASI</b><br>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <b>Laboratorium :</b>
                    {{ is_array($diagnostikEdukasi['diagnostik_laboratorium'] ?? null) ? implode(', ', $diagnostikEdukasi['diagnostik_laboratorium']) : $diagnostikEdukasi['diagnostik_laboratorium'] ?? '' }}<br>
                    <b>Radiologi:</b>
                    {{ is_array($diagnostikEdukasi['diagnostik_radiologi'] ?? null) ? implode(', ', $diagnostikEdukasi['diagnostik_radiologi']) : $diagnostikEdukasi['diagnostik_radiologi'] ?? '' }}<br>
                    <b>Lain-lain:</b>
                    {{ is_array($diagnostikEdukasi['diagnostik_lainya'] ?? null) ? implode(', ', $diagnostikEdukasi['diagnostik_lainya']) : $diagnostikEdukasi['diagnostik_lainya'] ?? '' }}<br>
                </td>
                <td width="50%" class="text-left">
                    <ol start="1" style="padding-left:13px;">
                        <li>Apa yang saudara ketahui tentang penyakit saudara
                            <strong>
                                <u>
                                    <i>{{ is_array($diagnostikEdukasi['tentang_penyakit'] ?? null) ? implode(', ', $diagnostikEdukasi['tentang_penyakit']) : $diagnostikEdukasi['tentang_penyakit'] ?? '' }}</i>
                                </u>
                            </strong>
                        </li>
                        <li>Informasi apa yang ingin saudara ketahui/ yang di perlukan
                            <strong>
                                <u>
                                    <i>{{ is_array($diagnostikEdukasi['informasi_yg_ingin_diketahui'] ?? null) ? implode(', ', $diagnostikEdukasi['informasi_yg_ingin_diketahui']) : $diagnostikEdukasi['informasi_yg_ingin_diketahui'] ?? '' }}</i>
                                </u>
                            </strong>
                        </li>
                        <li>Siapa dari keluarga yang ikut terlibat dalam perawatan selanjutnya
                            <strong>
                                <u>
                                    <i>
                                        {{ is_array($diagnostikEdukasi['keluarga_terlibat_perawatan'] ?? null) ? implode(', ', $diagnostikEdukasi['keluarga_terlibat_perawatan']) : $diagnostikEdukasi['keluarga_terlibat_perawatan'] ?? '' }}
                                    </i>
                                </u>
                            </strong>
                        </li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <table class="table table-xs table-bordered">
                        <tbody>
                            <tr style="background-color: #fff4d3">
                                <td colspan="4"><strong>SKRINING NUTRISI</strong></td>
                            </tr>
                            <tr>
                                <td><strong>No</strong></td>
                                <td><strong>Parameter</strong></td>
                                <td><strong>Nilai</strong></td>
                                <td><strong>Skor</strong></td>
                            </tr>
                            <tr>
                                <td rowspan="9">1.</td>
                                <td>Apakah pasien mengalami penurunan berat badan yang tidak direncanakan?</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Tidak (tidak terjadi penurunan dalam 6 bulan terakhir)</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $skriningNutrisi?->tidak_terjadi_penurunan != null ? $skriningNutrisi->tidak_terjadi_penurunan : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>Tidak yakin (tanyakan apakah baju/celana terasa longgar)</td>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $skriningNutrisi?->tidak_yakin_turun != null ? $skriningNutrisi->tidak_yakin_turun : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>Ya, berapakah penurunan berat badan tersebut?</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>1 - 5 Kg</td>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $skriningNutrisi?->skor_penurunan_1_5 ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>6 - 10 Kg</td>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $skriningNutrisi?->skor_penurunan_6_10 ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>11 - 15 Kg</td>
                                <td style="text-align: center; vertical-align: middle;">3</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $skriningNutrisi?->skor_penurunan_11_15 ?? '' }}</td>
                            </tr>
                            <tr>
                                <td> > 15 Kg</td>
                                <td style="text-align: center; vertical-align: middle;">4</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $skriningNutrisi?->skor_penurunan_lbh_15 ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Tidak Yakin</td>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $skriningNutrisi?->penurunan_tidak_yakin == 2 ? $skriningNutrisi?->penurunan_tidak_yakin : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="3">2.</td>
                                <td>Apakah asupan makanan pasien buruk akibat nafsu makan yang menurun? (misalnya asupan
                                    makan hanya 3/4 dari biasanya)</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Tidak</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $skriningNutrisi?->nafsu_makan_buruk === 0 ? '0' : '' }}</td>
                            </tr>
                            <tr>
                                <td>Ya</td>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $skriningNutrisi?->nafsu_makan_buruk === 1 ? '1' : '' }}</td>
                            </tr>
                            <tr>
                                <td rowspan="3">3.</td>
                                <td>Sakit berat?</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Tidak</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Ya</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong>
                                        KESIMPULAN:
                                        @if ($skriningNutrisi?->total_skor_skrining_nutrisi <= 2)
                                        Total Skor < 2, skrining ulang 7 hari @else Total Skor> 2, rujuk ke diestisien
                                                untuk asesmen
                                        @endif
                                    </strong>
                                </td>
                                <td colspan="2"><strong>Total SKor :
                                        {{ $skriningNutrisi?->total_skor_skrining_nutrisi ?? '' }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <table class="table table-xs table-bordered">
                        <tbody>
                            <tr style="background-color: #fff4d3">
                                <td colspan="5"><strong>ASESMEN FUNGSIONAL</strong> ( <i>Barthel Index</i> )</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;"><strong>No</strong></td>
                                <td style="text-align: center; vertical-align: middle;"><strong>Fungsi</strong></td>
                                <td style="text-align: center; vertical-align: middle;"><strong>Skor</strong></td>
                                <td style="text-align: center; vertical-align: middle;"><strong>Keterangan</strong></td>
                                <td style="text-align: center; vertical-align: middle;"><strong>Skor Pasien</strong></td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">1</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">Mengendalikan
                                    rangsang defekasi</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td>Tak terkendali / tak teratur (perlu bantuan)</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningFungsional?->skor_af_rangsang_defeksi }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td>Kadang - kadang tak terkendali</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                                <td>Mandiri</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">2</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">Mengendalikan
                                    rangsang berkemih</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td>Tak terkendali / pakai kateter</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningFungsional?->skor_af_rangsang_berkemih }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td>Kadang - kadang tak terkendali (1x 24jam)</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                                <td>Mandiri</td>
                            </tr>
                            <tr>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">3</td>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">Membersihkan diri
                                    (sekamuka, sisir rambut, sikat gigi)</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td>Butuh Pertolongan orang lain</td>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningFungsional?->skor_af_membersihkan_diri }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td>Mandiri</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">4</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">Penggunaan jamban,
                                    masuk dan keluar</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td>Tergantung pertolongan oranglain</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningFungsional?->skor_af_penggunaan_jamban }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td>Perlu pertolongan pada beberapa kegiatran tetapi dapat mengerjakan sendiri kegiatan lain
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                                <td>Mandiri</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">5</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">Makan</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td>Tidak Mampu</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningFungsional?->skor_af_makan }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td>Perlu pertolongan makan</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                                <td>Mandiri</td>
                            </tr>
                            <tr>
                                <td rowspan="4" style="text-align: center; vertical-align: middle;">6</td>
                                <td rowspan="4" style="text-align: center; vertical-align: middle;">Berubah sikap dari
                                    berbaring ke duduk</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td>Tidak Mampu</td>
                                <td rowspan="4" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningFungsional?->skor_af_berubah_sikap }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td>Perlu banyak bantuan untuk bisa duduk ( 2orang)</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                                <td>Bantuan minimal 2 orang</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">3</td>
                                <td>Mandiri</td>
                            </tr>
                            <tr>
                                <td rowspan="4" style="text-align: center; vertical-align: middle;">7</td>
                                <td rowspan="4" style="text-align: center; vertical-align: middle;">Berpindah /
                                    berjalan</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td>Tidak Mampu</td>
                                <td rowspan="4" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningFungsional?->skor_af_berpindah_berjalan }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td>Bisa (pindah) dengan kursi</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                                <td>Berjalan dengan bantuan 1 orang</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">3</td>
                                <td>Mandiri</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">8</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">Memakai Baju</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td>Tergantung Orang lain</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningFungsional?->skor_af_memakai_baju }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td>Sebagian dibantu (misalnya mengancingkan baju)</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                                <td>Mandiri</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">9</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">Naik turun tangga
                                </td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td>Tidak mampu</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningFungsional?->skor_af_naik_tangga }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td>Butuh pertolongan orang lain</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">2</td>
                                <td>Mandiri</td>
                            </tr>
                            <tr>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">10</td>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">Mandi</td>
                                <td style="text-align: center; vertical-align: middle;">0</td>
                                <td>Tergantung</td>
                                <td rowspan="2" style="text-align: center; vertical-align: middle;">
                                    {{ $skriningFungsional?->skor_af_mandi }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td>Mandiri</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: left; vertical-align: middle;">
                                    <strong>
                                        KESIMPULAN:
                                        @if ($skriningFungsional?->total_skor_af === 20)
                                            Skor 20: Mandiri
                                        @elseif($skriningFungsional?->total_skor_af >= 12 && $skriningFungsional?->total_skor_af <= 19)
                                            Skor 12-19: Ketergantungan Ringan
                                        @elseif($skriningFungsional?->total_skor_af >= 9 && $skriningFungsional?->total_skor_af <= 11)
                                            Skor 9-11: Ketergantungan Sedang
                                        @elseif($skriningFungsional?->total_skor_af >= 5 && $skriningFungsional?->total_skor_af <= 8)
                                            Skor 5-8: Ketergantungan Berat
                                        @elseif($skriningFungsional?->total_skor_af >= 0 && $skriningFungsional?->total_skor_af <= 4)
                                            Skor 0-4: Ketergantungan Total
                                        @else
                                            -
                                        @endif
                                    </strong>
                                </td>
                                <td colspan="2" style="text-align: right; vertical-align: middle;">
                                    <strong>Total Skor : {{ $skriningFungsional?->total_skor_af }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-left">
                    <b>E. PERENCANAAN PULANG</b><br>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <table class="table table-xs table-bordered">
                        <tbody>
                            <tr>
                                <td><strong>No</strong></td>
                                <td><strong>Kriteria Pasien</strong></td>
                                <td><strong>YA/TIDAK</strong></td>
                                <td><strong>Keterangan</strong></td>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Usia diatas 70 tahun</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->usia_lbh_7 === 1 ? 'YA' : 'TIDAK' }}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Pasien tinggal sendiri</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->pasien_tinggal_sendiri === 1 ? 'YA' : 'TIDAK' }}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Tempat tinggal pasien memiliki tetangga</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->memiliki_tetangga === 1 ? 'YA' : 'TIDAK' }}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Memerlukan perawatan lanjutan dirumah</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->perawatan_lanjutan_dirumah === 1 ? 'YA' : 'TIDAK' }}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>Mempunyai keterbatasan kemampuan merawat diri</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->keterbatasan_merawat_diri === 1 ? 'YA' : 'TIDAK' }}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>Pasien pulang dengan jumlah obat lebih dari 6 jenis / macam
                                    obat</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->lebih_6_jenis_obat === 1 ? 'YA' : 'TIDAK' }}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                            <tr>
                                <td>7.</td>
                                <td>Kesulitan mobilitas</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->kesulitan_mobilitas === 1 ? 'YA' : 'TIDAK' }}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                            <tr>
                                <td>8.</td>
                                <td>Memerlukan alat bantu</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->memerlukan_alat_bantu === 1 ? 'YA' : 'TIDAK' }}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                            <tr>
                                <td>9.</td>
                                <td>Memerlukan pelayanan medis</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->memerlukan_pelayanan_medis === 1 ? 'YA' : 'TIDAK' }}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                            <tr>
                                <td>10.</td>
                                <td>Memerlukan pelayanan keperawatan</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->memerlukan_pelayanan_keperawatan === 1 ? 'YA' : 'TIDAK' }}
                                </td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                            <tr>
                                <td>11.</td>
                                <td>Memerlukan bantuan dalam kehidupan sehari-hari</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->memerlukan_bantuan_sehari_hari === 1 ? 'YA' : 'TIDAK' }}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                            <tr>
                                <td>12.</td>
                                <td>Riwayat sering menggunakan fasilitasi gawat darurat</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $perencanaanPulang?->sering_menggunakan_fasilitas_igd === 1 ? 'YA' : 'TIDAK' }}
                                </td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="50%" class="text-left">
                    <b>F. DIAGNOSA KEPERAWATAN</b><br>
                </td>
                <td width="50%" class="text-left">
                    <b>G. RENCANA ASUHAN KEPERAWATAN</b><br>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    {{ $kunjungan->asesmen_ranap_keperawatan->diagnosa_keperawatan }}
                </td>
                <td width="50%" class="text-left">
                    <ul>
                        @foreach ($rencanaAsuhan as $rencanaAsuhanKeperawatan)
                            <li>Waktu: {{ $rencanaAsuhanKeperawatan->tanggal_rencana }}
                                {{ $rencanaAsuhanKeperawatan->waktu_rencana }} | Keterangan:
                                {{ $rencanaAsuhanKeperawatan->keterangan }} </li>
                        @endforeach
                    </ul>
                </td>
            </tr>

            <tr style="background-color: #ffc107">
                <td width="50%" class="text-center">
                    <b>Tanggal & Jam Selesai Asesmen</b>
                </td>
                <td width="50%" class="text-center">
                    <b>Nama & Tanda Tangan Perawat</b>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <table class="table-borderless">
                        <tr>
                            <td><b>Tanggal</b></td>
                            <td>:</td>
                            <td>
                                <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap_keperawatan->created_at)->format('d F Y') }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Waktu</b></td>
                            <td>:</td>
                            <td>
                                <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap_keperawatan->created_at)->format('H:i:s') }}
                                    WIB</b>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" class="text-center">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <u><b>Nama User Perawat</b></u>
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
@endsection
