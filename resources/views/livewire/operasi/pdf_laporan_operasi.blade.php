@extends('livewire.print.pdf_layout')
@section('title', 'Laporan Operasi')

@section('content')
    <style>
        th {
            text-align: left !important;
        }
    </style>
    <table class="table table-sm table-bordered" style="font-size: 11px;">
        <tr>
            <td width="10%" class="text-center" style="vertical-align: center;">
                <img src="{{ public_path('rswaled.png') }}" style="height: 50px;">
            </td>
            <td width="50%" style="vertical-align: center;">
                <b>PEMERINTAHAN KABUPATEN CIREBON</b><br>
                <b>RUMAH SAKIT UMUM DAERAH WALED</b><br>
                Jl. Prabu Kian Santang No. 4 Kec. Waled Kab. Cirebon <br>
                Telp. 0231-661126 Email brsud.waled@gmail.com <br>

            </td>
            <td width="40%" style="vertical-align: center;">
                <table class="table-borderless">
                    <tr>
                        <td>No RM</td>
                        <td>:</td>
                        <th>{{ $kunjungan->pasien?->no_rm ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <th>{{ $kunjungan->pasien?->nama_px ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Tgl Lahir</td>
                        <td>:</td>
                        <th>
                            {{ \Carbon\Carbon::parse($kunjungan->pasien?->tgl_lahir)->format('d F Y') }}
                            ({{ \Carbon\Carbon::parse($kunjungan->pasien?->tgl_lahir)->age }} tahun)
                        </th>
                    </tr>
                    <tr>
                        <td>Sex</td>
                        <td>:</td>
                        <th>
                            @if ($kunjungan)
                                @if ($kunjungan->pasien?->jenis_kelamin == 'P')
                                    Perempuan
                                @else
                                    Laki-laki
                                @endif
                            @endif
                        </th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="text-center" style="background: yellow">
            <td colspan="3">
                <b>LAPORAN OPERASI</b>
            </td>
        </tr>
    </table>
    <table class="table table-sm table-bordered" style="font-size: 11px;">
        <tr>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>Ruang Operasi</td>
                        <td>:</td>
                        <th>{{ $laporan->ruang_operasi ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Kamar Operasi</td>
                        <td>:</td>
                        <th>{{ $laporan->kamar_operasi ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Tanggal Operasi</td>
                        <td>:</td>
                        <th>{{ $laporan->tanggal_operasi ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td class="unicode">
                            @if (!$laporan->cytoterencana)
                                &#9744;
                            @else
                                &#9745;
                            @endif
                            Cyto
                            @if ($laporan->cytoterencana)
                                &#9744;
                            @else
                                &#9745;
                            @endif
                            Terencana
                        </td>
                    </tr>
                    <tr>
                        <td>Jam Operasi Mulai</td>
                        <td>:</td>
                        <th>{{ $laporan->jam_operasi_mulai ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Jam Operasi Selesai</td>
                        <td>:</td>
                        <th>{{ $laporan->jam_operasi_selesai ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Lama Operasi</td>
                        <td>:</td>
                        <th>{{ $lama_operasi ?? '-' }}</th>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>Pembedah</td>
                        <td>:</td>
                        <th>{{ $laporan->pembedah ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Ahli Anastesi</td>
                        <td>:</td>
                        <th>{{ $laporan->ahli_anastesi ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Jenis Anastesi</td>
                        <td>:</td>
                        <th>{{ $laporan->jenis_anastesi ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Asisten I</td>
                        <td>:</td>
                        <th>{{ $laporan->asisten1 ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Asisten II</td>
                        <td>:</td>
                        <th>{{ $laporan->asisten2 ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Perawat Instrumen</td>
                        <td>:</td>
                        <th>{{ $laporan->perawat_instrumen ?? '-' }}</th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <b>Diagnosa Pra-Bedah :</b>
                <pre>{{ $laporan->diagnosa_pra_bedah }}</pre>
            </td>
            <td width="50%">
                <b>Indikasi Operasi :</b>
                <pre>{{ $laporan->indikasi_operasi }}</pre>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <b>Diagnosa Pasca-Bedah :</b>
                <pre>{{ $laporan->diagnosa_pasca_bedah }}</pre>
            </td>
            <td width="50%">
                <b>Jenis Operasi :</b>
                <pre>{{ $laporan->jenis_operasi }}</pre>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <b>Desinfeksi Kulit dengan :</b>
                <pre>{{ $laporan->desinfekasi_kulit }}</pre>
            </td>
            <td width="50%">
                <b>Jaringan Dieksisi :</b>
                <pre>{{ $laporan->jaringan_dieksisi }}</pre>
                <b>Dikirim ke Laboratorium Patologi Anatomi</b><br>
                <span class="unicode">
                    @if (!$laporan->dikirim_lab)
                        &#9744;
                    @else
                        &#9745;
                    @endif
                    Ya
                    @if ($laporan->dikirim_lab)
                        &#9744;
                    @else
                        &#9745;
                    @endif
                    Tidak
                </span>
                <table class="table-borderless">
                    <tr>
                        <td>Jenis Bahan</td>
                        <td>:</td>
                        <th>{{ $laporan->jenis_bahan ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Pemeriksaan Lab</td>
                        <td>:</td>
                        <th>{{ $laporan->pemeriksaan_laboratorium ?? '-' }}</th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <b>Macam Sayatan :</b>
                <pre>{{ $laporan->macam_sayatan }}</pre>
            </td>
            <td width="50%">
                <b>Posisi Penderita :</b>
                <pre>{{ $laporan->posisi_penderita }}</pre>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Teknik Operasi dan Temuan Intra-Operasi :</b>
                <pre>{{ $laporan->teknik_temuan_operasi }}</pre>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <b>Pengunaan BHP Khusus :</b> <br>
                <span class="unicode">
                    @if (!$laporan->bhp_khusus)
                        &#9744;
                    @else
                        &#9745;
                    @endif
                    Ya
                    @if ($laporan->bhp_khusus)
                        &#9744;
                    @else
                        &#9745;
                    @endif
                    Tidak
                </span>
                <br>
                <b>Jenis dan Jumlah (BHP Khusus) :</b>
                <pre>{{ $laporan->penggunaan_bhp_khusus }}</pre>
            </td>
            <td width="50%">
                <b>Komplikasi Intra-Operasi :</b> <br>
                <span class="unicode">
                    @if (!$laporan->komplikasi_operasi)
                        &#9744;
                    @else
                        &#9745;
                    @endif
                    Ya
                    @if ($laporan->komplikasi_operasi)
                        &#9744;
                    @else
                        &#9745;
                    @endif
                    Tidak
                </span>
                <br>
                <b>Penjabaran Komplikasi Intra-Operasi :</b>
                <pre>{{ $laporan->penjabaran_komplikasi }}</pre>
                Pendarahan : <b>{{ $laporan->pendarahan ?? '-' }}</b> cc
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Instruksi Pasca-Operasi</b>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>1. Kontrol</td>
                        <td>:</td>
                        <th>{{ $laporan->kontrol ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>2. Puasa</td>
                        <td>:</td>
                        <th>{{ $laporan->puasa ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>3. Drain</td>
                        <td>:</td>
                        <th>{{ $laporan->drain ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>4. Infus</td>
                        <td>:</td>
                        <th>{{ $laporan->infus ?? '-' }}</th>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>5. Obat-Obat</td>
                        <td>:</td>
                        <th>{{ $laporan->kontrol ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>6. Ganti Balut</td>
                        <td>:</td>
                        <th>{{ $laporan->puasa ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>7. Lain-lain</td>
                        <td>:</td>
                        <th>{{ $laporan->drain ?? '-' }}</th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="text-center">
            <td width="50%">
                <br>
                <b>Pembuat Laporan,</b><br>
                <br>
                <br>
                <br>
                <b><u>{{ $laporan->pembuat_laporan }}</u></b><br>
                Tanda Tangan dan Nama Jelas
            </td>
            <td width="50%">
                Waled, 12 Oktober 2024<br>
                <b>Pembedah,</b><br>
                <br>
                <br>
                <br>
                <b><u>{{ $laporan->pembedah }}</u></b><br>
                Tanda Tangan dan Nama Jelas
            </td>
        </tr>
    </table>

    <style>
        @page {
            size: 'A4';
            /* Misalnya ukuran A4 */
        }
    </style>
@endsection
