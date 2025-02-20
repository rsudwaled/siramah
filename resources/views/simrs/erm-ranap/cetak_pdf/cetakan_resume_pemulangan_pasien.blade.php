<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
    </title>
    <style>
        @page {
            size: 210mm 330mm;
            /* Ukuran kertas F4 */
            margin-left: 15mm;
            /* Margin kertas */
            margin-right: 5mm;
            /* Margin kertas */
            margin-top: 5mm;
            /* Margin kertas */
            counter-reset: page;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .table {
            margin-bottom: 0px;
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered {
            border: 1px solid black !important;
            padding: 0;
            margin: 0;
        }

        /* Mendefinisikan header untuk diposisikan pada halaman pertama */
        header {
            position: running(header);
        }

        .content {
            margin-top: 21mm;
            padding-top: 35px;
            width: 100%;
        }

        /* Pengaturan header secara global pada semua halaman */
        .page-header {
            display: block;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: right;
            font-size: 11px;
            border-top: 1px solid #d8d8d8;
        }

        /* Menambahkan nomor halaman pada footer */
        footer:after {
            content: "Halaman " counter(page) " dari 2" ;
        }

        /* Pastikan header tetap di atas halaman */
        .page-break {
            page-break-before: always;
        }

        /* Untuk mendefinisikan style header secara keseluruhan */
        .page-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            padding: 0px;
            background-color: white;
            z-index: 1000;
            padding-top: 25px;
        }
        .page-number:after {
            content: "RM.15.0" counter(page, decimal)"-RI/Rev.03/24" ;
        }
        .page-footer {
            margin-bottom: -45px;
            position: fixed;
            bottom: 10px;
            left: 0;
            width: 100%;
            text-align: right;
            font-size: 11px;
        }
    </style>

<body style="font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif">
    @if (!empty($resume))
        <header class="page-header">
            {{-- <div class="col-12" style="font-size: 11px; text-align:right"><strong>RM.15.01-RI/Rev.03/24</strong></div> --}}
            <div class="col-12" style="font-size: 11px; text-align:right"><strong><span class="page-number"></span></strong></div>
            <table class="table table-sm table-bordered" style="font-size: 11px">
                <tr style="margin: 0px; padding:0px;">
                    <td width="10%"
                        style="border-right: 1px solid black; margin:0px; padding:0px; text-align:center">
                        <img class="" src="{{ public_path('vendor/adminlte/dist/img/rswaled.png') }}"
                            style="height: 50px">
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
                    <tr style="border-bottom: 1px solid black;">
                        <td style="margin: 0; padding:2px; border-right: 1px solid black;">
                            Tgl Masuk: {{ $resume->tgl_masuk ? \Carbon\Carbon::parse($resume->tgl_masuk)->format('d-m-Y') :'' }}
                        </td>
                        <td style="margin: 0; padding:2px; border-right: 1px solid black;">
                            Jam Masuk: {{ $resume->jam_masuk ?? '' }} WIB
                        </td>
                        <td style="margin: 0; padding:2px;">
                            Ruang Rawat: {{ strtoupper($resume->ruang_rawat_masuk ?? '') }}
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid black;">
                        <td style="margin: 0; padding:2px; border-right: 1px solid black;">
                            Tgl Keluar: {{ $resume->tgl_keluar ? \Carbon\Carbon::parse($resume->tgl_keluar)->format('d-m-Y') :'' }}
                        </td>
                        <td style="margin: 0; padding:2px; border-right: 1px solid black;">
                            Jam Keluar: {{ $resume->jam_keluar ?? '' }} WIB
                        </td>
                        <td style="margin: 0; padding:2px; width:28%;">
                            Ruang Rawat: {{ strtoupper($resume->ruang_rawat_keluar ?? '') }}
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid black;">
                        <td style="margin: 0; padding:2px; border-right: 1px solid black;">
                            Rawat Intensif: {{ $resume->rawat_intensif ?? '-' }} Hari <br>
                            Lama Rawat: {{ $resume->lama_rawat ?? '-' }} Hari
                        </td>
                        <td style="margin: 0; padding:2px; border-right: 1px solid black;">
                            Berat Badan Bayi Lahir < 1 Bulan: {{ $resume->bb_bayi_lahir ?? '.......' }} Kg </td>
                        <td style="margin: 0; padding:2px;">Gravida :{{ $resume->grafida ?? '.......' }} minggu</td>
                    </tr>
                    <tr style="border-bottom: 1px solid black;">
                        <td colspan="3" style="margin: 0; padding:2px; height:auto;">
                            <span style="font-size: 12px; font-weight: bold;">Ringkasan Perawatan:</span> <br>
                            {{ $resume->ringkasan_perawatan ?? '' }}
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid black;">
                        <td colspan="3" style="margin: 0; padding:2px; height:auto;">
                            <span style="font-size: 12px; font-weight: bold;">Riwayat Penyakit:</span> <br>
                            {{ $resume->riwayat_penyakit ?? '' }}
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid black;">
                        <td colspan="3" style="margin: 0; padding:2px; height:auto;">
                            <span style="font-size: 12px; font-weight: bold;">Indikasi Rawat Inap:</span> <br>
                            {{ $resume->indikasi_ranap ?? '' }}

                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid black;">
                        <td colspan="3" style="margin: 0; padding:2px; height:auto;">
                            <span style="font-size: 12px; font-weight: bold;">Pemeriksaan Fisik:</span> <br>
                            {{-- {{ $resume->pemeriksaan_fisik ?? '' }} --}}
                            @php
                                $fisik = $resume->pemeriksaan_fisik ?? [];
                                $pemeriksaanFisik = is_string($fisik) ? explode('||', $fisik) : (array) $fisik;
                            @endphp
                            @foreach ($pemeriksaanFisik as $dataPemeriksaan)
                                <p style="margin: 0px;padding:0px;">{{ $dataPemeriksaan }}</p>
                            @endforeach
                        </td>
                    </tr>
                    @if ($umur == 0 || $umur < 30 || $resume->pemeriksaan_shk_ya =='on' || $resume->pemeriksaan_shk_tidak=='on')
                        <tr>
                            <td colspan="3"
                                style="margin: 0; padding:2px; height:40px; border-bottom: 1px solid black; border-top: 1px solid black;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td
                                            style="margin: 0; padding:2px; text-align:center; border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;">
                                            Pemeriksaan SHK</td>
                                        <td
                                            style="margin: 0; padding:2px; text-align:center; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black;border-right: 1px solid black;">
                                            APGAR SCORE</td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="margin: 0; padding:2px; width: 65%; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black;border-right: 1px solid black;">
                                            Dilakukan :
                                            {{ $resume->pemeriksaan_shk_ya ?? $resume->pemeriksaan_shk_tidak
                                                ? ($resume->pemeriksaan_shk_ya == 'on'
                                                    ? 'pemeriksaan_shk_ya'
                                                    : 'pemeriksaan_shk_tidak')
                                                : '-' }}
                                            <br>
                                            Diambil dari :
                                            {{ $resume->diambil_dari_tumit ?? $resume->diambil_dari_vena
                                                ? ($resume->diambil_dari_tumit == 'on'
                                                    ? 'diambil_dari_tumit'
                                                    : 'diambil_dari_vena')
                                                : '-' }}
                                            <br>
                                            Tgl Pengambilan : {{ $resume->tgl_pengambilan_shk != null ? \Carbon\Carbon::parse($resume->tgl_pengambilan_shk)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td
                                            style="margin: 0; padding:2px; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black;border-right: 1px solid black;">
                                            <strong>1 Menit</strong> ||
                                            <strong>A:</strong> {{ $resume->a_1menit ?? '0' }} <strong>P:</strong>
                                            {{ $resume->ap_1menit ?? '0' }} <strong>G:</strong>
                                            {{ $resume->apg_1menit ?? '0' }}
                                            <strong>A:</strong> {{ $resume->apga_1menit ?? '0' }} <strong>R:</strong>
                                            {{ $resume->apgar_1menit ?? '0' }} : <strong>TOTAL :
                                                {{ $resume->total_apgar_1menit ?? '0' }}</strong> <br>
                                            <strong>5 Menit</strong> ||
                                            <strong>A:</strong> {{ $resume->a_5menit ?? '0' }} <strong>P:</strong>
                                            {{ $resume->ap_5menit ?? '0' }} <strong>G:</strong>
                                            {{ $resume->apg_5menit ?? '0' }}
                                            <strong>A:</strong> {{ $resume->apga_5menit ?? '0' }} <strong>R:</strong>
                                            {{ $resume->apgar_5menit ?? '0' }} : <strong>TOTAL :
                                                {{ $resume->total_apgar_5menit ?? '0' }}</strong>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td colspan="3" style="margin:0px; padding:0px;">
                            <table style="width: 100%; border-collapse: collapse; border:none;">
                                <tr style="border:1px solid black">
                                    <td
                                        style="border:none; width: 5px; display: flex; justify-content: center; align-items: center;padding:5px;">
                                        <div style="transform: rotate(90deg); white-space: nowrap; font-size: 12px;">
                                            <span>PEMERIKSAAN PENUNJANG</span>
                                        </div>
                                    </td>
                                    <td style="margin:0px; padding:2px;">
                                        <div style="min-height: 180px;">
                                            <table
                                                style="width: 100%; height:50px; border-collapse: collapse; margin:0px; padding:0px;">
                                                <tr>
                                                    <td
                                                        style="width:15%; margin: 0; padding:2px; border-left:1px solid black; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                        Laboratorium</td>
                                                    <td colspan="2"
                                                        style="margin: 0; padding:2px; border-bottom:1px solid black; border-right:1px solid black; border-top:1px solid black;">
                                                        @php
                                                            $lab = $resume->penunjang_lab ?? [];
                                                            $laboratorium = is_string($lab)
                                                                ? explode('||', $lab)
                                                                : (array) $lab;
                                                        @endphp
                                                        @foreach ($laboratorium as $hasilLab)
                                                            <p style="margin: 0px;padding:0px;">{{ $hasilLab }}</p>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="text-align: left; vertical-align: top; margin: 0; padding:2px;border-left:1px solid black; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                        Radiologi</td>
                                                    <td colspan="2"
                                                        style="text-align: left; vertical-align: top; margin: 0; padding:2px; height:100px; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                        @php
                                                            $rad = $resume->penunjang_radiologi ?? [];
                                                            $radiologi = is_string($rad)
                                                                ? explode('||', $rad)
                                                                : (array) $rad;
                                                        @endphp

                                                        @foreach ($radiologi as $hasilRadiologi)
                                                            <p style="margin: 0px;padding:0px;">{{ $hasilRadiologi }}
                                                            </p>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="margin: 0; padding:2px;border-left:1px solid black; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                        Penunjang Lainnya</td>
                                                    <td colspan="2"
                                                        style="margin: 0; padding:2px; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                        {{ $resume->penunjang_lainnya ?? '' }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="margin: 0; padding:3px; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                            <strong style="margin: 0.5rem 0;">Hasil Konsultasi</strong>
                        </td>
                        <td colspan="2"
                            style="margin: 0; padding:3px;border-bottom:1px solid black; border-top:1px solid black; ">
                            {{ $resume->hasil_konsultasi ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="margin: 0; padding:3px; border-right:1px solid black; border-bottom:1px solid black;">
                            <strong style="margin: 0.5rem 0;">Diagnosa Masuk</strong>
                        </td>
                        <td colspan="2" style="margin: 0; padding:3px; border-bottom:1px solid black;">
                            {{ $resume->diagnosa_masuk ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="margin:0px; padding:0px;">
                            <table style="width: 100%; border-collapse: collapse; border:none;">
                                <tr style="border:1px solid black">
                                    <td
                                        style="border:none; border-right:1px solid black; width: 5px; display: flex; justify-content: center; align-items: center; height:100px; padding:5px;">
                                        <div style="transform: rotate(90deg); white-space: nowrap; font-size: 10px;">
                                            <span>DIAGNOSA KELUAR</span>
                                        </div>
                                    </td>
                                    <td style="height: auto; margin:0px; padding:2px;">
                                        <table
                                            style="width: 100%; height:20px; border-collapse: collapse; margin:0px; padding:0px;">
                                            <tr>
                                                @php
                                                    if (
                                                        !empty($resume->diagnosa_utama) &&
                                                        strpos($resume->diagnosa_utama, ' - ') !== false
                                                    ) {
                                                        $diagutama = explode(' - ', $resume->diagnosa_utama);
                                                    } else {
                                                        $diagutama = [null, null]; // Set default jika diagnosa tidak ada atau formatnya salah
                                                    }
                                                @endphp
                                                <td
                                                    style="width: 16%; margin: 0; padding:2px; border-left:1px solid black; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                    Diagnosa Utama</td>
                                                <td
                                                    style="margin: 0; padding:2px; border-bottom:1px solid black; border-right:1px solid black; border-top:1px solid black;">
                                                    {{-- {{ $diagutama[1] ?? 'Tidak Diketahui' }} --}}
                                                    {{ $resume->diagnosa_utama_dokter ?? '' }}
                                                </td>
                                                <td
                                                    style="width:29%;margin: 0; padding:2px; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                    Kode ICD X:
                                                    @php
                                                        $codeDiagUtama = !empty($resume->diagnosa_utama)
                                                            ? explode(' - ', $resume->diagnosa_utama)
                                                            : null;
                                                    @endphp

                                                    @if ($codeDiagUtama && isset($codeDiagUtama[0]))
                                                        {{ $codeDiagUtama[0] }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="text-align: left; vertical-align: top; margin: 0; padding:2px;border-left:1px solid black; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                    Diagnosa Sekunder</td>
                                                <td
                                                    style="text-align: left; vertical-align: top; margin: 0; padding:2px; height:50px; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                    @php
                                                        $sekunder =
                                                            isset($resume) && isset($resume->diagnosa_sekunder_dokter)
                                                                ? explode('|', $resume->diagnosa_sekunder_dokter)
                                                                : [];
                                                        $coderIcd = $resume->diagnosaSekunder ?? null;
                                                    @endphp
                                                    @foreach ($sekunder as $diagSekunder)
                                                        . {{ $diagSekunder }} <br>
                                                    @endforeach
                                                </td>
                                                <td
                                                    style="text-align: left; vertical-align: top; margin: 0; padding:2px;  border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                    Kode ICD X: <br>
                                                    @if (!empty($coderIcd))
                                                        @foreach ($coderIcd as $icd)
                                                            -{{ $icd->kode_diagnosa }} <br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="margin: 0; padding:2px;border-left:1px solid black; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                    Komplikasi</td>
                                                <td colspan="2"
                                                    style="margin: 0; padding:2px; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
                                                    {{ $resume->komplikasi ?? '' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="margin: 0; padding:1px; height:auto; border:1px solid black;" colspan="2">
                            <strong style="margin: 0.5rem 0;">Tindakan Operasi</strong>
                        </td>
                        <td style="width:19%; margin: 0; padding:1px; border:1px solid black;">
                            ICD9 CM:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="margin: 0; padding:1px; border:1px solid black;">
                            @php
                                $operasi = explode('|', $resume->tindakan_operasi_dokter);
                                $codeOperasi = $resume->tindakanOperasiCodes ?? null;
                            @endphp
                            @foreach ($operasi as $tindakanOperasi)
                                <span style="padding-top: 1px; display: block; ">. {{ $tindakanOperasi }}</span>
                            @endforeach
                        </td>
                        <td style="margin: 0; padding:1px; border:1px solid black;">
                            @if (!empty($codeOperasi))
                                @foreach ($codeOperasi as $icd)
                                    <span style="padding-top: 1px; display: block;">- {{ $icd->kode_tindakan }}</span>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 19%; margin: 0; padding:1px; border:1px solid black;">
                            <div class="form-group">
                                <strong style="margin: 0.5rem 0;">Tgl Operasi:</strong>
                                {{ $resume->tgl_operasi ?? '' }}
                            </div>
                        </td>
                        <td style="margin: 0; padding:1px; border:1px solid black;">
                            <div class="form-group">
                                <strong style="margin: 0.5rem 0;">Waktu Mulai:</strong>
                                {{ $resume->waktu_operasi_mulai ? $resume->waktu_operasi_mulai . ' WIB' : '' }}
                            </div>
                        </td>
                        <td style="margin: 0; padding:1px; border:1px solid black;">
                            <div class="form-group">
                                <strong style="margin: 0.5rem 0;">Waktu Selesai:</strong>
                                {{ $resume->waktu_operasi_selesai ? $resume->waktu_operasi_selesai . ' WIB' : '' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="margin: 0; padding:1px; border:1px solid black;">
                            <strong style="margin: 0.5rem 0;">Sebab Kematian</strong>
                        </td>
                        <td colspan="2" style="margin: 0; padding:1px; border:1px solid black;">
                            {{ $resume->sebab_kematian ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="margin: 0; padding:1px; height:auto; border:1px solid black;" colspan="2">
                            <strong style="margin: 0.5rem 0;">Tindakan / Prosedure</strong>
                        </td>
                        <td style="margin: 0; padding:1px; border:1px solid black;">
                            ICD9 CM:
                        </td>
                    </tr>
                    <tr>
                        {{-- <td colspan="2" style="margin: 0; padding:3px; border:1px solid black;">
                            @php
                                $prosedure = explode('|', $resume->tindakan_prosedure_dokter);
                                $codeProsedure = $resume->tindakanProsedureCodes ?? null;
                            @endphp
                            @foreach ($prosedure as $tindakanProsedure)
                                <span style="padding-top: 1px; display: block;">. {{ $tindakanProsedure }}</span>
                            @endforeach
                        </td>
                        <td style="margin: 0; padding:3px; border:1px solid black;">
                            @if (!empty($codeProsedure))
                                @foreach ($codeProsedure as $icd)
                                    <span style="padding-top: 1px; display: block;">-
                                        {{ $icd->kode_procedure }}</span>
                                @endforeach
                            @endif
                        </td> --}}
                        <td colspan="3">
                            <div>
                                @php
                                    $prosedure = explode('|', $resume->tindakan_prosedure_dokter);
                                    $codeProsedure = $resume->tindakanProsedureCodes ?? null;
                                    $tindakanProsedureCollect = collect($prosedure);
                                @endphp
                                @if ($tindakanProsedureCollect->isNotEmpty())
                                    @php
                                        $bagiTindakan = $tindakanProsedureCollect->chunk(10); // Membagi data menjadi potongan-potongan per 10 item
                                        $nomorUrut = 1; // Inisialisasi nomor urut
                                    @endphp
                                    <div>
                                        @foreach ($bagiTindakan as $index => $showData)
                                            <div style="height: auto; width: 48%; margin-right: 1%; margin-bottom: 2px; display: inline-block; vertical-align: top; box-sizing: border-box; page-break-inside: avoid;">
                                                <table style="font-size:10px; width: 100%; border-collapse: collapse; margin: 0; padding: 1px; border: 1px solid black; box-sizing: border-box; font-size: 11px;">
                                                    <thead>
                                                        <tr>
                                                            <th style="border: 1px solid black; vertical-align: middle; padding-left:1px;">No</th>
                                                            <th style="border: 1px solid black; text-align: left; width:75%; padding-left:1px;">Tindakan Prosedure</th>
                                                            <th style="border: 1px solid black; text-align: left;width:20%; padding-left:1px;">ICD9 CM</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($showData as $tindakanProsedure)
                                                            <tr>
                                                                <td style="border: 1px solid black; vertical-align: middle; font-size:9px; padding-left:1px; text-align:center;">
                                                                    {{ $nomorUrut++ }} <!-- Menampilkan nomor urut dan increment-->
                                                                </td>
                                                                <td style="border: 1px solid black; font-size:9px; padding-left:1px;">
                                                                    &nbsp;{{ $tindakanProsedure }}
                                                                </td>
                                                                <td style="border: 1px solid black; font-size:9px;"></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            @if (($index + 1) % 2 == 0)
                                                <div style="clear: both;"></div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div style="text-align: center;">
                                        Data tidak ditemukan.
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <footer class="page-footer">
        </footer>
        <div class="page-break content ">
            <table class="table table-bordered" style="width: 100%; font-size:11px;">
                <tbody>
                    <tr style="background-color: #ffc107; margin:0; border-bottom: 1px solid black;">
                        <td colspan="3" style="margin: 0; padding:5px; text-align:center;">
                            <b>RINGKASAN PASIEN PULANG</b><br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 0; width: 100%; box-sizing: border-box;">
                            <div class="col-12"
                                style="text-align: center;  paddng:4px;">
                                <strong>Pengobatan Selama Dirawat</strong>
                            </div>
                            <div>
                                @if ($riwayatObat->isNotEmpty())
                                    @php
                                        $chunks = $riwayatObat->chunk(10); // Membagi data menjadi potongan-potongan per 10 item
                                    @endphp
                                    <div style="page-break-inside: avoid;">
                                        @foreach ($chunks as $index => $chunk)
                                            <div
                                                style="height: auto; width: 48%; margin-right: 1%; margin-bottom: 2px; display: inline-block; vertical-align: top; box-sizing: border-box; page-break-inside: avoid;">
                                                <table
                                                    style="font-size:10px; width: 100%; border-collapse: collapse; margin: 0; padding: 2px; border: 1px solid black; box-sizing: border-box; font-size: 10px;">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                style="border: 1px solid black; padding: 2px; vertical-align: middle;">
                                                                No</th>
                                                            <th
                                                                style="border: 1px solid black; padding: 2px; text-align: left;">
                                                                Nama Obat</th>
                                                            <th
                                                                style="border: 1px solid black; padding: 2px; vertical-align: middle;">
                                                                Qty</th>
                                                            {{-- <th
                                                                style="border: 1px solid black; padding: 2px; vertical-align: middle;">
                                                                Dosis</th> --}}
                                                            <th
                                                                style="border: 1px solid black; padding: 2px; vertical-align: middle;">
                                                                Aturan Pakai</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($chunk as $obat)
                                                            @php
                                                                $aturanPakai = isset($obat['aturan_pakai'])
                                                                    ? explode('|', $obat['aturan_pakai'])
                                                                    : ['N/A', 'N/A'];
                                                                $dosis = trim($aturanPakai[0] ?? 'N/A');
                                                                $waktu = trim($aturanPakai[1] ?? 'N/A');
                                                            @endphp
                                                            <tr>
                                                                <td
                                                                    style="border: 1px solid black;  vertical-align: middle; font-size:9px; text-align:center;">
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td
                                                                    style="border: 1px solid black;  font-size:9px;">
                                                                    {{ $obat['nama_barang'] }}
                                                                </td>
                                                                <td
                                                                    style="border: 1px solid black;  vertical-align: middle; font-size:9px; text-align:center;">
                                                                    {{ $obat['qty'] }}
                                                                </td>
                                                                {{-- <td
                                                                    style="border: 1px solid black;  vertical-align: middle; font-size:9px;">

                                                                </td> --}}
                                                                <td
                                                                    style="border: 1px solid black;  vertical-align: middle; font-size:9px;">
                                                                    {{ $obat['aturan_pakai'] }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            @if (($index + 1) % 2 == 0)
                                                <div style="clear: both;"></div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div style="text-align: center;">
                                        Data tidak ditemukan.
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="height: auto; padding: 2px; width: 100%; box-sizing: border-box;">
                            <table
                                style="width: 100%; border-collapse: collapse; margin: 0;  border: 1px solid black; box-sizing: border-box; font-size: 10px;">
                                <thead>
                                    <tr>
                                        <th colspan="5">
                                            <strong style="margin: 0.5rem 0;">Obat Untuk Pulang</strong>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th
                                            style="border: 1px solid black;  vertical-align: middle; width:40%;">
                                            Nama Obat</th>
                                        <th
                                            style="border: 1px solid black;  vertical-align: middle; width:5%;">
                                            JUMLAH</th>
                                        <th
                                            style="border: 1px solid black;  vertical-align: middle; width:15%;">
                                            Dosis</th>
                                        <th
                                            style="border: 1px solid black;  vertical-align: middle; width:8%;">
                                            Frekuensi
                                        </th>
                                        <th style="border: 1px solid black;  vertical-align: middle;">Cara
                                            Pemberian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($obatPulang)
                                        @foreach ($obatPulang as $obat)
                                            <tr>
                                                <td
                                                    style="border: 1px solid black; padding: 1px; vertical-align: middle;">
                                                    {{ $obat->nama_obat }}</td>
                                                <td
                                                    style="border: 1px solid black; padding: 1px; vertical-align: middle; text-align:center;">
                                                    {{ $obat->jumlah }}</td>
                                                <td
                                                    style="border: 1px solid black; padding: 1px; vertical-align: middle;">
                                                    {{ $obat->dosis ?? '' }}</td>
                                                <td
                                                    style="border: 1px solid black; padding: 1px; vertical-align: middle; text-align:center;">
                                                    {{ $obat->frekuensi ?? '' }}</td>
                                                <td
                                                    style="border: 1px solid black; padding: 1px; vertical-align: middle;">
                                                    {{ $obat->cara_pemberian ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td style="padding: 2px; boder:1px solid black;">-</td>
                                            <td style="padding: 2px; boder:1px solid black;">-</td>
                                            <td style="padding: 2px; boder:1px solid black;">-</td>
                                            <td style="padding: 2px; boder:1px solid black;">-</td>
                                            <td style="padding: 2px; boder:1px solid black;">-</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="margin:0px; padding:1px; border:1px solid black;">
                            Cara Keluar:
                            @php
                                $cara_keluar = json_decode($resume->cara_keluar, true);
                                $cara_keluar_terpilih = array_filter($cara_keluar, fn($value) => $value == 'on');
                                $cara_keluar_terpilih = array_keys($cara_keluar_terpilih);
                                $keterangan_lain = $cara_keluar['cara_lainya'] ?? null;
                            @endphp
                            @if (count($cara_keluar_terpilih) > 0)
                                @foreach ($cara_keluar_terpilih as $key)
                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                @endforeach
                            @elseif($keterangan_lain)
                                {{ $keterangan_lain }}
                            @else
                                Tidak Ada Data
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="height: auto; padding: 1px; width: 100%; box-sizing: border-box; ">
                            <table
                                style="width: 100%; border-collapse: collapse; margin: 0; padding: 2px; border: 1px solid black; box-sizing: border-box;">
                                <tr>
                                    <td style="margin: 0; padding:1px; boder:1px solid black;">Kondisi Pulang:
                                        <br>{{ $resume->kondisi_pulang ?? '' }}
                                    </td>
                                    <td style="margin: 0; padding:1px; boder:1px solid black;">Keadaan Umum:
                                        <br>{{ $resume->keadaan_umum ?? '' }}
                                    </td>
                                    <td style="margin: 0; padding:1px; boder:1px solid black;">Kesadaran:
                                        <br>{{ $resume->kesadaran ?? '' }}
                                    </td>
                                    <td style="margin: 0; padding:1px; boder:1px solid black;">Tekanan Darah:
                                        <br>{{ $resume->tekanan_darah ?? '' }}
                                    </td>
                                    <td style="margin: 0; padding:1px; boder:1px solid black;">Nadi:
                                        <br>{{ $resume->nadi ?? '' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="margin: 0;padding:1px; border:1px solid black;">
                            Pengobatan Dilanjutkan:
                            @php
                                $pengobatan_dilanjutkan = json_decode($resume->pengobatan_dilanjutkan, true);
                                $pengobatan_terpilih = array_filter(
                                    $pengobatan_dilanjutkan,
                                    fn($value) => $value == 'on',
                                );
                                $pengobatan_terpilih = array_keys($pengobatan_terpilih);
                                $keterangan_lain = $pengobatan_dilanjutkan['lainnya'] ?? null;
                            @endphp
                            @if (count($pengobatan_terpilih) > 0)
                                @foreach ($pengobatan_terpilih as $key)
                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                @endforeach
                            @elseif($keterangan_lain)
                                {{ $keterangan_lain }}
                            @else
                                Tidak Ada Data
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"
                            style="height: auto; padding: 1px; width: 100%; box-sizing: border-box; border:1px solid black;">
                            <table style="width: 100%;  border-collapse: collapse;">
                                <tr>
                                    <td rowspan="4" style="border:1px solid black;">Instruksi Pulang : <br>
                                        {{ $resume->ket_intruksi_pulang ?? '' }}</td>
                                    <td style="margin: 0; padding:1px; border:1px solid black;">Kontrol Tanggal :
                                        {{ $resume->tgl_kontrol ? \Carbon\Carbon::parse($resume->tgl_kontrol)->format('d-m-Y') :'-' }} || Di :
                                        {{ $resume->lokasi_kontrol }}</td>
                                </tr>
                                <tr>
                                    <td style="margin: 0; padding:1px; border:1px solid black;">Diet :
                                        {{ $resume->diet ?? '' }} </td>
                                </tr>
                                <tr>
                                    <td style="margin: 0; padding:1px; border:1px solid black;">Latihan:
                                        {{ $resume->latihan ?? '' }} </td>
                                </tr>
                                <tr>
                                    <td style="margin: 0; padding:1px; border:1px solid black;">Segera kembali ke Rumah
                                        Sakit, langsung ke Gawat
                                        Darurat, bila terjadi: <br>
                                        {{ $resume->keterangan_kembali }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="height: auto; padding: 0px; width: 100%; box-sizing: border-box;">
                            <table style="border: none; width: 100%; border-collapse: collapse; margin:0px;"
                                id="table-ttd">
                                <tr style="border: none;">
                                    <td style=" text-align: center; border: none;">
                                        Pasien <br> Yang Menerima Penjelasan <br>
                                        <br><br><br><br><br><br>
                                        <span
                                            style="margin-top:40px;">..............................................</span>
                                    </td>
                                    <td style=" text-align: center; border: none;">
                                        Waled,
                                        {{-- {{ Carbon\Carbon::parse($resume->tgl_cetak)->format('m-d-Y') ?? '.... 20..' }} --}}
                                        {{ $resume->tgl_cetak
                                            ? \Carbon\Carbon::parse($resume->tgl_cetak)->format('d-m-Y')
                                            : '.... 20..' }}

                                        <br>
                                        Dokter Penanggung Jawab Pelayanan (DPJP) <br>
                                        <br><br><br><br><br><br>
                                        <span
                                            style="margin-top:40px;">{{ $resume->dpjp ?? '..............................................' }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <footer class="page-footer">
        </footer>
    @else
        <header class="page-header">
            <div class="col-12" style="font-size: 11px; text-align:right"><strong>RM.15.01-RI/Rev.03/24</strong></div>
            <table class="table table-sm table-bordered" style="font-size: 11px">
                <tr style="margin: 0px; padding:0px;">
                    <td width="10%"
                        style="border-right: 1px solid black; margin:0px; padding:0px; text-align:center">
                        <img class="" src="{{ public_path('vendor/adminlte/dist/img/rswaled.png') }}"
                            style="height: 50px">
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
    @endif
</body>

</html>
