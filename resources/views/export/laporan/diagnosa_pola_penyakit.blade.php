<table class="table table-sm" style="text-align: center;">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Diagnosa</th>
            <th>Diagnosa</th>
            <th>Jumlah</th>
            <th>Persen (%)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($diagnosa as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->diag_utama }}</td>
                <td>{{ $item->diag_utama_desc }}</td>
                <td>{{ $item->KB }}</td>
                <td>{{ round($item->persen, 2) }} %</td>
            </tr>
        @endforeach
    </tbody>
</table>
