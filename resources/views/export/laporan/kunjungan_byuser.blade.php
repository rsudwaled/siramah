<table class="table table-sm" style="text-align: center;">
    <thead>
        <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Tanggal Masuk</th>
            <th>RM</th>
            <th>Pasien</th>
            <th>Status Kunjungan</th>
            <th>Admin</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($laporan as $user)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ Carbon\Carbon::parse($user->tgl_masuk)->format('F') }}</td>
                <td>{{$user->tgl_masuk}}</td>
                <td>{{$user->no_rm}}</td>
                <td>{{ $user->pasien->nama_px ?? 'Data tidak ketahui' }}</td>
                <td style="color: {{ in_array($user->status_kunjungan, ['8', '11', '13']) ? 'red' : '' }}">
                    {{ $user->status->status_kunjungan }}
                </td>
                <td>{{$admin->name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
