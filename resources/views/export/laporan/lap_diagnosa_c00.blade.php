<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Nama Rumah Sakit/Fasyankes</th>
                <th>Unit</th>
                <th>Usia</th>
                <th>ICD</th>
                <th>NIK</th>
                <th>No RM</th>
                <th>Kode RS</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Pekerjaan</th>
                <th>Alamat</th>
                <th>Provinsi</th>
                <th>Kabupaten</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>Kontak</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>Lama Rawat</th>
                <th>Kasus</th>
                <th>Diagnosa Sekunder</th>
                <th>Diagnosa Operasi</th>
                <th>Meninggal Lbh 48 Jam</th>
                <th>Meninggal Krg 48 Jam</th>
                <th>No Lab</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pasiens as $pasien)
                @php
                    $masuk = Carbon\Carbon::parse($pasien->tgl_masuk);
                    $keluar = $pasien->tgl_keluar ? Carbon\Carbon::parse($pasien->tgl_keluar) : null;
                    $tanggalLahir = Carbon\Carbon::parse($pasien->tgl_lahir);
                    $tsLayananHeader = DB::connection('mysql2')
                        ->table('ts_layanan_header')
                        ->where('kode_kunjungan', $pasien->kode_kunjungan)
                        ->pluck('kode_layanan_header');

                    // Lakukan join dengan listohisheader pada koneksi mysql10
                    $labDetails = DB::connection('mysql10')
                        ->table('listohisheader as histo')
                        ->whereIn('histo.HisNoReg', $tsLayananHeader)
                        ->select('histo.*')
                        ->get();
                @endphp
                <tr>
                    <td>RSUD WALED</td>
                    <td>{{ $pasien->id_ruangan == null ? 'RAJAL' : 'RANAP' }}</td>
                    <td>{{ $tanggalLahir->age }}</td>
                    <td>{{ $pasien->diag_utama }}</td>
                    <td>{{ $pasien->nik_bpjs ? "'" . $pasien->nik_bpjs : '' }}</td>
                    <td>{{ $pasien->no_rm }}</td>
                    <td>3209014</td>
                    <td>{{ $pasien->nama_px }}</td>
                    <td>{{ $pasien->tempat_lahir }}</td>
                    <td>{{ $pasien->tgl_lahir }}</td>
                    <td>{{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                    {{-- <td>{{ $pasien->agama}}</td>
                    <td>{{ $pasien->pekerjaan}}</td> --}}
                    <td>-</td>
                    <td>-</td>
                    <td>{{ $pasien->alamat }}</td>
                    <td>{{ $pasien->provinsi_name }}</td>
                    <td>{{ $pasien->kabupaten_name }} </td>
                    <td>{{ $pasien->kecamatan_name }} </td>
                    <td>{{ $pasien->desa_name }} </td>
                    <td>{{ $pasien->no_hp ?? $pasien->no_tlp }} </td>
                    <td>{{ $pasien->tgl_masuk ?? '-' }}</td>
                    <td>{{ $pasien->tgl_keluar ?? '-' }}</td>
                    <td>{{ $keluar ? $keluar->diffInDays($masuk) : 0 }}</td>
                    <td>{{ $pasien->kasus_baru }}</td>
                    <td>{{ $pasien->diagnosa_sekunder }}</td>
                    <td>{{ $pasien->diag_sekunder_04 . ' | ' . $pasien->diag_sekunder4_desc }}</td>
                    <td>{{ $pasien->meninggal_lb_48jam == 0 ? '-' : 'Ya' }}</td>
                    <td>{{ $pasien->meninggal_kr_48jam == 0 ? '-' : 'Ya' }}</td>
                    <td>
                        @if ($labDetails->isNotEmpty())
                            <p>Data Lab:</p>
                            <ul>
                                @foreach ($labDetails as $item)
                                    <li>{{ $item->LisNoLab }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>-</p>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
