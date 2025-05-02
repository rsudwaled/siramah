<table style="border: 1px solid black;" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>Tanggal:  </th>
            <th>{{\Carbon\Carbon::parse($start)->format('d/m/Y')}} - s.d {{\Carbon\Carbon::parse($end)->format('d/m/Y')}}</th>
        </tr>
        <tr>
            <th rowspan="2" style="border: 1px solid rgb(140, 140, 140);">Kode</th>
            <th rowspan="2" style="border: 1px solid rgb(140, 140, 140);">Diagnosa</th>
            {{-- Header kelompok umur --}}
            @foreach ($kelompokUmurList as $umur)
                <th colspan="2" style="border: 1px solid rgb(140, 140, 140);">{{ $umur }}</th>
            @endforeach
            <th rowspan="2" style="border: 1px solid rgb(140, 140, 140);">Total Kasus Baru (L)</th>
            <th rowspan="2" style="border: 1px solid rgb(140, 140, 140);">Total Kasus Baru (P)</th>
            <th rowspan="2" style="border: 1px solid rgb(140, 140, 140);">Total Kunjungan Baru (L)</th>
            <th rowspan="2" style="border: 1px solid rgb(140, 140, 140);">Total Kunjungan Baru (P)</th>
        </tr>
        <tr>
            {{-- Sub header untuk L/P --}}
            @foreach ($kelompokUmurList as $umur)
                <th style="border: 1px solid rgb(140, 140, 140);">L</th>
                <th style="border: 1px solid rgb(140, 140, 140);">P</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($rekap as $kode_diag => $data)
            @php
                // Inisialisasi total per jenis kelamin (L/P) untuk kolom kanan
                $totalKunjunganL = 0;
                $totalKasusL = 0;
                $totalKunjunganP = 0;
                $totalKasusP = 0;
            @endphp

            <tr style="border: 1px solid rgb(140, 140, 140);">
                <td style="border: 1px solid rgb(140, 140, 140);">
                    {{ $kode_diag }}
                </td>
                <td style="border: 1px solid rgb(140, 140, 140);">
                    <small>{{ implode(', ', $data['deskripsi']) }}</small>
                </td>

                {{-- Iterasi kelompok umur --}}
                @foreach ($kelompokUmurList as $umur)
                    {{-- @php
                        // Ambil data untuk Laki-laki dan Perempuan
                        $laki = $data['L'][$umur] ?? ['total_kasus_baru' => 0];
                        $perempuan = $data['P'][$umur] ?? ['total_kasus_baru' => 0];

                        // Update total kasus per jenis kelamin
                        $totalKasusL += $laki['total_kasus_baru'];
                        $totalKasusP += $perempuan['total_kasus_baru'];
                    @endphp --}}

                    @php
                        // Ambil data untuk Laki-laki dan Perempuan
                        $laki = $data['L'][$umur] ?? ['total_kunjungan_baru' => 0, 'total_kasus_baru' => 0];
                        $perempuan = $data['P'][$umur] ?? ['total_kunjungan_baru' => 0, 'total_kasus_baru' => 0];

                        // Update total per jenis kelamin
                        $totalKunjunganL += $laki['total_kunjungan_baru'];
                        $totalKasusL += $laki['total_kasus_baru'];
                        $totalKunjunganP += $perempuan['total_kunjungan_baru'];
                        $totalKasusP += $perempuan['total_kasus_baru'];
                    @endphp
                    {{-- Tampilkan hanya kasus baru untuk Laki-laki dan Perempuan --}}
                    <td style="border: 1px solid rgb(140, 140, 140);">
                        {{ $laki['total_kasus_baru'] == 0 ? '-' : $laki['total_kasus_baru'] }}
                    </td>
                    <td style="border: 1px solid rgb(140, 140, 140);">
                        {{ $perempuan['total_kasus_baru'] == 0 ? '-' : $perempuan['total_kasus_baru'] }}
                    </td>
                @endforeach

                {{-- Kolom total kunjungan baru dan kasus baru per jenis kelamin --}}
                <td style="border: 1px solid rgb(140, 140, 140);">
                    <strong>{{ $totalKasusL == 0 ? '-' : $totalKasusL }}</strong></td>
                <td style="border: 1px solid rgb(140, 140, 140);">
                    <strong>{{ $totalKasusP == 0 ? '-' : $totalKasusP }}</strong></td>
                <td style="border: 1px solid rgb(140, 140, 140);">
                    <strong>{{ $totalKunjunganL == 0 ? '-' : $totalKunjunganL }}</strong></td>
                <td style="border: 1px solid rgb(140, 140, 140);">
                    <strong>{{ $totalKunjunganP == 0 ? '-' : $totalKunjunganP }}</strong></td>
            </tr>
        @endforeach
    </tbody>
</table>
