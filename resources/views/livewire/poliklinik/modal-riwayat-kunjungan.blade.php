<div>
    <x-adminlte-card theme="primary" title="Riwayat Kunjungan">
        <table class="table text-nowrap table-sm table-hover table-bordered table-responsive mb-3">
            <thead>
                <tr>
                    <th>Counter</th>
                    <th>Tgl Masuk</th>
                    <th>Tgl Keluar</th>
                    <th>Unit</th>
                    <th>Dokter</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kunjungans as $item)
                <tr>
                    <td>{{ $item->counter }}</td>
                    <td>{{ $item->tgl_masuk }}</td>
                    <td>{{ $item->tgl_keluar }}</td>
                    <td>{{ $item->unit->nama_unit }}</td>
                    <td>{{ $item->dokter->nama_paramedis }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </x-adminlte-card>
</div>
