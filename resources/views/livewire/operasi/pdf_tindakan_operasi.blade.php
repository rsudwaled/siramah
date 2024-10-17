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
                <b>PEMBERIAN INFORMASI TINDAKAN OPERASI</b>
            </td>
        </tr>
    </table>
    <table class="table table-sm table-bordered" style="font-size: 11px;">
        <tr>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>Dokter Pelaksana Operasi</td>
                        <td>:</td>
                        <th>{{ $tindakan->dokter_pelaksana ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Nama Pemberi Informasi</td>
                        <td>:</td>
                        <th>{{ $tindakan->pemberi_informasi ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <th>{{ $tindakan->jabatan ?? '-' }}</th>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="table-borderless">
                    <tr>
                        <td>Nama Penerima Informasi</td>
                        <td>:</td>
                        <th>{{ $tindakan->penerima_informasi ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Hubungan dengan Pasien</td>
                        <td>:</td>
                        <th>{{ $tindakan->hubungan_pasien ?? '-' }}</th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table table-sm table-bordered" style="font-size: 11px;">
        <tr>
            <th width="4%" class="text-center">No.</th>
            <th width="20%" class="text-center">Jenis Informasi</th>
            <th width="66%" class="text-center">Isi Informasi</th>
            <th width="10%" class="text-center">Paraf</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Diagnosa (WD & DD)</td>
            <td>
                <pre>{{ $tindakan->diagnosa }}</pre>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Dasar Diagnosa</td>
            <td>
                <pre>{{ $tindakan->dasar_diagnosa }}</pre>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Tindakan Kedokteran</td>
            <td>
                <pre>{{ $tindakan->tindakan_kedokteran }}</pre>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Indikasi TIndakan</td>
            <td>
                <pre>{{ $tindakan->indikasi_tindakan }}</pre>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>5</td>
            <td>Tata Cara</td>
            <td>
                <pre>{{ $tindakan->tata_cara }}</pre>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>6</td>
            <td>Tujuan</td>
            <td>
                <pre>{{ $tindakan->tujuan }}</pre>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>7</td>
            <td>Resiko</td>
            <td>
                <pre>{{ $tindakan->resiko }}</pre>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>8</td>
            <td>Komplikasi</td>
            <td>
                <pre>{{ $tindakan->komplikasi }}</pre>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>9</td>
            <td>Prognosis</td>
            <td>
                <pre>{{ $tindakan->prognosis }}</pre>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>10</td>
            <td>Alternatif & Resiko</td>
            <td>
                <pre>{{ $tindakan->alternatif_resiko }}</pre>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>11</td>
            <td>Lain-lain</td>
            <td>
                <pre>{{ $tindakan->lainnya }}</pre>
            </td>
            <td></td>
        </tr>
    </table>
    <table class="table table-sm table-bordered" style="font-size: 11px;">
        <tr>
            <td width="70%">
                Dengan ini menyatakan bahwa saya (Dokter) telah menerangkan hal-hal diatas secara benar, jelas dan
                memberikan kesempatan untuk bertanya dan atau berdiskusi.
            </td>
            <td width="30%" class="text-center">

                <b>Dokter</b> <br>
                <br>
                <br>
                <b><u>{{ $tindakan->ttd_dokter ?? 'Dokter' }}</u></b><br>
                Tanda tangan dan nama jelas
            </td>
        </tr>
        <tr>
            <td width="70%">
                Dengan ini menyatakan bahwa saya (Pasien/Keluarga Pasien*) telah menerima informasi dari dokter sebagaimana
                diatas dan telah memahaminya. memberikan kesempatan untuk bertanya dan atau berdiskusi.
            </td>
            <td width="30%" class="text-center">

                <b>Pasien / Keluarga Pasien</b> <br>
                <br>
                <br>
                <b><u>{{ $tindakan->ttd_pasien ?? 'Pasien' }}</u></b><br>
                Tanda tangan dan nama jelas
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
