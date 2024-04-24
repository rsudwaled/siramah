@extends('simrs.ranap.pdf_print')
@section('title', 'RESUME RANAP ' . $pasien->nama_px)

@section('content')
    @include('simrs.ranap.pdf_kop_surat')
    @if ($erm)
        <table class="table table-sm table-bordered" style="font-size: 11px">
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-center">
                    <b>RINGKASAN PASIEN PULANG</b>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <table class="table-borderless">
                        <tr>
                            <td>Tanggal Masuk</td>
                            <td>:</td>
                            <td>
                                <b>
                                    {{ $kunjungans->first()->tgl_masuk ? Carbon\Carbon::parse($kunjungans->first()->tgl_masuk)->format('d F Y H:i:s') : '-' }}
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Keluar</td>
                            <td>:</td>
                            <td>
                                <b>
                                    {{ $kunjungan->tgl_keluar ? Carbon\Carbon::parse($kunjungan->tgl_keluar)->format('d F Y H:i:s') : 'Masih dirawat' }}
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td>Lama Rawat</td>
                            <td>:</td>
                            <td>
                                <b>{{ $lama_rawat }}</b> hari
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table class="table-borderless">
                        <tr>
                            <td>Ruangan Asal</td>
                            <td>:</td>
                            <td>
                                <b>
                                    {{ $kunjungans->first()->unit->nama_unit ?? '-' }}
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td>Ruangan Inap</td>
                            <td>:</td>
                            <td>
                                <b>
                                    {{ $kunjungan->unit->nama_unit ?? '-' }}
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td>No SEP</td>
                            <td>:</td>
                            <td>
                                <b>{{ $kunjungan->no_sep ?? '-' }}</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>Ringkasan Perawatan : </b><br>
                    <pre>{{ $kunjungan->erm_ranap->ringkasan_perawatan ?? '....' }}</pre>
                    <b>Riwayat Penyakit : </b><br>
                    <pre>{{ $kunjungan->erm_ranap->riwayat_penyakit ?? '....' }}</pre>
                    <b>Indikasi Rawat Inap : </b><br>
                    <pre>{{ $kunjungan->erm_ranap->indikasi_ranap ?? '....' }}</pre>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <b>Pemeriksaan Fisik : </b><br>
                    <pre>{{ $kunjungan->erm_ranap->pemeriksaan_fisik ?? '....' }}</pre>
                </td>
                <td width="50%">
                    <table class="table-borderless">
                        <tr>
                            <td>Suhu Badan</td>
                            <td>:</td>
                            <td>
                                <b>{{ $kunjungan->erm_ranap->suhu ?? '....' }}</b> Celcius
                            </td>
                        </tr>
                        <tr>
                            <td>Tekanan Darah</td>
                            <td>:</td>
                            <td>
                                <b>{{ $kunjungan->erm_ranap->tensi_darah ?? '....' }}</b> mmHg
                            </td>
                        </tr>
                        <tr>
                            <td>Denyut Nadi</td>
                            <td>:</td>
                            <td>
                                <b>{{ $kunjungan->erm_ranap->denyut_nadi ?? '....' }}</b> xs
                            </td>
                        </tr>
                        <tr>
                            <td>Pernapasan</td>
                            <td>:</td>
                            <td>
                                <b>{{ $kunjungan->erm_ranap->pernapasan ?? '....' }}</b> xs
                            </td>
                        </tr>
                        <tr>
                            <td>Berat Badan</td>
                            <td>:</td>
                            <td>
                                <b>{{ $kunjungan->erm_ranap->berat_badan ?? '....' }}</b> kg
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>Pemeriksaan Laboratorium : </b><br>
                    <pre>{{ $kunjungan->erm_ranap->catatan_laboratorium ?? '....' }}</pre>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>Pemeriksaan Radiologi : </b><br>
                    <pre>{{ $kunjungan->erm_ranap->catatan_radiologi ?? '....' }}</pre>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>Pemeriksaan Penunjang Lainnya : </b><br>
                    <pre>{{ $kunjungan->erm_ranap->catatan_penunjang ?? '....' }}</pre>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>Hasil Konsultasi : </b><br>
                    <pre>{{ $kunjungan->erm_ranap->hasil_konsultasi ?? '....' }}</pre>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2" class="unicode">
                    <b>Pemeriksaan SHK : </b> <br>
                    Dilakukan :
                    @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pemeriksaan_shk == 'Ya' : null)
                        &#x2611; Ya
                    @else
                        &#x25A2; Ya
                    @endif/
                    @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pemeriksaan_shk == 'Tidak' : null)
                        &#x2611; Tidak
                    @else
                        &#x25A2; Tidak
                    @endif <br>
                    Diambil dari :
                    @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengambilan_shk == 'Tumit' : null)
                        &#x2611; Tumit
                    @else
                        &#x25A2; Tumit
                    @endif/
                    @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengambilan_shk == 'Vena' : null)
                        &#x2611; Vena
                    @else
                        &#x25A2; Vena
                    @endif <br>
                    Tgl Pengambilan :
                    @if ($kunjungan->erm_ranap)
                        {{ $kunjungan->erm_ranap->tanggal_shk ? \Carbon\Carbon::parse($kunjungan->erm_ranap->tanggal_shk)->format('d F Y') : '....' }}
                    @endif
                    <br>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <b>Diagnosa Masuk : </b><br>
                    <pre>{{ $kunjungan->erm_ranap->diagnosa_masuk ?? '....' }}</pre>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <table class="table-borderless">
                        <tr>
                            <td><b><u>Diagnosa Utama</u></b> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                {{ $kunjungan->erm_ranap->diagnosa_utama ?? '....' }}
                            </td>
                            <td>
                                {{ $kunjungan->erm_ranap->icd10_utama }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <table class="table-borderless">
                        <tr>
                            <td><b><u>Diagnosa Sekunder</u></b> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                @if ($kunjungan->erm_ranap)
                                    @if ($kunjungan->erm_ranap->diagnosa_sekunder)
                                        @foreach (json_decode($kunjungan->erm_ranap->diagnosa_sekunder) as $item)
                                            {{ $loop->iteration }}. {{ $item }} <br>
                                        @endforeach
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($kunjungan->erm_ranap)
                                    @if ($kunjungan->erm_ranap->icd10_sekunder)
                                        @foreach (json_decode($kunjungan->erm_ranap->icd10_sekunder) as $item)
                                            {{ $item }} <br>
                                        @endforeach
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <table class="table-borderless">
                        <tr>
                            <td><b><u>Tindakan Operasi</u></b> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                @if ($kunjungan->erm_ranap)
                                    @if ($kunjungan->erm_ranap->tindakan_operasi)
                                        @foreach (json_decode($kunjungan->erm_ranap->tindakan_operasi) as $item)
                                            {{ $loop->iteration }}. {{ $item }} <br>
                                        @endforeach
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($kunjungan->erm_ranap)
                                    @if ($kunjungan->erm_ranap->icd9_operasi)
                                        @foreach (json_decode($kunjungan->erm_ranap->icd9_operasi) as $item)
                                            {{ $item }} <br>
                                        @endforeach
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                    <b>Tgl Operasi : </b>{{ $kunjungan->erm_ranap->tanggal_operasi ?? '....' }} <br>
                    <b>Waktu Mulai : </b>{{ $kunjungan->erm_ranap->awal_operasi ?? '....' }} <br>
                    <b>Waktu Selesai : </b>{{ $kunjungan->erm_ranap->akhir_operasi ?? '....' }} <br>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2">
                    <table class="table-borderless">
                        <tr>
                            <td><b><u>Tindakan Prosedur</u></b> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                @if ($kunjungan->erm_ranap)
                                    @if ($kunjungan->erm_ranap->tindakan_prosedur)
                                        @foreach (json_decode($kunjungan->erm_ranap->tindakan_prosedur) as $item)
                                            {{ $loop->iteration }}. {{ $item }} <br>
                                        @endforeach
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($kunjungan->erm_ranap)
                                    @if ($kunjungan->erm_ranap->icd9_operasi)
                                        @foreach (json_decode($kunjungan->erm_ranap->icd9_prosedur) as $item)
                                            {{ $item }} <br>
                                        @endforeach
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <b>Pengobatan Selama Dirawat</b>
                    <table class="table table-xs table-borderless">
                        {{ $x = 1 }}
                        <thead>
                            <tr>
                                <td><b><u>No</u></b></td>
                                <td><b><u>Nama Obat</u></b></td>
                                <td><b><u>Keterangan</u></b></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obat2[0] as $item)
                                <tr>
                                    <td>{{ $x++ }} </td>
                                    <td>{{ $item['nama_barang'] }} </td>
                                    <td>{{ $item['keterangan'] }} </td>
                                    {{-- <td>{{ $item['jumlah_layanan'] }} {{ $item['satuan_barang'] }}</td>
                            <td>{{ $item['aturan_pakai'] }} </td> --}}
                                </tr>
                            @endforeach
                            <tr>
                                <td>...</td>
                                <td>.........</td>
                                <td>.........</td>
                                {{-- <td>.........</td> --}}
                                {{-- <td>.........</td> --}}
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="50%">
                    <br>
                    <table class="table table-xs table-borderless">
                        <thead>
                            <tr>
                                <td><b><u>No</u></b></td>
                                <td><b><u>Nama Obat</u></b></td>
                                <td><b><u>Keterangan</u></b></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obat2[1] as $item)
                                <tr class="border-bottom border-dark">
                                    <td>{{ $x++ }} </td>
                                    <td>{{ $item['nama_barang'] }} </td>
                                    <td>{{ $item['keterangan'] }} </td>
                                    {{-- <td>{{ $item['jumlah_layanan'] }} {{ $item['satuan_barang'] }}</td>
                            <td>{{ $item['aturan_pakai'] }} </td> --}}
                                </tr>
                            @endforeach
                            <tr>
                                <td>...</td>
                                <td>.........</td>
                                <td>.........</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="50%" class="unicode">
                    <b>Cara Keluar :</b><br>
                    @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->cara_pulang == 'Sembuh / Perbaikan' : null)
                        &#x2611; Sembuh / Perbaikan
                    @else
                        &#x25A2; Sembuh / Perbaikan
                    @endif <br>
                    @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->cara_pulang == 'Pindah RS' : null)
                        &#x2611; Pindah RS
                    @else
                        &#x25A2; Pindah RS
                    @endif <br>
                    @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->cara_pulang == 'Pulang Paksa' : null)
                        &#x2611; Pulang Paksa
                    @else
                        &#x25A2; Pulang Paksa
                    @endif <br>
                    @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->cara_pulang == 'Meninggal' : null)
                        &#x2611; Meninggal
                    @else
                        &#x25A2; Meninggal
                    @endif <br>
                    <pre>{{ $kunjungan->erm_ranap->cara_pulang_text ?? '' }}</pre>
                </td>
                <td width="50%">
                    <b>Kondisi Pulang :</b><br>
                    <pre>{{ $kunjungan->erm_ranap->kondisi_pulang ?? '....' }}</pre>
                    <b>Keadaan Umum :</b><br>
                    <pre>{{ $kunjungan->erm_ranap->kondisi_umum ?? '....' }}</pre>
                    <b>Kesadaran :</b> {{ $kunjungan->erm_ranap->kesadaran ?? '....' }}<br>
                    {{-- <b>Tekanan Darah :</b> {{ $kunjungan->erm_ranap->tensi_darah ?? '....' }}<br> --}}
                    {{-- <b>Nadi :</b> {{ $kunjungan->erm_ranap->denyut_nadi ?? '....' }}<br> --}}
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <table class="table table-borderless">
                        <tr>
                            <td width="50%" class="unicode">
                                <b>Pengobatan Dilanjutkan :</b><br>
                                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengobatan_lanjutan == 'Poliklinik RSUD Waled' : null)
                                    &#x2611; Poliklinik RSUD Waled
                                @else
                                    &#x25A2; Poliklinik RSUD Waled
                                @endif <br>
                                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengobatan_lanjutan == 'RS Lain' : null)
                                    &#x2611; RS Lain
                                @else
                                    &#x25A2; RS Lain
                                @endif <br>
                                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengobatan_lanjutan == 'Puskesmas' : null)
                                    &#x2611; Puskesmas
                                @else
                                    &#x25A2; Puskesmas
                                @endif <br>
                                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengobatan_lanjutan == 'Dokter Praktek' : null)
                                    &#x2611; Dokter Praktek
                                @else
                                    &#x25A2; Dokter Praktek
                                @endif <br>
                                <pre>{{ $kunjungan->erm_ranap->pengobatan_lanjutan_text ?? '' }}</pre>
                            </td>
                            <td width="50%">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Tgl Kontrol</td>
                                        <td>:</td>
                                        <td><b>{{ $kunjungan->erm_ranap->tanggal_kontrol ?? '....' }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Kontrol Ke</td>
                                        <td>:</td>
                                        <td><b>{{ $kunjungan->erm_ranap->kontrol_ke ?? '....' }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Diet</td>
                                        <td>:</td>
                                        <td><b>{{ $kunjungan->erm_ranap->diet ?? '....' }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Latihan</td>
                                        <td>:</td>
                                        <td><b>{{ $kunjungan->erm_ranap->latihan ?? '....' }}</b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                </td>
                <td width="50%">
                    <b>Instruksi Pulang :</b><br>
                    <pre>{{ $kunjungan->erm_ranap->instruksi_pulang ?? '....' }}</pre>

                    <b>Segera kembali ke Rumah Sakit, langsung ke IGD jika terjadi :</b><br>
                    {{ $kunjungan->erm_ranap->kembali_jika ?? '....' }}
                </td>
            </tr>
            <tr class="text-center">
                <td width="50%">
                    <br>
                    Pasien / Keluarga Pasien <br>
                    Yang Menerima Penjelasan
                    @if ($kunjungan->erm_ranap)
                        @if ($kunjungan->erm_ranap->ttdkeluarga)
                            <br>
                            <img width="200" height="100" src="{{ $kunjungan->erm_ranap->ttdkeluarga->image }}"
                                alt="Red dot" />
                            <br>
                        @else
                            <br>
                            <br>
                            <br>
                            <br>
                        @endif
                    @else
                        <br>
                        <br>
                        <br>
                        <br>
                    @endif
                    <b><u>{{ $kunjungan->erm_ranap->nama_keluarga ?? 'Keluarga Pasien' }}</u></b><br>
                    NIK. {{ $kunjungan->erm_ranap->nik_keluarga ?? '' }}
                </td>
                <td width="50%">
                    Waled, {{ now()->format('d F y h:i:s') }} <br>
                    Dokter Penanggung Jawab Pelayanan <br>
                    (DPJP)
                    @if ($kunjungan->erm_ranap)
                        @if ($kunjungan->erm_ranap->ttddokter)
                            <br>
                            <img width="200" height="100" src="{{ $kunjungan->erm_ranap->ttddokter->image }}"
                                alt="Red dot" />
                            <br>
                        @else
                            <br>
                            <br>
                            <br>
                            <br>
                        @endif
                    @else
                        <br>
                        <br>
                        <br>
                        <br>
                    @endif
                    <b><u>{{ $kunjungan->dokter->nama_paramedis }}</u></b><br>
                    SIP. {{ $kunjungan->dokter->sip_dr ?? '..................' }}
                </td>
            </tr>
        </table>
    @else
        <table class="table table-sm table-bordered" style="font-size: 11px">
            <table class="table table-sm table-bordered" style="font-size: 11px">
                <tr style="background-color: #ffc107">
                    <td width="100%" class="text-center">
                        <b>RINGKASAN PASIEN PULANG</b>
                    </td>
                </tr>
            </table>
            <tr>
                <td width="100%" class="text-center">
                    <b>Belum Diisi</b>
                </td>
            </tr>
        </table>
    @endif
@endsection
