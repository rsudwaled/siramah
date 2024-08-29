<table class="table table-sm" style="text-align: center;">
    <thead>
        <tr>
            <th>Tanggal Masuk</th>
            <th>Nama</th>
            <th>No Rujukan</th>
            <th>FKTP</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->tgl_masuk }}</td>
                <td>{{ $item->pasien->nama_px }}</td>
                <td>{{ $item->no_rujukan }}</td>
                <td>{{ strtoupper($item->perujuk) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
