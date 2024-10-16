<table>
    <thead>
        <tr>
            <th>No. RM</th>
            <th>Nama Pasien</th>
            <th>Umur</th>
            <th>Jenis Kelamin</th>
            <th>Kasus Baru</th>
            <th>Kasus Lama</th>
            <th>Tgl Masuk</th>
            <th>Tgl Keluar</th>
            <th>Kode ICD</th>
            <th>Desa</th>
            <th>Kecamatan</th>
            <th>Kota</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dm)
            <tr>
                <td>{{ $dm->NO_RM }}</td>
                <td>{{ $dm->NAMA_PASIEN }}</td>
                <td>{{ $dm->umur }}</td>
                <td>{{ $dm->jenis_kelamin }}</td>
                <td>{{ $dm->kasus_BARU }}</td>
                <td>{{ $dm->kasus_LAMA }}</td>
                <td>{{ $dm->TGL_MASUK }}</td>
                <td>{{ $dm->TGL_KELUAR }}</td>
                <td>{{ $dm->KODEICD }}</td>
                <td>{{ $dm->DESA }}</td>
                <td>{{ $dm->KECAMATAN }}</td>
                <td>{{ $dm->KOTA }}</td>
                <td>{{ $dm->ALAMAT}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
