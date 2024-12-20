@extends('simrs.erm-ranap.template_print.pdf_print')
@section('title', 'Asesmen Awal Rawat Inap')

@section('content')
    @include('simrs.erm-ranap.template_print.pdf_kop_surat')
    @if ($kunjungan->asesmen_ranap)
        <table class="table table-sm table-bordered" style="font-size: 11px">
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-center">
                    <b>ASEMEN AWAL RAWAT INAP</b><br>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <tr>
                        <td>
                            Tiba di Ruangan Tanggal : <strong>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->tgl_tiba_diruangan)->format('d F Y') }}</strong> Jam: <strong>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->waktu_tiba_diruangan)->format('H:i:s') }} WIB</strong><br>
                            Ruang Perawatan : <strong>{{$kunjungan->asesmen_ranap->nama_unit}}</strong> <br>
                            Nama Keluarga : <strong>{{$kunjungan->asesmen_ranap->nama_keluarga??'-'}}</strong>
                        </td>
                        <td>
                            Tanggal Pengkajian : <strong>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->tgl_pengkajian)->format('d F Y') }}</strong> Jam: <strong>{{ \Carbon\Carbon::parse($kunjungan->asesmen_ranap->waktu_pengkajian)->format('H:i:s') }} WIB</strong><br>
                            Sumber Data : <strong>{{$kunjungan->asesmen_ranap->sumber_data}}</strong> <br>
                            Hubungan Keluarga : <strong>{{$kunjungan->asesmen_ranap->hubungan_keluarga??'-'}}</strong>
                        </td>
                    </tr>
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
                                {{-- <b>{{ $kunjungan->asesmen_ranap->diastole }} /
                                    {{ $kunjungan->asesmen_ranap->sistole }}</b> mmHg --}}
                                     <b>{{$kunjungan->asesmen_ranap->sistole}} mmHg</b>
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
                        {{-- <tr>
                            <td>Denyut Nadi</td>
                            <td>:</td>
                            <td>
                                <b>{{ $kunjungan->asesmen_ranap->denyut_nadi }}</b> x/menit
                            </td>
                        </tr> --}}
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
                                        <td>{{ $item->tanggal }} {{ $item->waktu_asuhan }} WIB</td>
                                        <td>{{ $item->profesi }}</td>
                                        <td>
                                            <pre>{{ $item->rencana_asuhan }}</pre>
                                        </td>
                                        <td>
                                            <pre>{{ $item->capaian_diharapkan }}</pre>
                                        </td>
                                        <td>{{ $item->user_dokter }}</td>
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
