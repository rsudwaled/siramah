<table class="table table-sm" style="text-align: center;">
    <thead>
        <tr>
            <td >Nmr</td>
            <td >DESKRIPSI</td>
            <td>NO_RM</td>
            <td >NAMA_PASIEN</td>
            <td >NIK</td>
            <td >TGL LAHIR</td>
            <td>KELAS</td>
            <td>KODEICD</td>
            <td>DIAGNOSA_SEK</td>
            <td >ALAMAT</td>
            <td>TGL_MASUK</td>
            <td>TGL_KELUAR</td>
            <td>KUNJUNGAN_BARU</td>
            <td>KUNJUNGAN_LAMA</td>
            <td>U0_28HRL</td>
            <td>U0_28HRP</td>
            <td>U28_1THL</td>
            <td>U28_1THP</td>
            <td>U1_4THL</td>
            <td>U1_4THP</td>
            <td>U5_14THL</td>
            <td>U5_14THP</td>
            <td>U15_24THL</td>
            <td>U15_24THP</td>
            <td>U25_44THL</td>
            <td>U25_44THP</td>
            <td>U45_59THL</td>
            <td>U45_59THP</td>
            <td>U60_64THL</td>
            <td>U60_64THP</td>
            <td>ULB65THL</td>
            <td>ULB65THP</td>
            <td>DPJP</td>
            <td >TERAPI</td>
            <td >DESA</td>
            <td >KECAMATAN</td>
            <td >KOTA</td>
            <td >umur</td>
            <td >jenis_kelamin</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($lprjByYears as $item)
            <tr>
                <td >{{$item->Nmr}}</td>
                <td >{{$item->DESKRIPSI}}</td>
                <td>{{$item->NO_RM}}</td>
                <td >{{$item->NAMA_PASIEN}}</td>
                <td>{{ '`'.$item->NIK }} </td>
                <td>{{Carbon\Carbon::parse($item->TGL_LAHIR)->format('d-m-Y')}} </td>
                <td>{{$item->KELAS}}</td>
                <td>{{$item->KODEICD}}</td>
                <td>{{$item->DIAGNOSA_SEK }}</td>
                <td >{{$item->ALAMAT}}</td>
                <td>{{$item->TGL_MASUK}}</td>
                <td>{{$item->TGL_KELUAR}}</td>
                <td>{{$item->KUNJUNGAN_BARU }}</td>
                <td>{{$item->KUNJUNGAN_LAMA }}</td>
                <td>{{$item->U0_28HRL}}</td>
                <td>{{$item->U0_28HRP}}</td>
                <td>{{$item->U28_1THL}}</td>
                <td>{{$item->U28_1THP}}</td>
                <td>{{$item->U1_4THL}}</td>
                <td>{{$item->U1_4THP}}</td>
                <td>{{$item->U5_14THL}}</td>
                <td>{{$item->U5_14THP}}</td>
                <td>{{$item->U15_24THL}}</td>
                <td>{{$item->U15_24THP}}</td>
                <td>{{$item->U25_44THL}}</td>
                <td>{{$item->U25_44THP}}</td>
                <td>{{$item->U45_59THL}}</td>
                <td>{{$item->U45_59THP}}</td>
                <td>{{$item->U60_64THL}}</td>
                <td>{{$item->U60_64THP}}</td>
                <td>{{$item->ULB65THL}}</td>
                <td>{{$item->ULB65THP}}</td>
                <td>{{$item->DPJP}}</td>
                <td >{{$item->TERAPI}}</td>
                <td >{{$item->DESA}}</td>
                <td >{{$item->KECAMATAN}}</td>
                <td >{{$item->KOTA}}</td>
                <td >{{$item->umur}}</td>
                <td >{{$item->jenis_kelamin}}</td>
            </tr>
        @endforeach

    </tbody>
</table>
