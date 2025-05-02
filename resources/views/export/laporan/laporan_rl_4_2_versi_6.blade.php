@php
    $totalHidupL = 0;
    $totalHidupP = 0;
    $totalMatiL = 0;
    $totalMatiP = 0;
@endphp
<table class="table table-bordered table-sm" style="text-align: center;">
    <thead>
        <tr>
            <td colspan="2"> <strong>Tanggal : {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} s.d
                    {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</strong> </td>
        </tr>
        <tr>
            <td colspan="2"> <strong>10 BESAR PENYAKIT RAWAT INAP</strong> </td>
        </tr>
        <tr>
            <th rowspan="2"><strong>Kode Diagnosa</strong></th>
            <th rowspan="2"><strong>Deskripsi Diagnosa</strong></th>
            <th colspan="3" style="text-align: center"><strong>Jumlah Pasien Hidup dan Mati</strong></th>
            <th colspan="3" style="text-align: center"><strong>Jumlah Pasien Keluar Mati</strong></th>
        </tr>
        <tr>
            <th style="text-align: center"><strong>L</strong></th>
            <th style="text-align: center"><strong>P</strong></th>
            <th style="text-align: center"><strong>Total</strong></th>
            <th style="text-align: center"><strong>L</strong></th>
            <th style="text-align: center"><strong>P</strong></th>
            <th style="text-align: center"><strong>Total</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach($sortedData as $kode => $detail)
            @php
                $hidupL = $detail['rekap_status']['Hidup']['L'] ?? 0;
                $hidupP = $detail['rekap_status']['Hidup']['P'] ?? 0;
                $hidupTotal = $hidupL + $hidupP;

                $matiL = $detail['rekap_status']['Meninggal']['L'] ?? 0;
                $matiP = $detail['rekap_status']['Meninggal']['P'] ?? 0;
                $matiTotal = $matiL + $matiP;

                // Tambahkan ke total keseluruhan
                $totalHidupL += $hidupL;
                $totalHidupP += $hidupP;
                $totalMatiL += $matiL;
                $totalMatiP += $matiP;
            @endphp
            <tr>
                <td>{{ $kode }}</td>
                <td>{{ $detail['diag_utama_desc'] }}</td>
                <td>{{ $hidupL }}</td>
                <td>{{ $hidupP }}</td>
                <td>{{ $hidupTotal }}</td>
                <td>{{ $matiL }}</td>
                <td>{{ $matiP }}</td>
                <td>{{ $matiTotal }}</td>
            </tr>
        @endforeach

        {{-- Tambahkan baris total di bagian bawah --}}
        @php
            $totalHidup = $totalHidupL + $totalHidupP;
            $totalMati = $totalMatiL + $totalMatiP;
        @endphp
        <tr style="font-weight: bold; background-color: #f0f0f0;">
            <td colspan="2"><strong>TOTAL</strong></td>
            <td><strong>{{ $totalHidupL }}</strong></td>
            <td><strong>{{ $totalHidupP }}</strong></td>
            <td><strong>{{ $totalHidup }}</strong></td>
            <td><strong>{{ $totalMatiL }}</strong></td>
            <td><strong>{{ $totalMatiP }}</strong></td>
            <td><strong>{{ $totalMati }}</strong></td>
        </tr>
    </tbody>
</table>
