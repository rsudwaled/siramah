@extends('livewire.print.pdf_layout')
@section('title', 'Resume Rawat Jalan')

@section('content')
    <table class="table table-sm table-bordered" style="font-size: 9px;">
        <tr>
            <td width="10%" class="text-center" style="vertical-align: top;">
                <img src="{{ public_path('rswaled.png') }}" style="height: 50px;">
                {{-- <img src="{{ asset('rswaled.png') }}" style="height: 30px;"> --}}
            </td>
            <td width="50%" style="vertical-align: top;">
                <b>RSUD WALED KABUPATEN CIREBON</b><br>
                Jl. Prabu Kiansantang No.4<br>
                Desa Waled Kota, Kec. Waled, Kabupaten Cirebon, Jawa Barat 45187<br>
                www.rsdudwaled.id
            </td>
            <td width="40%" style="vertical-align: top;">
                <table class="table-borderless">
                    <tr>
                        <td>No RM</td>
                        <td>:</td>
                        <td><b>{{ $kunjungan->pasien->no_rm ?? '-' }}</b></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><b>{{ $kunjungan->pasien->nama_px ?? '-' }}</b></td>
                    </tr>
                    <tr>
                        <td>Tgl Lahir</td>
                        <td>:</td>
                        <td>
                            <b>
                                {{ \Carbon\Carbon::parse($kunjungan->pasien->tgl_lahir)->isoFormat('D MMMM YYYY') }}
                                ({{ \Carbon\Carbon::parse($kunjungan->pasien->tgl_lahir)->age }} tahun)
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td>Sex</td>
                        <td>:</td>
                        <td>
                            <b>
                                @if ($kunjungan)
                                    @if ($kunjungan->gender == 'P')
                                        Perempuan
                                    @else
                                        Laki-laki
                                    @endif
                                @endif
                            </b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="text-center" style="background: yellow">
            <td colspan="3">
                <b>RESUME RAWAT JALAN</b>
            </td>
        </tr>
        <tr>
            <td class="text-center">
                {{-- <img src="{{ $url }}" width="40px"> --}}
            </td>
            <td>
                <table class="table-borderless">
                    <tr>
                        <td>Tanggal Masuk</td>
                        <td>:</td>
                        <td><b>
                                {{ $kunjungan->tgl_masuk ? \Carbon\Carbon::parse($kunjungan->tgl_masuk)->format('d F Y H:i') : '-' }}
                            </b></td>
                    </tr>
                    <tr>
                        <td>Unit / Ruangan</td>
                        <td>:</td>
                        <td><b>{{ $kunjungan->unit->nama_unit ?? '-' }}</b></td>
                    </tr>
                    <tr>
                        <td>Dokter</td>
                        <td>:</td>
                        <td><b>{{ $kunjungan->dokter->nama_paramedis ?? '-' }}</b></td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="table-borderless">
                    <tr>
                        <td>Penjamin</td>
                        <td>:</td>
                        <td>
                            <b>
                                {{ $kunjungan->penjamin_simrs->nama_penjamin }}
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td>Jenis Pelayanan</td>
                        <td>:</td>
                        <td><b>Rawat Jalan</b></td>
                    </tr>
                    <tr>
                        <td>Kode Kunjungan</td>
                        <td>:</td>
                        <td><b>{{ $kunjungan->kode_kunjungan ?? '-' }}</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table class="table-borderless">
                    <tr>
                        <td>Keluhan Utama</td>
                        <td>:</td>
                        <td>{{ $asesmendokter->keluhan_pasien ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="white-space:nowrap;">Pemeriksaan Fisik</td>
                        <td>:</td>
                        <td>
                            {{ $asesmendokter->pemeriksaan_fisik ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Diagnosa</td>
                        <td>:</td>
                        <td>
                            {{ $asesmendokter->diagnosakerja ?? '' }} <br>
                            {{ $asesmendokter->diagnosabanding ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowarp">ICD-10 Primer</td>
                        <td>:</td>
                        <td>{{ $grouping?->diagnosa_utama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>ICD-10 Sekunder</td>
                        <td>:</td>
                        <td>
                            @if ($grouping?->diagnosa)
                                @foreach (explode(';', $grouping?->diagnosa) as $item)
                                    {{ $item }} <br>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Tindakan</td>
                        <td>:</td>
                        <td>{{ $asesmendokter->tindakan_medis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>ICD-9 Procedure</td>
                        <td>:</td>
                        <td>
                            @if ($grouping?->prosedur)
                                @foreach (explode(';', $grouping?->prosedur) as $item)
                                    {{ $item }} <br>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Pengobatan</td>
                        <td>:</td>
                        <td>
                            {{-- @foreach ($resepobatdetails as $item)
                                <b>R/ {{ $item->nama }}</b> ({{ $item->jumlah }}) {{ $item->frekuensi }}
                                {{ $item->waktu }}
                                {{ $item->keterangan }} <br>
                            @endforeach --}}
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="table-borderless">
                    <tr>
                        <td>Tekanan Darah</td>
                        <td>:</td>
                        <td>
                            {{ $asesmendokter->tekanan_darah ?? '-' }} mmHg
                        </td>
                    </tr>
                    <tr>
                        <td>Denyut Nadi</td>
                        <td>:</td>
                        <td>
                            {{ $asesmendokter->frekuensi_nadi ?? '-' }} x/menit
                        </td>
                    </tr>
                    <tr>
                        <td>Pernapasan</td>
                        <td>:</td>
                        <td>
                            {{ $asesmendokter->frekuensi_nafas ?? '-' }} x/menit
                        </td>
                    </tr>
                    <tr>
                        <td>Suhu</td>
                        <td>:</td>
                        <td>
                            {{ $asesmendokter->suhu_tubuh ?? '-' }} Celcius
                        </td>
                    </tr>
                    <tr>
                        <td>BB / TB</td>
                        <td>:</td>
                        <td>
                            {{ $asesmendokter->berat_badan ?? '-' }} kg /
                            {{ $asesmendokter->tinggi_badan ?? '-' }} cm
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table class="table-borderless">
                    <tr>
                        <td>Catatan Laboratorium</td>
                        <td>:</td>
                        <td>
                            {{-- {{ $antrian->asesmendokter->pemeriksaan_lab ?? '-' }} --}}
                        </td>
                    </tr>
                    <tr>
                        <td>Catatan Radiologi</td>
                        <td>:</td>
                        <td>
                            {{-- {{ $antrian->asesmendokter->pemeriksaan_rad ?? '-' }} --}}
                        </td>
                    </tr>
                    <tr>
                        <td>Catatan Penunjang</td>
                        <td>:</td>
                        <td>
                            {{-- {{ $antrian->asesmendokter->pemeriksaan_penunjang ?? '-' }} --}}
                        </td>
                    </tr>

                </table>
                <br>
            </td>
            <td class="text-center">
                Dokter DPJP, <br>
                <img src="{{ $ttddokter }}" width="70px"> <br>
                <b><u>{{ $asesmendokter->nama_dokter }}</u></b>
            </td>
        </tr>
    </table>
    <style>
        @page {
            size: "A4";
            /* Misalnya ukuran A4 */
        }
    </style>
@endsection
