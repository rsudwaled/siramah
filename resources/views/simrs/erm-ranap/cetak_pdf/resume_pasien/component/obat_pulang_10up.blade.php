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
                    <div class="col-12" style="text-align: center;  paddng:4px;">
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
                                                     {{-- @if ($obat['qty'] > 0) --}}
                                                    <tr>
                                                        <td
                                                            style="border: 1px solid black;  vertical-align: middle; font-size:9px; text-align:center;">
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td style="border: 1px solid black;  font-size:9px;">
                                                            {{ $obat['nama_barang'] }}
                                                        </td>
                                                        <td
                                                            style="border: 1px solid black;  vertical-align: middle; font-size:9px; text-align:center;">
                                                            {{ $obat['qty'] }}
                                                        </td>
                                                        <td
                                                            style="border: 1px solid black;  vertical-align: middle; font-size:9px;">
                                                            {{ $obat['aturan_pakai'] }}
                                                        </td>
                                                    </tr>
                                                    {{-- @endif --}}
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
                                <th style="border: 1px solid black;  vertical-align: middle; width:40%;">
                                    Nama Obat</th>
                                <th style="border: 1px solid black;  vertical-align: middle; width:5%;">
                                    JUMLAH</th>
                                <th style="border: 1px solid black;  vertical-align: middle; width:15%;">
                                    Dosis</th>
                                <th style="border: 1px solid black;  vertical-align: middle; width:15%;">
                                    Frekuensi
                                </th>
                                <th style="border: 1px solid black;  vertical-align: middle;">Cara
                                    Pemberian {{ $obatPulang->count() }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($obatPulang)
                                @foreach ($obatPulang as $obat)
                                    <tr>
                                        <td style="border: 1px solid black; padding: 1px; vertical-align: middle;">
                                            {{ $obat->nama_obat }}</td>
                                        <td
                                            style="border: 1px solid black; padding: 1px; vertical-align: middle; text-align:center;">
                                            {{ $obat->jumlah }}</td>
                                        <td style="border: 1px solid black; padding: 1px; vertical-align: middle;">
                                            {{ $obat->dosis ?? '' }}</td>
                                        <td
                                            style="border: 1px solid black; padding: 1px; vertical-align: middle; text-align:center;">
                                            {{ $obat->frekuensi ?? '' }}</td>
                                        <td style="border: 1px solid black; padding: 1px; vertical-align: middle;">
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
                <td colspan="3"
                    style="height: auto; padding: 1px; width: 100%; box-sizing: border-box; border:1px solid black;">
                    <table style="width: 100%;  border-collapse: collapse;">
                        <tr>
                            <td rowspan="4" style="border:1px solid black;">Instruksi Pulang : <br>
                                {{ $resume->ket_intruksi_pulang ?? '' }}</td>
                            <td style="margin: 0; padding:1px; border:1px solid black;">Kontrol Tanggal :
                                {{ $resume->tgl_kontrol ? \Carbon\Carbon::parse($resume->tgl_kontrol)->format('d-m-Y') : '.... 20..' }} || Di :
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
                    <table style="border: none; width: 100%; border-collapse: collapse; margin:0px;" id="table-ttd">
                        <tr style="border: none;">
                            <td style=" text-align: center; border: none;">
                                Pasien <br> Yang Menerima Penjelasan <br>
                                <br><br><br><br><br><br>
                                <span style="margin-top:40px;">..............................................</span>
                            </td>
                            <td style=" text-align: center; border: none;">
                                Waled,
                                {{-- {{ Carbon\Carbon::parse($resume->tgl_cetak)->format('m-d-Y') ?? '.... 20..' }} --}}
                                {{ $resume->tgl_cetak ? \Carbon\Carbon::parse($resume->tgl_cetak)->format('d-m-Y') : '.... 20..' }}

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
