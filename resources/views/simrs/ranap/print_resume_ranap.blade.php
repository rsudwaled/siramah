<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Ranap {{ $pasien->nama_px }}</title>
    <link rel="stylesheet" href="path/to/bootstrap-grid.min.css">
    <link rel="stylesheet" href="{{ asset('medilab/assets/vendor/bootstrap/css/bootstrap-grid.min.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        .page {
            width: 21cm;
            height: 33cm;
            margin: 1cm auto;
            padding: 1cm;
            /* border: 1px solid #ccc; */
            background-color: white;
            overflow: hidden;
            page-break-after: always;
            position: relative;
            border: 1px solid black !important;
        }

        .border {
            border: 1px solid black !important;
        }

        .text-center {
            text-align: center !important;
        }

        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 13px;
        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f0f0f0;
            text-align: center;
            padding: 0.2cm;
            border: 1px solid black !important;
        }

        @media print {
            body {
                margin: 0;
            }

            .page {
                margin: 0;
                border: initial;
            }

            pre {
                border: none;
                outline: none;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 13px;
            }

            .footer {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                background-color: #f0f0f0;
                text-align: center;
                padding: 0.2cm;
            }

            /* Hide the button in print mode */
            button {
                display: none !important;
            }
        }

        /* Style for the Print button */
        button {
            display: block;
            margin: 0 auto;
            /* Center the button horizontally */
            margin-top: 1cm;
            /* Add some top margin for separation */
            padding: 0.5cm 1cm;
            /* Padding for a better appearance */
            font-size: 16px;
            /* Adjust font size */
            background-color: #00cc00;
            /* Green color */
            color: white;
            /* Text color */
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Konten Halaman 1 -->
    <div class="page">
        <div class="row" style="font-size: 13px">
            <div class="col-md-2 border border-dark">
                <div class="m-2  text-center">
                    <img class="" src="{{ asset('vendor/adminlte/dist/img/rswaled.png') }}" style="height: 70px">
                </div>
            </div>
            <div class="col-md-6  border border-dark">
                <b>PEMERINTAHAN KABUPATEN CIREBON</b><br>
                <b>RUMAH SAKIT UMUM DAERAH WALED</b><br>
                Jl. Prabu Kian Santang No. 4 Kab. Cirebon Jawa Barat 45151<br>
                www.rsudwaled.id - 0823 1169 6919 - (0231) 8850943
            </div>
            <div class="col-md-4  border border-dark">
                <div class="row">
                    <div class="p-0">
                        No RM : <b>{{ $pasien->no_rm }}</b> <br>
                        Nama : <b>{{ $pasien->nama_px }}</b> <br>
                        Tgl Lahir : <b>{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('d, F Y') }}
                            ({{ \Carbon\Carbon::parse($pasien->tgl_lahir)->diffInYears($kunjungan->tgl_masuk) }}
                            tahun)</b> <br>
                        Kelamin : <b>{{ $pasien->jenis_kelamin }}</b>

                    </div>
                </div>
            </div>
            <div class="col-md-12 border border-dark text-center bg-warning">
                <b>Ringkasan Pasien Pulang</b>
            </div>
            <div class="col-md-12 border border-dark">
                <div class="row">
                    <div class="col-md-8">
                        <b>Tanggal Masuk : </b>
                        {{ $kunjungans->first()->tgl_masuk ? Carbon\Carbon::parse($kunjungans->first()->tgl_masuk)->format('d F Y H:i:s') : '-' }}
                        <br>
                        <b>Tanggal Keluar : </b>
                        {{ $kunjungan->tgl_keluar ? Carbon\Carbon::parse($kunjungan->tgl_keluar)->format('d F Y H:i:s') : '-' }}
                        <br>
                        <b>Lama Rawat : </b>
                        {{ $lama_rawat }} hari
                    </div>
                    {{-- <div class="col-md-4"></div> --}}
                    <div class="col-md-4">
                        <b>Ruangan Asal : </b> {{ $kunjungans->first()->unit->nama_unit ?? '-' }} <br>
                        <b>Ruangan Inap : </b> {{ $kunjungan->unit->nama_unit ?? '-' }} <br>
                        <b>No SEP : </b> {{ $kunjungan->no_sep ?? '-' }}
                    </div>
                </div>
            </div>
            <div class="col-md-12 border border-dark">
                <b>Ringkasan Perawatan : </b><br>
                <pre>{{ $kunjungan->erm_ranap->ringkasan_perawatan ?? '....' }}</pre>
                <b>Riwayat Penyakit : </b><br>
                <pre>{{ $kunjungan->erm_ranap->riwayat_penyakit ?? '....' }}</pre>
                <b>Indikasi Rawat Inap : </b><br>
                <pre>{{ $kunjungan->erm_ranap->indikasi_ranap ?? '....' }}</pre>
            </div>
            <div class="col-md-12  border border-dark">
                <b>Suhu Badan : </b> {{ $kunjungan->erm_ranap->suhu ?? '....' }} Celcius &emsp;
                <b>Tekanan Darah : </b> {{ $kunjungan->erm_ranap->tensi_darah ?? '....' }} mmHg &emsp;
                <b>Denyut Nadi : </b> {{ $kunjungan->erm_ranap->denyut_nadi ?? '....' }} xs &emsp;
                <b>Pernapasan : </b> {{ $kunjungan->erm_ranap->pernapasan ?? '....' }} xs &emsp;
                <b>Berat Badan Bayi : </b> {{ $kunjungan->erm_ranap->berat_badan ?? '....' }} kg &emsp;<br>
                <b>Pemeriksaan Fisik : </b><br>
                <pre>{{ $kunjungan->erm_ranap->pemeriksaan_fisik ?? '....' }}</pre>
            </div>
            <div class="col-md-12  border border-dark">
                <b>Pemeriksaan Laboratorium : </b><br>
                <pre>{{ $kunjungan->erm_ranap->catatan_laboratorium ?? '....' }}</pre>
            </div>
            <div class="col-md-12  border border-dark">
                <b>Pemeriksaan Radiologi : </b><br>
                <pre>{{ $kunjungan->erm_ranap->catatan_radiologi ?? '....' }}</pre>
            </div>
            <div class="col-md-12  border border-dark">
                <b>Pemeriksaan Penunjang Lainnya : </b><br>
                <pre>{{ $kunjungan->erm_ranap->catatan_penunjang ?? '....' }}</pre>
            </div>
            <div class="col-md-12  border border-dark">
                <b>Hasil Konsultasi : </b><br>
                <pre>{{ $kunjungan->erm_ranap->hasil_konsultasi ?? '....' }}</pre>
            </div>
            <div class="col-md-12  border border-dark">
                <b>Pemeriksaan SHK : </b> &emsp;
                Dilakukan :
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pemeriksaan_shk == 'Ya' : null)
                    &#x1F5F9; Ya
                @else
                    &#x25A2; Ya
                @endif/
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pemeriksaan_shk == 'Tidak' : null)
                    &#x1F5F9; Tidak
                @else
                    &#x25A2; Tidak
                @endif &emsp;
                Diambil dari :
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengambilan_shk == 'Tumit' : null)
                    &#x1F5F9; Tumit
                @else
                    &#x25A2; Tumit
                @endif/
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengambilan_shk == 'Vena' : null)
                    &#x1F5F9; Vena
                @else
                    &#x25A2; Vena
                @endif&emsp;
                Tgl Pengambilan :
                @if ($kunjungan->erm_ranap)
                    {{ $kunjungan->erm_ranap->tanggal_shk ? \Carbon\Carbon::parse($kunjungan->erm_ranap->tanggal_shk)->format('d F Y') : '....' }}
                @endif
                &emsp;
            </div>
            <div class="col-md-12  border border-dark">
                <b>Diagnosa Masuk : </b><br>
                <pre>{{ $kunjungan->erm_ranap->diagnosa_masuk ?? '....' }}</pre>
            </div>
            <div class="col-md-12  border border-dark">
                <div class="row">
                    <div class="col-md-8">
                        <b>Diagnosa Utama : </b><br>
                        <pre>{{ $kunjungan->erm_ranap->diagnosa_utama ?? '....' }}</pre>
                    </div>
                    <div class="col-md-4">
                        <b>ICD 10</b><br>
                        {{ $kunjungan->erm_ranap->icd10_utama ? explode('|', $kunjungan->erm_ranap->icd10_utama)[0] : '' }}
                    </div>
                </div>
            </div>
            <div class="col-md-12  border border-dark">
                <div class="row">
                    <div class="col-md-8">
                        <b>Diagnosa Sekunder : </b><br>
                        <pre>{{ $kunjungan->erm_ranap->diagnosa_sekunder ?? '' }}</pre>
                    </div>
                    <div class="col-md-4">
                        <b>ICD 10</b><br>
                        @if ($kunjungan->erm_ranap)
                            @if ($kunjungan->erm_ranap->icd10_sekunder)
                                @foreach (json_decode($kunjungan->erm_ranap->icd10_sekunder) as $item)
                                    {{ explode('|', $item)[0] }} <br>
                                @endforeach
                            @endif
                        @endif
                        {{-- <pre>{{ $kunjungan->erm_ranap->icd10_sekunder ?? '' }}</pre> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-12  border border-dark">
                <div class="row">
                    <div class="col-md-8">
                        <b>Tindakan Operasi :</b><br>
                        <pre>{{ $kunjungan->erm_ranap->tindakan_operasi ?? '....' }}</pre>
                    </div>
                    <div class="col-md-4">
                        <b>ICD 9 CM</b><br>
                        @if ($kunjungan->erm_ranap)
                            @if ($kunjungan->erm_ranap->icd9_operasi)
                                @foreach (json_decode($kunjungan->erm_ranap->icd9_operasi) as $item)
                                    {{ explode('|', $item)[0] }} <br>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12  border border-dark">
                <b>Tgl Operasi : </b>{{ $kunjungan->erm_ranap->tanggal_operasi ?? '....' }}&emsp;
                <b>Waktu Mulai : </b>{{ $kunjungan->erm_ranap->awal_operasi ?? '....' }}&emsp;
                <b>Waktu Selesai : </b>{{ $kunjungan->erm_ranap->akhir_operasi ?? '....' }}&emsp;
            </div>
            <div class="col-md-12  border border-dark">
                <div class="row">
                    <div class="col-md-8">
                        <b>Tindakan / Prosedur :</b><br>
                        <pre>{{ $kunjungan->erm_ranap->tindakan_prosedur ?? '....' }}</pre>
                    </div>
                    <div class="col-md-4">
                        <b>ICD 9 CM</b><br>
                        @if ($kunjungan->erm_ranap)
                            @if ($kunjungan->erm_ranap->icd9_prosedur)
                                @foreach (json_decode($kunjungan->erm_ranap->icd9_prosedur) as $item)
                                    {{ explode('|', $item)[0] }} <br>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12  border border-dark">
                <b>Pasang Ventilator</b>&emsp;
                <b>Waktu Intubasi : </b> {{ $kunjungan->erm_ranap->intubasi ?? '....' }} WIB&emsp;
                <b>Waktu Extubasi : </b> {{ $kunjungan->erm_ranap->extubasi ?? '....' }} WIB&emsp;
            </div>
        </div>
        <div class="footer">Halaman 1 Dari 2 | Resume Rawat Inap {{ $pasien->no_rm }} {{ $pasien->nama_px }}</div>
    </div>
    <div class="page">
        <div class="row" style="font-size: 13px">
            <div class="col-md-12  border border-dark">
                <b>Pengobatan Selama Dirawat :</b> <br>
                <div class="row">
                    <div class="col-md-6">
                        <table>
                            <thead>
                                <tr class="border-bottom border-dark">
                                    <th>Nama Obat</th>
                                    <th>Keterangan</th>
                                    {{-- <th>Jml</th>
                                <th>Aturan Pakai</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($obat2[0] as $item)
                                    <tr class="border-bottom border-dark">
                                        <td>{{ $item['nama_barang'] }} </td>
                                        <td>{{ $item['keterangan'] }} </td>
                                        {{-- <td>{{ $item['jumlah_layanan'] }} {{ $item['satuan_barang'] }}</td>
                                    <td>{{ $item['aturan_pakai'] }} </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <thead>
                                <tr class="border-bottom border-dark">
                                    <th>Nama Obat</th>
                                    <th>Keterangan</th>
                                    {{-- <th>Jml</th>
                                <th>Aturan Pakai</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($obat2[1] as $item)
                                    <tr class="border-bottom border-dark">
                                        <td>{{ $item['nama_barang'] }} </td>
                                        <td>{{ $item['keterangan'] }} </td>
                                        {{-- <td>{{ $item['jumlah_layanan'] }} {{ $item['satuan_barang'] }}</td>
                                    <td>{{ $item['aturan_pakai'] }} </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4  border border-dark">
                <b>Cara Keluar :</b><br>
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->cara_pulang == 'Sembuh / Perbaikan' : null)
                    &#x1F5F9; Sembuh / Perbaikan
                @else
                    &#x25A2; Sembuh / Perbaikan
                @endif <br>
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->cara_pulang == 'Pindah RS' : null)
                    &#x1F5F9; Pindah RS
                @else
                    &#x25A2; Pindah RS
                @endif <br>
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->cara_pulang == 'Pulang Paksa' : null)
                    &#x1F5F9; Pulang Paksa
                @else
                    &#x25A2; Pulang Paksa
                @endif <br>
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->cara_pulang == 'Meninggal' : null)
                    &#x1F5F9; Meninggal
                @else
                    &#x25A2; Meninggal
                @endif <br>
                <pre>{{ $kunjungan->erm_ranap->cara_pulang_text ?? '' }}</pre>
            </div>
            <div class="col-md-4  border border-dark">
                <b>Kondisi Pulang :</b><br>
                <pre>{{ $kunjungan->erm_ranap->kondisi_pulang ?? '....' }}</pre>
                <b>Keadaan Umum :</b><br>
                <pre>{{ $kunjungan->erm_ranap->kondisi_umum ?? '....' }}</pre>
                <b>Kesadaran :</b> {{ $kunjungan->erm_ranap->kesadaran ?? '....' }}<br>
                <b>Tekanan Darah :</b> {{ $kunjungan->erm_ranap->tensi_darah ?? '....' }}<br>
                <b>Nadi :</b> {{ $kunjungan->erm_ranap->denyut_nadi ?? '....' }}<br>
            </div>
            <div class="col-md-4  border border-dark">
                <b>Pengobatan Dilanjutkan :</b><br>
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengobatan_lanjutan == 'Poliklinik RSUD Waled' : null)
                    &#x1F5F9; Poliklinik RSUD Waled
                @else
                    &#x25A2; Poliklinik RSUD Waled
                @endif <br>
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengobatan_lanjutan == 'RS Lain' : null)
                    &#x1F5F9; RS Lain
                @else
                    &#x25A2; RS Lain
                @endif <br>
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengobatan_lanjutan == 'Puskesmas' : null)
                    &#x1F5F9; Puskesmas
                @else
                    &#x25A2; Puskesmas
                @endif <br>
                @if ($kunjungan->erm_ranap ? $kunjungan->erm_ranap->pengobatan_lanjutan == 'Dokter Praktek' : null)
                    &#x1F5F9; Dokter Praktek
                @else
                    &#x25A2; Dokter Praktek
                @endif <br>
                <pre>{{ $kunjungan->erm_ranap->pengobatan_lanjutan_text ?? '' }}</pre>
            </div>
            <div class="col-md-6  border border-dark">
                <b>Instruksi Pulang :</b><br>
                <pre>{{ $kunjungan->erm_ranap->instruksi_pulang ?? '....' }}</pre>
                <b>Tgl Kontrol : </b> {{ $kunjungan->erm_ranap->tanggal_kontrol ?? '....' }} &emsp;
                <b>Kontrol Ke : </b>{{ $kunjungan->erm_ranap->kontrol_ke ?? '....' }}<br>
                <b>Diet : </b> {{ $kunjungan->erm_ranap->diet ?? '....' }}<br>
                <b>Latihan : </b> {{ $kunjungan->erm_ranap->latihan ?? '....' }}<br>
            </div>
            <div class="col-md-6  border border-dark">
                <b>Segera kembali ke Rumah Sakit, langsung ke IGD jika terjadi :</b><br>
                {{ $kunjungan->erm_ranap->kembali_jika ?? '....' }}
            </div>
            <div class="col-md-6 text-center border border-dark">
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
            </div>
            <div class="col-md-6 text-center border border-dark">
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
            </div>
        </div>
        <div class="footer">Halaman 2 Dari 2 | Resume Rawat Inap {{ $pasien->no_rm }} {{ $pasien->nama_px }}</div>
    </div>

    <!-- Tombol Print -->
    <button onclick="printPage()">Print</button>

    <script>
        function printPage() {
            window.print();
        }
    </script>
</body>

</html>
