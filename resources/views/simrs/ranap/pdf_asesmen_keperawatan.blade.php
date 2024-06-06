@extends('simrs.ranap.pdf_print')
@section('title', 'Asesmen Awal Keperawatan Rawat Inap')

@section('content')
    @include('simrs.ranap.pdf_kop_surat')
    @if ($kunjungan->asesmen_ranap)
        <table class="table table-sm table-bordered" style="font-size: 11px">
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-center">
                    <b>ASEMEN AWAL KEPERAWATAN RAWAT INAP</b><br>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    Berasal dari <b>{{ $kunjungan->asesmen_ranap->asal_masuk }}</b> cara masuk menggunakan
                    <b>{{ $kunjungan->asesmen_ranap->cara_masuk }}</b>.
                    Tiba di Ruang Perawatan <b>{{ $kunjungan->asesmen_ranap->nama_unit }}</b> Tanggal
                    <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->tgl_masuk_ruangan)->format('d F Y') }}</b> Jam
                    <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->tgl_masuk_ruangan)->format('H:i:s') }}</b>.
                    <br>
                    Tanggal Pengkajian
                    <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->tgl_asesmen_awal)->format('d F Y') }}</b> Pukul
                    <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->tgl_asesmen_awal)->format('H:i:s') }}</b> WIB.
                    Sumber
                    Data <b>{{ $kunjungan->asesmen_ranap->sumber_data }}</b>. <br>
                    Nama Keluarga
                    <b>{{ $kunjungan->asesmen_ranap->nama_keluarga }}</b> Hubungan
                    <b>{{ $kunjungan->asesmen_ranap->hubungan_keluarga }}</b>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-center">
                    <b>ANAMNESIS</b><br>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <b>Keluhan Utama :</b><br>
                    <pre>{{ $kunjungan->asesmen_ranap->keluhan_utama }}</pre> <br>
                    <b>Riwayat Pengobatan :</b><br>
                    <pre>{{ $kunjungan->asesmen_ranap->riwayat_pengobatan }}</pre> <br>
                </td>
                <td width="50%">
                    <b>Riwayat Penyakit Utama :</b><br>
                    <pre>{{ $kunjungan->asesmen_ranap->riwayat_penyakit_utama }}</pre> <br>
                    <b>Riwayat Penyakit Dahulu :</b><br>
                    <pre>{{ $kunjungan->asesmen_ranap->riwayat_penyakit_dahulu }}</pre> <br>
                    <b>Riwayat Penyakit Keluarga :</b><br>
                    <pre>{{ $kunjungan->asesmen_ranap->riwayat_penyakit_keluarga }}</pre>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="50%" class="text-center">
                    <b>TANDA-TANDA VITAL</b>
                </td>
                <td width="50%" class="text-center">
                    <b>PEMERIKSAAN</b>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <table class="table-borderless">
                        <tr>
                            <td>Keadaan Umum</td>
                            <td>:</td>
                            <td><b>{{ $kunjungan->asesmen_ranap->keadaan_umum }}</b></td>
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
                <td width="50%">
                    <b>Pemeriksaan Fisik :</b><br>
                    <pre>{{ $kunjungan->asesmen_ranap->pemeriksaan_fisik }}</pre><br>
                    <b>Pemeriksaan Penunjang :</b><br>
                    <pre>{{ $kunjungan->asesmen_ranap->pemeriksaan_penunjang }}</pre><br>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-center">
                    <b>SKRINING NYERI</b><br>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <img src="{{ public_path('nyeri_nrs.png') }}" width="100%" alt="">
                    <table class="table-borderless">
                        <tr>
                            <td>Skala Nyeri</td>
                            <td>:</td>
                            <td><b>{{ $kunjungan->asesmen_ranap_keperawatan->skala_nyeri }}</b></td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <b>Asesmen Nyeri Lanjutan</b>
                    <table class="table-borderless">
                        <tr>
                            <td>Provocation</td>
                            <td>:</td>
                            <td><b>{{ $kunjungan->asesmen_ranap_keperawatan->provocation }}</b></td>
                        </tr>
                        <tr>
                            <td>Quality</td>
                            <td>:</td>
                            <td><b>{{ $kunjungan->asesmen_ranap_keperawatan->quality }}</b></td>
                        </tr>
                        <tr>
                            <td>Region</td>
                            <td>:</td>
                            <td><b>{{ $kunjungan->asesmen_ranap_keperawatan->region }}</b></td>
                        </tr>
                        <tr>
                            <td>Severity</td>
                            <td>:</td>
                            <td><b>{{ $kunjungan->asesmen_ranap_keperawatan->severity }}</b></td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td>:</td>
                            <td><b>{{ $kunjungan->asesmen_ranap_keperawatan->time }}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-center">
                    <b>PEMERIKSAAN FISIK</b><br>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>SISTEM RESPIRASI & OKSIGENASI</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>Obstruksi Saluran Napas Atas</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Sesak Napas (Dyspnea)</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Pemakaian Alat Bantu Napas</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Batuk</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Bunyi Napas</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Thorax</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>CTT</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>SISTEM KARDIOVASKULER</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>Nadi</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Konjungtiva</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Riwayat Pemasangan Alat</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Kulit</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Bunyi Napas</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Temperatur</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Bunyi Jantung</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Ekstrimitas CRT</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Terpasang Nichiban / TR Band</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Edema</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PEMERIKSAAN SISTEM GASTRO INTESTINAL</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>Makan</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Mual</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>BAB</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Sklera</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Mulut & Faring</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Reflreksi Menelan</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Reflreksi Menguyah</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Alat Bantu</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Abdomen</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Stoma</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                        <tr>
                            <td>Drain</td>
                            <td>:</td>
                            <td><b></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PEMERIKSAAN SISTEM MUSKOLO SKELETAL</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>Fraktur</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Mobilitas</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PEMERIKSAAN SISTEM NEUROLOGI</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>Kesulitan Bicara</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Kelemahan alat gerak</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Terpasang EVD</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PEMERIKSAAN SISTEM UROGENITAL</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>Perubahan Pola BAK</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Frekuensi BAK</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Alat Bantu</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Stoma</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PEMERIKSAAN SISTEM INTEGUMEN</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>Luka</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Benjolan</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Suhu</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>HYGIENE</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>Aktifitas Sehari-hari</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Penampilan</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>PSIKOSISIAL & BUDAYA</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>Ekspresi Wajah</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Kemampuan Bicara</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Koping Mekanisme</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Tinggal Bersama</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Suku</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>SPIRITUAL & NILAI-NILAI KEPERCAYAAN</b><br>
                    <table class="table-borderless">
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                        <tr>
                            <td>Nilai-Nilai Kepercayaan</td>
                            <td>:</td>
                            <td><b>Tidak</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-center">
                    <b>DIAGNOSA</b><br>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <b>Diagnosa Kerja :</b><br>
                    <pre>{{ $kunjungan->asesmen_ranap->diagnosa_kerja }}</pre>
                </td>
                <td width="50%">
                    <b>Diagnosa Banding :</b><br>
                    <pre>{{ $kunjungan->asesmen_ranap->diagnosa_banding }}</pre>
                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-center">
                    <b>RENCANA ASUHAN</b><br>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <b>Rencana Pemeriksaan Penunjang :</b><br>
                    <pre>{{ $kunjungan->asesmen_ranap->rencana_penunjang }}</pre>
                </td>
                <td width="50%">
                    <b>Rencana Tindakan :</b><br>
                    <pre>{{ $kunjungan->asesmen_ranap->rencana_tindakan }}</pre>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>Rencana Asuhan Terpadu</b><br>
                    <table class="table table-xs table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Profesi</th>
                                <th>Rencana Asuhan</th>
                                <th>Capaian yang diharapkan</th>
                                <th>Ttd & Nama Jelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($kunjungan->asuhan_terpadu)
                                @foreach ($kunjungan->asuhan_terpadu as $item)
                                    <tr>
                                        <td>{{ $item->tgl_waktu }}</td>
                                        <td>{{ $item->profesi }}</td>
                                        <td>
                                            <pre>{{ $item->rencana_asuhan }}</pre>
                                        </td>
                                        <td>
                                            <pre>{{ $item->capaian_diharapkan }}</pre>
                                        </td>
                                        <td>{{ $item->pic }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td>.........</td>
                                <td>.........</td>
                                <td>.........</td>
                                <td>.........</td>
                                <td>.........</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>Rencana Kepulangan Pasien</b><br>
                    Rencana lama rawat sudah bisa ditetapkan
                    {{ $kunjungan->asesmen_ranap->rencana_lama_ranap ?? '.........' }} hari <br>
                    Rencana tanggal pulang {{ $kunjungan->asesmen_ranap->rencana_tgl_pulang ?? '.........' }} <br>
                    Belum bisa ditetapkan, kerena {{ $kunjungan->asesmen_ranap->alasan_lama_ranap ?? '.........' }} <br>
                    Memerlukan perawatan lanjutan {{ $kunjungan->asesmen_ranap->lanjutan_perawatan ?? '.........' }} <br>

                </td>
            </tr>
            <tr style="background-color: #ffc107">
                <td width="50%" class="text-center">
                    <b>Tanggal & Jam Selesai Asesmen</b>
                </td>
                <td width="50%" class="text-center">
                    <b>Nama & Tanda Tangan DPJP</b>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <table class="table-borderless">
                        <tr>
                            <td><b>Tanggal</b></td>
                            <td>:</td>
                            <td>
                                <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->created_at)->format('d F Y') }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Waktu</b></td>
                            <td>:</td>
                            <td>
                                <b>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->created_at)->format('H:i:s') }}
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
                    <u><b>{{ $kunjungan->dokter->nama_paramedis }}</b></u>
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
