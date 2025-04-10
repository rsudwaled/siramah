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
        @include('simrs.erm-ranap.cetak_pdf.resume_pasien.component.header_resume')
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
                                        style="border:none; border-right:1px solid black; width: 5px; display: flex; justify-content: center; align-items: center; height:120px; padding:5px;">
                                        <div style="transform: rotate(90deg); white-space: nowrap; font-size: 12px;">
                                            <span>DIAGNOSA KELUAR</span>
                                        </div>
                                    </td>
                                    <td style="height: auto; margin:0px; padding:2px;">
                                        <table
                                            style="width: 100%; height:50px; border-collapse: collapse; margin:0px; padding:0px;">
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
                                                    style="text-align: left; vertical-align: top; margin: 0; padding:2px; height:100px; border-top:1px solid black; border-bottom:1px solid black; border-right:1px solid black;">
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
        @if ($riwayatObat->count() > 40 && $obatPulang->count() > 10)
            @include('simrs.erm-ranap.cetak_pdf.resume_pasien.component.obat_pulang_10up')
        @else
            @include('simrs.erm-ranap.cetak_pdf.resume_pasien.component.obat_pulang_10down')
        @endif
    @else
        @include('simrs.erm-ranap.cetak_pdf.resume_pasien.component.resume_kosong')

    @endif
</body>

</html>
