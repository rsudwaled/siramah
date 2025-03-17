<table>
    <thead>
        <tr>
            <th colspan="22" style="text-align: center; font-size: 18px; font-weight: bold;">KARTU INDEX DOKTER</th>
        </tr>
        <tr>
            <th colspan="22" style="text-align: center;">Dokter: {{ $dokterFind->nama_paramedis }}</th>
        </tr>
        <tr>
            <th colspan="22" style="text-align: center;">Bulan: {{ $bulanSelesai }} Tahun: {{ $tahunSelesai }}</th>
        </tr>
        <tr>
            <th>No</th>
            <th>No RM</th>
            <th>Pasien</th>
            <th>Poliklinik</th>
            <th>28H (L)</th>
            <th>28H (P)</th>
            <th>
                < 1TH (L)</th>
            <th>
                < 1TH (P)</th>
            <th>1-5 (L)</th>
            <th>1-5 (P)</th>
            <th>5-14 (L)</th>
            <th>5-14 (P)</th>
            <th>15-24 (L)</th>
            <th>15-24 (P)</th>
            <th>25-44 (L)</th>
            <th>25-44 (P)</th>
            <th>45-64 (L)</th>
            <th>45-64 (P)</th>
            <th>> 65 (L)</th>
            <th>> 65 (P)</th>
            <th>Kunjungan</th>
            <th>Diagnosa</th>
            <th>Ket</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($findReport as $index => $report)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $report->no_rm }}</td>
                <td>{{ $report->nama_px }}</td>
                <td>{{ $report->nama_unit ?? '-' }}</td>
                <td>{{ isset($report->age_group) && $report->age_group == '0_28HL' ? '1' : '-' }}</td>
                <td>{{ isset($report->age_group) && $report->age_group == '0_28HP' ? '1' : '-' }}</td>
                <td>{{ isset($report->age_group) && $report->age_group == 'kurang_1TL' ? '1' : '-' }}</td>
                <td>{{ isset($report->age_group) && $report->age_group == 'kurang_1TP' ? '1' : '-' }}</td>

                <td>{{  isset($report->age_group) && $report->age_group == '1_5TL' ? '1' : '-' }}</td>
                <td>{{  isset($report->age_group) && $report->age_group == '1_5TP' ? '1' : '-' }}</td>
                <td>{{  isset($report->age_group) && $report->age_group == '5_14TL' ? '1' : '-' }}</td>
                <td>{{  isset($report->age_group) && $report->age_group == '5_14TP' ? '1' : '-' }}</td>
                <td>{{  isset($report->age_group) && $report->age_group == '15_24TL' ? '1' : '-' }}</td>
                <td>{{  isset($report->age_group) && $report->age_group == '15_24TP' ? '1' : '-' }}</td>
                <td>{{  isset($report->age_group) && $report->age_group == '25_44TL' ? '1' : '-' }}</td>
                <td>{{  isset($report->age_group) && $report->age_group == '25_44TP' ? '1' : '-' }}</td>
                <td>{{  isset($report->age_group) && $report->age_group == '45_64TL' ? '1' : '-' }}</td>
                <td>{{  isset($report->age_group) && $report->age_group == '45_64TP' ? '1' : '-' }}</td>
                <td>{{  isset($report->age_group) && $report->age_group == 'lebih_65TL' ? '1' : '-' }}</td>
                <td>{{  isset($report->age_group) && $report->age_group == 'lebih_65TP' ? '1' : '-' }}</td>
                <td>In: {{ \Carbon\Carbon::parse($report->tgl_masuk)->format('d-m-Y') }}<br>Out:
                    {{ \Carbon\Carbon::parse($report->tgl_keluar)->format('d-m-Y') }}</td>
                <td>Utama: {{ $report->diag_utama_desc ?? '-' }}<br>Sekunder:
                    {{ $report->diag_sekunder1_desc ?? '-' }}</td>
                <td>-</td>
            </tr>
        @endforeach
    </tbody>
</table>
