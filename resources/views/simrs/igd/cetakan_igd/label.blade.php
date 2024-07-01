@php
    use Carbon\Carbon;
@endphp
<table>
    @for ($i = 0; $i < 4; $i++)
        @php $pasien = $pasien; @endphp
        <tr>
            <td style="padding-left:40px;">
                <table cellspacing="0" cellpadding="5">
                    <tr>
                        <th style="width: 6cm; height:3cm">
                            <div class="col-lg-12">
                                <div class="row"
                                    style=" text-align:left; font-size:10px; font-family: sans-serif; display: grid; grid-template-columns: 1fr 1fr;">
                                    <div class="col-lg-5">
                                        {{ $pasien->no_rm }}<br>
                                        {{ $pasien->nama_px }}<br><br><br>
                                        {{ $pasien->tempat_lahir }}, {{ Carbon::parse($pasien->tgl_lahir)->format('d/M/Y') }}<br>
                                        {{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}<br>
                                    </div>
                                    <div class="col-lg-4" style="text-align:right; margin-top:-30px;">
                                        <img src="data:image/png;base64,{{ $qrcode }}" style="width: 30px; height:30px; padding-right:10px;">
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </table>
            </td>
            <td style="padding-left:2px;">
                <table cellspacing="0" cellpadding="5">
                    <tr>
                        <th style="width: 6cm; height:3cm">
                            <div class="col-lg-12">
                                <div class="row"
                                    style=" text-align:left; font-size:10px; font-family: sans-serif; display: grid; grid-template-columns: 1fr 1fr;">
                                    <div class="col-lg-4">
                                        {{ $pasien->no_rm }}<br>
                                        {{ $pasien->nama_px }}<br><br><br>
                                        {{ $pasien->tempat_lahir }}, {{ Carbon::parse($pasien->tgl_lahir)->format('d/M/Y') }}<br>
                                        {{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}<br>
                                    </div>
                                    <div class="col-lg-4" style="text-align:right; margin-top:-30px;">
                                        <img src="data:image/png;base64,{{ $qrcode }}" style="width: 30px; height:30px; padding-right:10px;">
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </table>
            </td>
            <td style="padding-left:3px;">
                <table cellspacing="0" cellpadding="5">
                    <tr>
                        <th style="width: 6cm; height:3cm">
                            <div class="col-lg-12">
                                <div class="row"
                                    style=" text-align:left; font-size:10px; font-family: sans-serif; display: grid; grid-template-columns: 1fr 1fr;">
                                    <div class="col-lg-4" style="padding-left: 7px;">
                                        {{ $pasien->no_rm }}<br>
                                        {{ $pasien->nama_px }}<br><br><br>
                                        {{ $pasien->tempat_lahir }}, {{ Carbon::parse($pasien->tgl_lahir)->format('d/M/Y') }}<br>
                                        {{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}<br>
                                    </div>
                                    <div class="col-lg-4" style="text-align:right; margin-top:-30px;">
                                        <img src="data:image/png;base64,{{ $qrcode }}" style="width: 30px; height:30px; padding-right:10px;">
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

