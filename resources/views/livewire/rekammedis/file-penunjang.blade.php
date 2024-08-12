<div id="file">
    <x-adminlte-card title="File Penunjang" theme="primary" icon="fas fa-file-medical">
        <table class="table table-xs table-bordered">
            <tr>
                <th>Nama File</th>
                <th>Unit</th>
                <th>Url</th>
                <th>Tgl Upload</th>
                <th>Action</th>
            </tr>
            @foreach ($fileagil as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kode_unit }}</td>
                    <td>http://192.168.2.45/files/{{ $item->gambar }}</td>
                    <td>{{ $item->tgl_upload }}</td>
                    <td>

                    </td>
                </tr>
            @endforeach
            @foreach ($file as $item)
                <tr>
                    <td>{{ $item->namafile }}</td>
                    <td>{{ $item->jenisberkas }}</td>
                    <td>{{ $item->fileurl }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>

                    </td>
                </tr>
            @endforeach
        </table>
    </x-adminlte-card>
</div>
