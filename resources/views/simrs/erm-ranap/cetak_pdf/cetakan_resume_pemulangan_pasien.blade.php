@extends('simrs.erm-ranap.template_print.pdf_print')
@section('title', 'RINGKASAN PASIEN PULANG')

@section('content')

    @include('simrs.erm-ranap.template_print.pdf_kop_surat_resume_pemulangan')
    @if (!empty($resume))
        <table class="table table-bordered" style="width: 100%; font-size:11px;">
            <tbody>
                <tr style="background-color: #ffc107; margin:0;">
                    <td colspan="3" class="text-center" style="margin: 0; padding:5px;">
                        <b>RINGKASAN PASIEN PULANG</b><br>
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding:5px;">
                        Tgl Masuk: {{ $resume->tgl_masuk ?? '' }}
                    </td>
                    <td style="margin: 0; padding:5px;">
                        Jam Masuk: {{ $resume->jam_masuk ?? '' }} WIB
                    </td>
                    <td style="margin: 0; padding:5px;">
                        Ruang Rawat: {{ strtoupper($resume->ruang_rawat_masuk ?? '') }}
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding:5px;">
                        Tgl Keluar: {{ $resume->tgl_keluar ?? '' }}
                    </td>
                    <td style="margin: 0; padding:5px;">
                        Jam Keluar: {{ $resume->jam_keluar ?? '' }} WIB
                    </td>
                    <td style="margin: 0; padding:5px;">
                        Ruang Rawat: {{ strtoupper($resume->ruang_rawat_keluar ?? '') }}
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding:5px;">
                        Rawat Intensif: {{ $resume->rawat_intensif ?? '-' }} Hari <br>
                        Lama Rawat: {{ $resume->lama_rawat ?? '-' }} Hari
                    </td>
                    <td style="margin: 0; padding:5px;">
                        Berat Badan Bayi Lahir < 1 Bulan: {{ $resume->bb_bayi_lahir ?? '.......' }} Kg </td>
                    <td style="margin: 0; padding:5px;">Gravida :{{ $resume->grafida ?? '.......' }} minggu</td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 0; padding:5px; height:auto;">
                        <span style="font-size: 12px; font-weight: bold;">Ringkasan Perawatan:</span> <br>
                        {{ $resume->ringkasan_perawatan ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 0; padding:5px; height:auto;">
                        <span style="font-size: 12px; font-weight: bold;">Riwayat Penyakit:</span> <br>
                        {{ $resume->riwayat_penyakit ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 0; padding:5px; height:auto;">
                        <span style="font-size: 12px; font-weight: bold;">Indikasi Rawat Inap:</span> <br>
                        {{ $resume->indikasi_ranap ?? '' }}

                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 0; padding:5px; height:auto;">
                        <span style="font-size: 12px; font-weight: bold;">Pemeriksaan Fisik:</span> <br>
                        {{ $resume->pemeriksaan_fisik ?? '' }}
                    </td>
                </tr>
                @if ($umur == 0 || $umur < 30)
                    <tr>
                        <td colspan="3" style="margin: 0; padding:5px; height:40px;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="margin: 0; padding:2px; text-align:center;">Pemeriksaan SHK
                                        {{ $umur }}</td>
                                    <td style="margin: 0; padding:2px; text-align:center;">APGAR SCORE</td>
                                </tr>
                                <tr>
                                    <td style="margin: 0; padding:2px; width: 65%;">
                                        Dilakukan :
                                        {{ $resume->pemeriksaan_shk_ya ?? $resume->pemeriksaan_shk_tidak
                                            ? ($resume->pemeriksaan_shk_ya == 'on'
                                                ? 'pemeriksaan_shk_ya'
                                                : 'pemeriksaan_shk_tidak')
                                            : '-' }}
                                        ||
                                        Diambil dari :
                                        {{ $resume->diambil_dari_tumit ?? $resume->diambil_dari_vena
                                            ? ($resume->diambil_dari_tumit == 'on'
                                                ? 'diambil_dari_tumit'
                                                : 'diambil_dari_vena')
                                            : '-' }}
                                        <br>
                                        Tgl Pengambilan : {{ $resume->tgl_pengambilan_shk ?? '-' }}
                                    </td>
                                    <td style="margin: 0; padding:2px;">
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
                    <td colspan="3" style="margin:0px; padding:0px; height:300px;">
                        <table style="width: 100%; border-collapse: collapse; height:250px;">
                            <tr>
                                <td
                                    style="border:none; width: 10px; display: flex; justify-content: center; align-items: center; height:300px;">
                                    <div style="transform: rotate(90deg); white-space: nowrap; font-size: 12px;">
                                        <span>PEMERIKSAAN PENUNJANG</span>
                                    </div>
                                </td>
                                <td style="height: auto; margin:0px; padding:2px;">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="width: 117px">Laboratorium</td>
                                            <td style="margin: 0; padding:2px; height:100px;">
                                                {{ $resume->penunjang_lab ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Radiologi</td>
                                            <td style="margin: 0; padding:2px; height:100px;">
                                                {{ $resume->penunjang_radiologi ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Penunjang Lainnya</td>
                                            <td style="margin: 0; padding:2px; height:100px;">
                                                {{ $resume->penunjang_lainnya ?? '' }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding:3px;">
                        <strong style="margin: 0.5rem 0;">Hasil Konsultasi</strong>
                    </td>
                    <td colspan="2" style="margin: 0; padding:3px;">
                        {{ $resume->hasil_konsultasi ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding:3px;">
                        <strong style="margin: 0.5rem 0;">Diagnosa Masuk</strong>
                    </td>
                    <td colspan="2" style="margin: 0; padding:3px;">
                        {{ $resume->diagnosa_masuk ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="margin:0px; padding:0px;">
                        <table style="width: 100%; border-collapse: collapse; border:none;">
                            <tr style="border: none;">
                                <td
                                    style="border:none; width: 10px; display: flex; justify-content: center; align-items: center; height:128px;">
                                    <div style="transform: rotate(90deg); white-space: nowrap; font-size: 12px;">
                                        <span>DIAGNOSA KELUAR</span>
                                    </div>
                                </td>
                                <td style="height: 30px; margin:0px; padding:2px;">
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
                                            <td style="width: 20%; margin: 0; padding:2px; width:113px;">Diagnosa Utama</td>
                                            <td style="margin: 0; padding:2px;">
                                                {{-- {{ $diagutama[1] ?? 'Tidak Diketahui' }} --}}
                                                {{ $resume->diagnosa_utama_dokter ?? '' }}
                                            </td>
                                            <td style="margin: 0; padding:2px;">
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
                                            <td style="margin: 0; padding:2px; ">Diagnosa Sekunder</td>
                                            <td style="margin: 0; padding:2px; height:100px;">
                                                @php
                                                    $sekunder = explode('|', $resume->diagnosa_sekunder_dokter);
                                                    $coderIcd = $resume->diagnosaSekunder ?? null;
                                                @endphp
                                                @foreach ($sekunder as $diagSekunder)
                                                    . {{ $diagSekunder }} <br>
                                                @endforeach
                                            </td>
                                            <td style="margin: 0; padding:2px; width:180px;">
                                                Kode ICD X: <br>
                                                @if (!empty($coderIcd))
                                                    @foreach ($coderIcd as $icd)
                                                        -{{ $icd->kode_diagnosa }} <br>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="margin: 0; padding:2px;">Komplikasi</td>
                                            <td colspan="2" style="margin: 0; padding:2px;">
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
                    <td style="margin: 0; padding:3px; height:auto; width:178px;">
                        <strong style="margin: 0.5rem 0;">Tindakan Operasi</strong>
                    </td>
                    <td style="margin: 0; padding:3px;">
                        @php
                            $operasi = explode('|', $resume->tindakan_operasi_dokter);
                            $codeOperasi = $resume->tindakanOperasiCodes ?? null;
                        @endphp
                        @foreach ($operasi as $tindakanOperasi)
                            <span style="padding-top: 4px; display: block;">. {{ $tindakanOperasi }}</span>
                        @endforeach
                    </td>
                    <td style="margin: 0; padding:3px; width:180px;">
                        ICD9 CM: <br>
                        @if (!empty($codeOperasi))
                            @foreach ($codeOperasi as $icd)
                                <span style="padding-top: 4px; display: block;">- {{ $icd->kode_tindakan }}</span>
                            @endforeach
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 38%; margin: 0; padding:3px;">
                        <div class="form-group">
                            <strong style="margin: 0.5rem 0;">Tgl Operasi:</strong>
                            {{ $resume->tgl_operasi ?? '' }}
                        </div>
                    </td>
                    <td style="margin: 0; padding:3px;">
                        <div class="form-group">
                            <strong style="margin: 0.5rem 0;">Waktu Mulai:</strong>
                            {{ $resume->waktu_operasi_mulai ?? '' }} WIB
                        </div>
                    </td>
                    <td style="margin: 0; padding:3px;">
                        <div class="form-group">
                            <strong style="margin: 0.5rem 0;">Waktu Selesai:</strong>
                            {{ $resume->waktu_operasi_selesai ?? '' }} WIB
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding:3px;">
                        <strong style="margin: 0.5rem 0;">Sebab Kematian</strong>
                    </td>
                    <td colspan="2" style="margin: 0; padding:3px;">
                        {{ $resume->sebab_kematian ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding:3px; height:auto;" colspan="2">
                        <strong style="margin: 0.5rem 0;">Tindakan / Prosedure</strong>
                    </td>
                    <td style="margin: 0; padding:3px;">
                        ICD9 CM:
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="margin: 0; padding:3px;">
                        @php
                            $prosedure = explode('|', $resume->tindakan_prosedure_dokter);
                            $codeProsedure = $resume->tindakanProsedureCodes ?? null;
                        @endphp
                        @foreach ($prosedure as $tindakanProsedure)
                            <span style="padding-top: 4px; display: block;">. {{ $tindakanProsedure }}</span>
                        @endforeach
                    </td>
                    <td style="margin: 0; padding:3px;">
                        @if (!empty($codeProsedure))
                            @foreach ($codeProsedure as $icd)
                                <span style="padding-top: 4px; display: block;">- {{ $icd->kode_procedure }}</span>
                            @endforeach
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="padding: 0; width: 100%; box-sizing: border-box; ">
                        <div class="col-12"
                            style="text-align: center; padding-top: 4px; padding-bottom: 5px; margin: 0.5rem 0;">
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
                                            style="height: auto; width: 48%; margin-right: 1%; margin-bottom: 10px; display: inline-block; vertical-align: top; box-sizing: border-box; page-break-inside: avoid;">
                                            <table
                                                style="font-size:10px; width: 100%; border-collapse: collapse; margin: 0; padding: 2px; border: 1px solid black; box-sizing: border-box; font-size: 10px;">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            style="border: 1px solid black; padding: 5px; vertical-align: middle;">
                                                            No</th>
                                                        <th
                                                            style="border: 1px solid black; padding: 5px; text-align: left;">
                                                            Nama Obat</th>
                                                        <th
                                                            style="border: 1px solid black; padding: 5px; vertical-align: middle;">
                                                            Jumlah</th>
                                                        <th
                                                            style="border: 1px solid black; padding: 5px; vertical-align: middle;">
                                                            Dosis</th>
                                                        <th
                                                            style="border: 1px solid black; padding: 5px; vertical-align: middle;">
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
                                                                style="border: 1px solid black; padding: 5px; vertical-align: middle; font-size:9px;">
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td style="border: 1px solid black; padding: 5px; font-size:9px;">
                                                                {{ $obat['nama_barang'] }}
                                                            </td>
                                                            <td
                                                                style="border: 1px solid black; padding: 5px; vertical-align: middle; font-size:9px;">
                                                                {{ $obat['qty'] }}
                                                            </td>
                                                            <td
                                                                style="border: 1px solid black; padding: 5px; vertical-align: middle; font-size:9px;">

                                                            </td>
                                                            <td
                                                                style="border: 1px solid black; padding: 5px; vertical-align: middle; font-size:9px;">
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
                            style="width: 100%; border-collapse: collapse; margin: 0; padding: 2px; border: 1px solid black; box-sizing: border-box;">
                            <thead>
                                <tr>
                                    <th colspan="5">
                                        <strong style="margin: 0.5rem 0;">Obat Untuk Pulang</strong>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="border: 1px solid black; padding: 5px; vertical-align: middle; width:40%;">
                                        Nama Obat</th>
                                    <th style="border: 1px solid black; padding: 5px; vertical-align: middle; width:5%;">
                                        JUMLAH</th>
                                    <th style="border: 1px solid black; padding: 5px; vertical-align: middle; width:15%;">
                                        Dosis</th>
                                    <th style="border: 1px solid black; padding: 5px; vertical-align: middle; width:8%;">
                                        Frekuensi
                                    </th>
                                    <th style="border: 1px solid black; padding: 5px; vertical-align: middle;">Cara
                                        Pemberian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($obatPulang)
                                    @foreach ($obatPulang as $obat)
                                        <tr>
                                            <td style="border: 1px solid black; padding: 5px; vertical-align: middle;">
                                                {{ $obat->nama_obat }}</td>
                                            <td style="border: 1px solid black; padding: 5px; vertical-align: middle;">
                                                {{ $obat->jumlah }}</td>
                                            <td style="border: 1px solid black; padding: 5px; vertical-align: middle;">
                                                {{ $obat->dosis ?? '' }}</td>
                                            <td style="border: 1px solid black; padding: 5px; vertical-align: middle;">
                                                {{ $obat->frekuensi ?? '' }}</td>
                                            <td style="border: 1px solid black; padding: 5px; vertical-align: middle;">
                                                {{ $obat->cara_pemberian ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td style="border: 1px solid black; padding: 3px;">-</td>
                                        <td style="border: 1px solid black; padding: 3px;">-</td>
                                        <td style="border: 1px solid black; padding: 3px;">-</td>
                                        <td style="border: 1px solid black; padding: 3px;">-</td>
                                        <td style="border: 1px solid black; padding: 3px;">-</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- batas page 3 --}}
        {{-- <div class="col-12 mt-1">
            <div class="col-12 mb-10" style="font-size: 11px; text-align:right; color:rgb(243, 249, 255)"><strong>RM.15.01-R/Rev.02/19</strong></div>
            @include('simrs.erm-ranap.template_print.pdf_kop_surat_resume_pemulangan')
        </div> --}}
        <table class="table table-bordered" style="width: 100%; font-size:11px;">
            <tbody>
                {{-- <tr style="background-color: #ffc107; margin:0;">
                    <td colspan="3" class="text-center" style="margin: 0; padding:5px;">
                        <b>RESUME PEMULANGAN</b><br>
                    </td>
                </tr> --}}

                <tr>
                    <td colspan="3" style="margin:0px; padding:2px;">
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
                    <td colspan="3" style="height: auto; padding: 2px; width: 100%; box-sizing: border-box;">
                        <table
                            style="width: 100%; border-collapse: collapse; margin: 0; padding: 2px; border: 1px solid black; box-sizing: border-box;">
                            <tr>
                                <td  style="margin: 0; padding:2px;">Kondisi Pulang: <br>{{ $resume->kondisi_pulang ?? '' }}</td>
                                <td  style="margin: 0; padding:2px;">Keadaan Umum: <br>{{ $resume->keadaan_umum ?? '' }}</td>
                                <td style="margin: 0; padding:2px;">Kesadaran: <br>{{ $resume->kesadaran ?? '' }}</td>
                                <td style="margin: 0; padding:2px;">Tekanan Darah: <br>{{ $resume->tekanan_darah ?? '' }}</td>
                                <td style="margin: 0; padding:2px;">Nadi: <br>{{ $resume->nadi ?? '' }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 0;padding:2px;">
                        Pengobatan Dilanjutkan:
                        @php
                            $pengobatan_dilanjutkan = json_decode($resume->pengobatan_dilanjutkan, true);
                            $pengobatan_terpilih = array_filter($pengobatan_dilanjutkan, fn($value) => $value == 'on');
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
                    <td colspan="3" style="height: auto; padding: 2px; width: 100%; box-sizing: border-box;">
                        <table style="width: 100%;  border-collapse: collapse;">
                            <tr>
                                <td rowspan="4">Instruksi Pulang : <br> {{$resume->ket_intruksi_pulang??''}}</td>
                                <td  style="margin: 0; padding:2px;">Kontrol Tanggal : {{ $resume->tgl_kontrol ?? '-' }} || Di :
                                    {{ $resume->lokasi_kontrol }}</td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding:2px;">Diet : {{ $resume->diet ?? '' }} </td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding:2px;">Latihan: {{ $resume->latihan ?? '' }} </td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding:2px;">Segera kembali ke Rumah Sakit, langsung ke Gawat Darurat, bila terjadi:
                                    {{ $resume->keterangan_kembali }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="height: auto; padding: 2px; width: 100%; box-sizing: border-box;">
                        <table style="border: none; width: 100%; border-collapse: collapse; margin:0px;" id="table-ttd">
                            {{-- <tr style="border: none; margin:0px;">
                                <td style="width: 50%; text-align: center; border-bottom: none; margin:0px;">Pasien / Keluarga
                                    </td>
                                <td style="width: 50%; text-align: center; border: none; margin:0px;">Waled,
                                    </td>
                            </tr> --}}
                            <tr style="border: none;">
                                <td style=" text-align: center; border: none;">
                                    Pasien <br> Yang Menerima Penjelasan <br>
                                    <br><br><br><br><br><br>
                                    <span style="margin-top:80px;">..............................................</span>
                                </td>
                                <td style=" text-align: center; border: none;">
                                    Waled, {{ Carbon\Carbon::parse($resume->tgl_cetak)->format('m-d-Y') ?? '.... 20..' }}
                                    <br>
                                    Dokter Penanggung Jawab Pelayanan (DPJP) <br>
                                    <br><br><br><br><br><br>
                                    <span
                                        style="margin-top:80px;">{{ $resume->dpjp ?? '..............................................' }}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <table class="table table-sm table-bordered" style="font-size: 11px">
            <table class="table table-sm table-bordered" style="font-size: 11px">
                <tr style="background-color: #ffc107">
                    <td width="100%" class="text-center">
                        <b>RESUME PEMULANGAN</b><br>
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
