@extends('simrs.erm-ranap.template_print.pdf_print')
@section('title', 'Asesmen Awal Rawat Inap')
@section('content')
    @include('simrs.erm-ranap.template_print.pdf_kop_surat')
    @if ($konsultasi)
        <table class="table table-sm" style="font-size: 11px; width:100%; height:80%; border:1px solid black;">
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-center">
                    <b>KONSULTASI</b><br>
                </td>
            </tr>
            <tr style="height: 50%">
                <td colspan="2" style="border:1px solid black; height: 40%">
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td colspan="2" style="border: none; text-align: right;">Tanggal:
                                {{ $konsultasi->tanggal_konsultasi }} Pkl: {{ $konsultasi->waktu_konsultasi }} WIB</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none; width: 100%; height: 25%;">
                                <strong>Kepada Yth:</strong> <br>
                                <p style="width: 100%; margin: 0; padding: 0;">
                                    Dr. {{ $konsultasi->tujuan_konsul }} <br>
                                    <span>Spesialis:
                                        {{ $konsultasi->spesialis ?? '........................' }}</span> <br>
                                </p> <br>
                                <strong>Mohon : </strong>
                                <table width="100%" style="margin-top: -8px;">
                                    <td style="text-align: left;">
                                        @if ($konsultasi->jenis_konsul === 'konsul_untuk_kondisi_saat_ini')
                                            <span
                                                style="font-family: DejaVu Sans, sans-serif;  font-size:16px;">&#x2611;</span>
                                        @else
                                            <input type="checkbox" id="konsultasi_kondisi_saat_ini_checkbox"
                                                style="vertical-align: middle;">
                                        @endif
                                        <label for="konsultasi_kondisi_saat_ini_checkbox">Konsultasi untuk kondisi saat
                                            ini</label>
                                    </td>

                                    <td style="text-align: left;">
                                        @if ($konsultasi->jenis_konsul === 'alih_rawat')
                                            <span
                                                style="font-family: DejaVu Sans, sans-serif;  font-size:16px;">&#x2611;</span>
                                        @else
                                            <input type="checkbox" id="alih_rawat_checkbox" style="vertical-align: middle;">
                                        @endif
                                        <label for="alih_rawat_checkbox" style="vertical-align: middle;">Alih Rawat</label>
                                    </td>
                                    <td style="text-align: left;">
                                        @if ($konsultasi->jenis_konsul === 'tim_medis')
                                            <span
                                                style="font-family: DejaVu Sans, sans-serif;  font-size:16px;">&#x2611;</span>
                                        @else
                                            <input type="checkbox" id="tim_medis_checkbox" style="vertical-align: middle;">
                                        @endif
                                        <label for="tim_medis_checkbox" style="vertical-align: middle;">Tim Medis, Sebagai
                                            DPJP: dr.
                                            {{ $konsultasi->tim_medis_dokter ?? '.............................' }}</label>
                                    </td>
                                </table>
                                <br>
                                <br>
                                <strong>Pasien dengan:</strong> <br>
                                <p style="width: 100%; margin: 0; padding: 0;">
                                    {{ $konsultasi->keterangan ?? null }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none; text-align: right; width: 100%;">
                                <div style="text-align: center; float: right;">
                                    Salam Sejawat, <br><br><br><br><br>
                                    (.........................) <br>
                                    Tanda Tangan & Nama Jelas
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="height: 50%">
                <td colspan="2" widht="100%" style="border:1px solid black; height: 40%">
                    JAWABAN KONSUL: <br>
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td colspan="2" style="border: none; width: 100%; height: 25%;">
                                <strong>Yth TS:</strong> <br>
                                <br><br>
                                <p style="width: 100%; margin: 0; padding: 0;">
                                    {{ $konsultasi->keterangan ?? null }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none; text-align: right; width: 100%;">
                                <div style="text-align: center; float: right;">
                                    Tanggal: {{ $konsultasi->tanggal_konsultasi }} Pkl: {{ $konsultasi->waktu_konsultasi }}
                                    WIB <br><br>
                                    Salam Sejawat, <br><br><br><br><br>
                                    (.........................) <br>
                                    Tanda Tangan & Nama Jelas
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    @else
        <table class="table table-sm table-bordered" style="font-size: 11px">
            <table class="table table-sm table-bordered" style="font-size: 11px">
                <tr style="background-color: #ffc107">
                    <td width="100%" class="text-center">
                        <b>KONSULTASI</b><br>
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
