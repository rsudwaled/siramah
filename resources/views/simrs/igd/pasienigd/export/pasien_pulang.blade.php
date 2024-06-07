<table class="table table-sm" style="text-align: center;">
    <thead>
        <tr>
            <th>RM</th>
            <th>PASIEN</th>
            <th>RUANGAN</th>
            <th>TANGGAL KELUAR</th>
            <th>KUNJUNGAN</th>
            <th>SEP</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kunjungan as $item)
            <tr>
                <td>{{ $item->rm }}</td>
                <td>
                    (NIK: {{ $item->nik??'-' }}) | (BPJS: {{ $item->noKartu??'-' }}) | {{ $item->pasien }}
                </td>
                <td>
                    @if (!empty($item->kamar) || !empty($item->bed))
                        {{ $item->kamar }} | {{ $item->bed }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $item->tgl_pulang }}</td>
                <td>
                    {{ $item->kunjungan }} | {{ $item->nama_unit }} (status: {{ $item->status }})
                </td>
                <td>
                    {{ $item->sep }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
