@php
$staticKelompokUmur = [
    'Kurang dari 1 jam',
    '1 menit - 23 jam',
    '1-7 hari',
    '8-28 hari',
    '29 hari-3 bulan',
    '3-6 bulan',
    '6-11 bulan',
    '1-4 tahun',
    '5-9 tahun',
    '10-14 tahun',
    '15-19 tahun',
    '20-24 tahun',
    '25-29 tahun',
    '30-34 tahun',
    '35-39 tahun',
    '40-44 tahun',
    '45-49 tahun',
    '50-54 tahun',
    '55-59 tahun',
    '60-64 tahun',
    '65-69 tahun',
    '70-74 tahun',
    '75-79 tahun',
    '80-84 tahun',
    '85+ tahun',
];
@endphp

<table class="table table-bordered table-sm" style="text-align: center;">
    <thead>
        <tr>
            <td colspan="2"> <strong>Tanggal : {{\Carbon\Carbon::parse($start)->format('d-m-Y')}} s.d {{\Carbon\Carbon::parse($end)->format('d-m-Y')}}</strong> </td>
        </tr>
        <tr>
            <td colspan="2"> <strong>KOMPILASI PENYAKIT/MORBIDITAS PASIEN RAWAT INA</strong> </td>
        </tr>
        <tr>
            <th rowspan="2"><strong>Kode Diagnosa</strong></th>
            <th rowspan="2"><strong>Deskripsi Diagnosa</strong></th>
            @foreach ($staticKelompokUmur as $kelompok)
                <th colspan="2" style="text-align: center"><strong>{{ $kelompok }}</strong></th>
            @endforeach
            <th colspan="5" style="text-align: center"><strong>Rekap Keluar</strong></th>
        </tr>
        <tr>
            @foreach ($staticKelompokUmur as $kelompok)
                <th style="text-align: center"><strong>L</strong></th>
                <th style="text-align: center"><strong>P</strong></th>
            @endforeach
            <th style="text-align: center"><strong>Hidup L</strong></th>
            <th style="text-align: center"><strong>Hidup P</strong></th>
            <th style="text-align: center"><strong>Meninggal L</strong></th>
            <th style="text-align: center"><strong>Meninggal P</strong></th>
            <th style="text-align: center"><strong>Total</strong></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($dataGabungan as $kode => $item)
            @php
                $rekap = $item['rekap'] ?? [];
                $hidupL = $item['rekap_status']['Hidup']['L'] ?? 0;
                $hidupP = $item['rekap_status']['Hidup']['P'] ?? 0;
                $matiL = $item['rekap_status']['Meninggal']['L'] ?? 0;
                $matiP = $item['rekap_status']['Meninggal']['P'] ?? 0;
                $total = $hidupL + $hidupP + $matiL + $matiP;
            @endphp
            <tr>
                <td>{{ $kode }}</td>
                <td>{{ $item['diag_utama_desc'] }}</td>
                @foreach ($staticKelompokUmur as $kelompok)
                    <td style="text-align: center">{{ $rekap[$kelompok]['L'] ?? '-' }}</td>
                    <td style="text-align: center">{{ $rekap[$kelompok]['P'] ?? '-' }}</td>
                @endforeach
                <td style="text-align: center">{{ $hidupL }}</td>
                <td style="text-align: center">{{ $hidupP }}</td>
                <td style="text-align: center">{{ $matiL }}</td>
                <td style="text-align: center">{{ $matiP }}</td>
                <td style="text-align: center"><strong>{{ $total }}</strong></td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ 2 + count($staticKelompokUmur) * 2 + 5 }}">Tidak ada data tersedia</td>
            </tr>
        @endforelse
    </tbody>
</table>
