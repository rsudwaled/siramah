@php
    $heads = ['Tgl Scan', 'No RM', 'Nama Pasien', 'Nama Berkas', 'Jenis', 'Action'];
    $config['paging'] = false;
    $config['order'] = ['0', 'desc'];
    $config['info'] = false;
@endphp
<x-adminlte-datatable id="tableFileUpload" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
    compressed>
    @foreach ($files as $item)
        <tr>
            <td>{{ $item->tanggalscan }}</td>
            <td>{{ $item->norm }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->namafile }}</td>
            <td>{{ $item->jenisberkas }}</td>
            <td>
                <button class="btn btn-xs btn-primary" onclick="lihatFile(this)" data-fileurl="{{ $item->fileurl }}">
                    <i class="fas fa-eye"></i>
                </button>
            </td>
        </tr>
    @endforeach
    @foreach ($fileupload as $file)
        <tr>
            <td>{{ $file->tgl_upload }}</td>
            <td>{{ $file->no_rm }}</td>
            <td>{{ $file->pasien->nama_px }}</td>
            <td>{{ $file->nama ?? $file->gambar }}</td>
            <td>File</td>
            <td>
                <button class="btn btn-xs btn-primary" onclick="lihatFile(this)" data-fileurl="http://192.168.2.45/files/{{ $file->gambar }}">
                    <i class="fas fa-eye"></i>
                </button>
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>
<script>
    $(function() {
        $('#tableFileUpload').DataTable({
            "order": [[0, 'desc']],
            "paging": false,
            "info": false,
            "scrollX": true,
        });
    });

    function lihatFile(button) {
        var url = $(button).data('fileurl');
        $('#dataUrlFile').attr('src', url);
        $('#midalFileLihat').modal('show');
    }
</script>
