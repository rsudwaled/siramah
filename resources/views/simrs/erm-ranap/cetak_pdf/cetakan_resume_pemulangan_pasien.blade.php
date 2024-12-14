@extends('simrs.erm-ranap.template_print.pdf_print')
@section('title', 'Resume Pemulangan Pasien')

@section('content')

    @include('simrs.erm-ranap.template_print.pdf_kop_surat_resume_pemulangan')
    @if (!empty($resume))
        <table class="table table-bordered" style="width: 100%; font-size:11px;">
            <tbody>
                <tr style="background-color: #ffc107; margin:0;">
                    <td colspan="3" class="text-center" style="margin: 0; padding:5px;">
                        <b>RESUME PEMULANGAN</b><br>
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
                        Ruang Rawat: {{ $resume->ruang_rawat_masuk ?? '' }}
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
                        Ruang Rawat: {{ $resume->ruang_rawat_keluar ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding:5px;">
                        Lama Rawat: {{ $resume->lama_rawat ?? '' }} Hari
                    </td>
                    <td style="margin: 0; padding:5px;" colspan="2">
                        Berat Badan Bayi Lahir < 1 Bulan: {{ $resume->bb_bayi_lahir ?? '.......' }} Kg || Grafida :
                            {{ $resume->grafida ?? '.......' }} minggu</td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 0; padding:5px; height:70px;">
                        <span style="font-size: 12px; font-weight: bold;">Ringkasan Perawatan:</span> <br>
                        {{ $resume->ringkasan_perawatan ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 0; padding:5px; height:70px;">
                        <span style="font-size: 12px; font-weight: bold;">Riwayat Penyakit:</span> <br>
                        {{ $resume->riwayat_penyakit ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 0; padding:5px; height:70px;">
                        <span style="font-size: 12px; font-weight: bold;">Indikasi Rawat Inap:</span> <br>
                        {{ $resume->indikasi_ranap ?? '' }}

                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 0; padding:5px; height:70px;">
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
                                        ||
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
                                            <td style="width: 20%">Laboratorium</td>
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
                        {{$resume->diagnosa_masuk??''}}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="margin:0px; padding:0px;">
                        <table style="width: 100%; border-collapse: collapse; border:none;">
                            <tr style="border: none;">
                                <td
                                    style="border:none; width: 10px; display: flex; justify-content: center; align-items: center; height:128px;">
                                    <div style="transform: rotate(90deg); white-space: nowrap; font-size: 12px;">
                                        <span>DIAGNOSA SEKUNDER</span>
                                    </div>
                                </td>
                                <td style="height: 30px; margin:0px; padding:2px;">
                                    <table
                                        style="width: 100%; height:50px; border-collapse: collapse; margin:0px; padding:0px;">
                                        <tr>
                                            @php
                                                $diagutama = explode(' - ', $resume->diagnosa_utama);
                                            @endphp
                                            <td style="width: 20%; margin: 0; padding:2px;">Diagnosa Utama</td>
                                            <td style="margin: 0; padding:2px;">
                                                {{$diagutama[1]}}
                                            </td>
                                            <td style="margin: 0; padding:2px;">
                                                {{$diagutama[0]}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Diagnosa Sekunder</td>
                                            <td style="margin: 0; padding:2px; height:100px;">
                                                @php
                                                    $sekunder = explode('|', $resume->diagnosa_sekunder);
                                                @endphp
                                                @foreach ($sekunder as $diagSekunder)
                                                    @php
                                                        $parts = explode(' - ', $diagSekunder);
                                                        $description = isset($parts[1]) ? $parts[1] : '';
                                                    @endphp
                                                    . {{ $description }} <br>
                                                @endforeach
                                            </td>
                                            <td style="margin: 0; padding:2px;">
                                                @php
                                                    $sekunder = explode('|', $resume->diagnosa_sekunder);
                                                @endphp
                                                @foreach ($sekunder as $diagSekunder)
                                                    @php
                                                        $parts = explode(' - ', $diagSekunder);
                                                        $code = isset($parts[0]) ? $parts[0] : '';
                                                    @endphp
                                                    . {{ $code }} <br>
                                                @endforeach
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
                    <td style="margin: 0; padding:3px;">
                        <strong style="margin: 0.5rem 0;">Tindakan Operasi</strong>
                    </td>
                    <td colspan="2" style="margin: 0; padding:3px;">
                        @php
                            $operasi = explode('|', $resume->tindakan_operasi);
                        @endphp
                        @foreach ($operasi as $tindakanOperasi)
                            @php
                                $parts = explode(' - ', $tindakanOperasi);
                                $description = isset($parts[1]) ? $parts[1] : '';
                            @endphp
                            . {{ $description }} <br>
                        @endforeach
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
                    <td style="margin: 0; padding:3px;">
                        <strong style="margin: 0.5rem 0;">Tindakan / Prosedure</strong>
                    </td>
                    <td colspan="2" style="margin: 0; padding:3px;">
                        @php
                            $prosedure = explode('|', $resume->tindakan_prosedure);
                        @endphp
                        @foreach ($prosedure as $tindakanProsedure)
                            @php
                                $parts = explode(' - ', $tindakanProsedure);
                                $description = isset($parts[1]) ? $parts[1] : '';
                            @endphp
                            . {{ $description }} <br>
                        @endforeach
                        {{-- {{ $resume->tindakan_prosedure ?? '' }} --}}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center;">
                        <strong style="margin: 0.5rem 0;">Pengobatan Selama
                            Dirawat</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="height: 650px; padding: 0; width: 100%; box-sizing: border-box;">
                        <div class="col-12">
                            @if ($riwayatObat->isNotEmpty())
                                @php
                                    // Mengelompokkan data menjadi chunk berisi 10 item
                                    $chunks = $riwayatObat->chunk(10);
                                @endphp
                                <div style="page-break-inside: avoid; height: 650px;">
                                    @foreach ($chunks as $index => $chunk)
                                        <div
                                            style="width: 32%; float: left; margin-right: 1%; margin-bottom: 10px; box-sizing: border-box; page-break-inside: avoid;">
                                            <table
                                                style="width: 100%; border-collapse: collapse; margin: 0; padding: 2px; border: 1px solid black; box-sizing: border-box; font-size:10px;">
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($chunk as $obat)
                                                        <tr>
                                                            <td
                                                                style="border: 1px solid black; padding: 5px; vertical-align: middle;">
                                                                {{ $loop->iteration }}</td>
                                                            <td style="border: 1px solid black; padding: 5px;">
                                                                {{ $obat['nama_barang'] }}</td>
                                                            <td
                                                                style="border: 1px solid black; padding: 5px; vertical-align: middle;">
                                                                {{ $obat['qty'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Tambahkan clear setelah setiap 3 tabel -->
                                        @if (($index + 1) % 3 == 0)
                                            <div style="clear: both;"></div>
                                            <!-- Ini memastikan tabel berikutnya berada di bawah -->
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
        {{-- batas page 3 --}}
        <div class="col-12 mt-1">
            @include('simrs.erm-ranap.template_print.pdf_kop_surat_resume_pemulangan')
        </div>
        <table class="table table-bordered" style="width: 100%; font-size:11px;">
            <tbody>
                <tr style="background-color: #ffc107; margin:0;">
                    <td colspan="3" class="text-center" style="margin: 0; padding:5px;">
                        <b>RESUME PEMULANGAN</b><br>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="height: 260px; padding: 2px; width: 100%; box-sizing: border-box;">
                        <table
                            style="width: 100%; border-collapse: collapse; margin: 0; padding: 2px; border: 1px solid black; box-sizing: border-box;">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <strong style="margin: 0.5rem 0;">Obat Untuk Pulang</strong>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="border: 1px solid black; padding: 5px; text-align: left; width:80%;">
                                        Nama Obat</th>
                                    <th style="border: 1px solid black; padding: 5px; text-align: left;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($obatPulang)
                                    @foreach ($obatPulang as $obat)
                                        <tr>
                                            <td style="border: 1px solid black; padding: 5px;">{{ $obat->nama_obat }}</td>
                                            <td style="border: 1px solid black; padding: 5px;">{{ $obat->jumlah }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                        <td style="border: 1px solid black; padding: 5px;">-</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </td>
                </tr>
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
                    <td colspan="3" style="height: 100px; padding: 2px; width: 100%; box-sizing: border-box;">
                        <table
                            style="width: 100%; border-collapse: collapse; margin: 0; padding: 2px; border: 1px solid black; box-sizing: border-box;">
                            <tr>
                                <td>Kondisi Pulang: <br>{{ $resume->kondisi_pulang ?? '' }}</td>
                                <td>Keadaan Umum: <br>{{ $resume->keadaan_umum ?? '' }}</td>
                                <td>Kesadaran: <br>{{ $resume->kesadaran ?? '' }}</td>
                                <td>Tekanan Darah: <br>{{ $resume->tekanan_darah ?? '' }}</td>
                                <td>Nadi: <br>{{ $resume->nadi ?? '' }}</td>
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
                    <td colspan="3">
                        <table style="width: 100%;  border-collapse: collapse;">
                            <tr>
                                <td rowspan="4">Instruksi Pulang</td>
                                <td>Kontrol Tanggal : {{ $resume->tgl_kontrol ?? '-' }} || Di :
                                    {{ $resume->lokasi_kontrol }}</td>
                            </tr>
                            <tr>
                                <td>Diet : {{ $resume->diet ?? '' }} </td>
                            </tr>
                            <tr>
                                <td>Latihan: {{ $resume->latihan ?? '' }} </td>
                            </tr>
                            <tr>
                                <td>Segera kembali ke Rumah Sakit, langsung ke Gawat Darurat, bila terjadi:
                                    {{ $resume->keterangan_kembali }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table style="border: none; width: 100%; border-collapse: collapse; margin:0px;" id="table-ttd">
                            <tr style="border: none; margin:0px;">
                                <td style="width: 50%; text-align: center; border: none; margin:0px;">Pasien / Keluarga
                                    Pasien <br> Yang Menerima Penjelasan</td>
                                <td style="width: 50%; text-align: center; border: none; margin:0px;">Waled,
                                    {{ Carbon\Carbon::parse($resume->tgl_cetak)->format('m-d-Y') ?? '.... 20..' }} <br>
                                    Dokter Penanggung Jawab Pelayanan (DPJP)</td>
                            </tr>
                            <tr style="border: none;">
                                <td style="padding-top: 80px; text-align: center; border: none;">
                                    ..............................................</td>
                                <td style="padding-top: 80px; text-align: center; border: none;">
                                    {{ $resume->dpjp ?? '..............................................' }}</td>
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
