
<table class="table table-sm" style="text-align: center;">
    <thead>
        <tr>
            <td></td>
            <td></td>
            <td rowspan="5" style="vertical-align : middle;text-align:center; "></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="14" style="vertical-align : middle;text-align:center; font-weight: bold;">SURVEILANS TERPADU PENYAKIT RAWAT INAP</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="14" style="vertical-align : middle;text-align:center; font-weight: bold;"> ( KASUS TERPADU )</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="font-weight: bold;">Provinsi</td>
            <td style="font-weight: bold;">:</td>
            <td style="font-weight: bold;" colspan="3">Jawa Barat</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="font-weight: bold;" colspan="2">Tahun</td>
            <td style="font-weight: bold;">:</td>
            <td style="font-weight: bold; text-align:right;">{{$th}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="font-weight: bold;">Kabupaten</td>
            <td style="font-weight: bold;">:</td>
            <td style="font-weight: bold;" colspan="3">Cirebon</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="font-weight: bold;" colspan="2">Bulan</td>
            <td style="font-weight: bold;">:</td>
            <td style="font-weight: bold; text-align:right;">{{$periode}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="font-weight: bold;">Rumah Sakit</td>
            <td style="font-weight: bold;">:</td>
            <td style="font-weight: bold;" colspan="3">RSUD WALED</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="font-weight: bold;">Jumlah Kunjungan</td>
            <td style="font-weight: bold;">:</td>
            <td style="font-weight: bold; text-align:right;">{{$sumLds->sum('TOTAL_KUNJUNGAN') ==0 ? '-' : $sumLds->sum('TOTAL_KUNJUNGAN') }}</td>
        </tr>
        <tr>
            <td rowspan="2" style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">NO</td>
            <td rowspan="2" style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;" >KODE</td>
            <td rowspan="2" style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;" >JENIS PENYAKIT</td>
            <td colspan="2" style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;" >TOTAL KB</td>
            <td colspan="2" style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;" >MATI</td>
            <td colspan="12" style="vertical-align : middle;text-align:center; border:1px solid black font-weight: bold;; ">KELOMPOK UMUR</td>
            <td rowspan="2" style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;" >TOTAL KUNJUNGAN</td>
        </tr>
        <tr>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">L</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">P</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">KR48J</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">LB48J</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">U0_7HR</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">U8_28HR</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">UKR_1TH</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">U1_4TH</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">U5_9TH</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">U10_14TH</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">15_19TH</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">U20_24TH</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">U25_54TH</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">U55_59TH</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">U60_69TH</td>
            <td style="vertical-align : middle;text-align:center; border:1px solid black; font-weight: bold;">ULB_70TH</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($lds as $item)
            <tr>
                <td style="vertical-align : middle;text-align:center; border:1px solid black;">{{$loop->iteration}}</td>
                <td style="vertical-align : middle;text-align:center; border:1px solid black;">{{$item->KODE}}</td>
                <td style="vertical-align : middle;text-align:center; border:1px solid black;">{{$item->DIAG_UTAMA}}</td>
                <td style="text-align:center; border:1px solid black;">{{$item->TOTAL_KB_L == 0 ? '-' : $item->TOTAL_KB_L }}</td>
                <td style="text-align:center; border:1px solid black;">{{$item->TOTAL_KB_P == 0 ? '-' : $item->TOTAL_KB_P }}</td>
                <td style="text-align:center; border:1px solid black;">{{$item->MATI_KR48J == 0 ? '-' : $item->MATI_KR48J }}</td>
                <td style="text-align:center; border:1px solid black;">{{$item->MATI_LB48J == 0 ? '-' : $item->MATI_LB48J }}</td>

                <td style="text-align:center; border:1px solid black;"> {{$item->U0_7HR == 0 ? '-' : $item->U0_7HR }}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->U8_28HR == 0 ? '-' : $item->U8_28HR }}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->UKR_1TH == 0 ? '-' : $item->UKR_1TH }}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->U1_4TH == 0 ? '-' : $item->U1_4TH }}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->U5_9TH == 0 ? '-' : $item->U5_9TH }}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->U10_14TH == 0 ? '-' : $item->U10_14TH }}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->U15_19TH == 0 ? '-' : $item->U15_19TH }}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->U20_24TH == 0 ? '-' : $item->U20_24TH }}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->U25_54TH == 0 ? '-' : $item->U25_54TH }}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->U55_59TH == 0 ? '-' : $item->U55_59TH }}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->U60_69TH == 0 ? '-' : $item->U60_69TH }}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->ULB_70TH == 0 ? '-' : $item->ULB_70TH}}</td>
                <td style="text-align:center; border:1px solid black;"> {{$item->TOTAL_KUNJUNGAN == 0 ? '-' : $item->TOTAL_KUNJUNGAN}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="text-align:center; border:1px solid black; font-weight: bold;">Jumlah Total</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;">{{$sumLds->sum('TOTAL_KB_L') ==0 ? '-' : $sumLds->sum('TOTAL_KB_L')}}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;">{{$sumLds->sum('TOTAL_KB_P') ==0 ? '-' : $sumLds->sum('TOTAL_KB_P')}}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;">{{$sumLds->sum('MATI_KR48J') ==0 ? '-' : $sumLds->sum('MATI_KR48J')}}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;">{{$sumLds->sum('MATI_LB48J') ==0 ? '-' : $sumLds->sum('MATI_LB48J')}}</td>

            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('U0_7HR') ==0 ? '-' : $sumLds->sum('U0_7HR')}}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('U8_28HR') ==0 ? '-' : $sumLds->sum('U8_28HR')}}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('UKR_1TH') ==0 ? '-' : $sumLds->sum('UKR_1TH')}}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('U1_4TH') ==0 ? '-' : $sumLds->sum('U1_4TH')}}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('U5_9TH') ==0 ? '-' : $sumLds->sum('U5_9TH')}}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('U10_14TH') ==0 ? '-' : $sumLds->sum('U10_14TH') }}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('U15_19TH') ==0 ? '-' : $sumLds->sum('U15_19TH') }}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('U20_24TH') ==0 ? '-' : $sumLds->sum('U20_24TH') }}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('U25_54TH') ==0 ? '-' : $sumLds->sum('U25_54TH') }}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('U55_59TH') ==0 ? '-' : $sumLds->sum('U55_59TH') }}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('U60_69TH') ==0 ? '-' : $sumLds->sum('U60_69TH') }}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('ULB_70TH') ==0 ? '-' : $sumLds->sum('ULB_70TH') }}</td>
            <td style="text-align:center; border:1px solid black; font-weight: bold;"> {{$sumLds->sum('TOTAL_KUNJUNGAN') ==0 ? '-' : $sumLds->sum('TOTAL_KUNJUNGAN') }}</td>
        </tr>
    </tbody>
</table>
