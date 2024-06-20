@php
    use Carbon\Carbon;
@endphp
<table>
    @for ($i = 0; $i < 4; $i++)
        @php $pasien = $pasien; @endphp
        <tr>
            <td style="padding-left:6px;">
                <table border="1" cellspacing="0" cellpadding="5" style="margin-top: 5px;">
                    <tr style="margin-top: 2px;">
                        <th style="width: 200px;">
                            <div class="col-lg-12">
                                <div class="row"
                                    style="width: 60mm; height:28mm; text-align:left; font-size:12px; font-family: sans-serif; display: grid; grid-template-columns: 1fr 1fr;">
                                    <div class="col-lg-6">
                                        {{ $pasien->no_rm }}<br>
                                        {{ $pasien->nama_px }}<br><br><br>
                                        {{ $pasien->tempat_lahir }}, {{ Carbon::parse($pasien->tgl_lahir)->format('d/M/Y') }}<br>
                                        {{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}<br>
                                    </div>
                                    <div class="col-lg-6" style="text-align:right; margin-top:-30px;">
                                        <img src="data:image/png;base64,{{ $qrcode }}">
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </table>
            </td>
            <td style="padding-left:6px;">
                <table border="1" cellspacing="0" cellpadding="5" style="margin-top: 5px;">
                    <tr style="margin-top: 2px;">
                        <th style="width: 200px;">
                            <div class="col-lg-12">
                                <div class="row"
                                    style="width: 60mm; height:28mm; text-align:left; font-size:12px; font-family: sans-serif; display: grid; grid-template-columns: 1fr 1fr;">
                                    <div class="col-lg-6">
                                        {{ $pasien->no_rm }}<br>
                                        {{ $pasien->nama_px }}<br><br><br>
                                        {{ $pasien->tempat_lahir }}, {{ Carbon::parse($pasien->tgl_lahir)->format('d/M/Y') }}<br>
                                        {{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}<br>
                                    </div>
                                    <div class="col-lg-6" style="text-align:right; margin-top:-30px;">
                                        <img src="data:image/png;base64,{{ $qrcode }}">
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </table>
            </td>
            <td style="padding-left:7px;">
                <table border="1" cellspacing="0" cellpadding="5" style="margin-top: 5px;">
                    <tr style="margin-top: 2px;">
                        <th style="width: 200px;">
                            <div class="col-lg-12">
                                <div class="row"
                                    style="width: 60mm; height:28mm; text-align:left; font-size:12px; font-family: sans-serif; display: grid; grid-template-columns: 1fr 1fr;">
                                    <div class="col-lg-6">
                                        {{ $pasien->no_rm }}<br>
                                        {{ $pasien->nama_px }}<br><br><br>
                                        {{ $pasien->tempat_lahir }}, {{ Carbon::parse($pasien->tgl_lahir)->format('d/M/Y') }}<br>
                                        {{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}<br>
                                    </div>
                                    <div class="col-lg-6" style="text-align:right; margin-top:-30px;">
                                        <img src="data:image/png;base64,{{ $qrcode }}">
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </table>
            </td>
        </tr>
    @endfor
</table>
<style>
    @page { margin: 0px; }
    body { margin: 3px; }
</style>

