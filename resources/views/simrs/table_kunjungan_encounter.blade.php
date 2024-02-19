<div class="row">
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $kunjungans->count() }}" text="Total Kunjungan" theme="success"
            icon="fas fa-user-injured" />
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box
            title="{{ $kunjungans->count() - $kunjungans->where('diagnosaicd.diag_utama', '!=', null)->count() }}"
            text="Belum ICD-10" theme="danger" icon="fas fa-user-injured" />
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $kunjungans->where('id_satusehat', '!=', null)->count() }}"
            text="Sync Satu Sehat" theme="warning" icon="fas fa-user-injured" />
    </div>
</div>
@php
    $heads = ['Tgl Masuk', 'No RM', 'Pasien', 'Poliklinik', 'Dokter', 'Diagnosa', 'ICD-10', 'Action'];
    $config['order'] = [['0', 'asc']];
    $config['paging'] = false;
    $config['autoEmpty'] = false;
    $config['language'] = ['emptyTable' => '', 'zeroRecords' => ''];
    $config['processing'] = true;
    $config['serverside'] = true;
    $config['scrollY'] = '400px';
@endphp
<x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" :config="$config" bordered hoverable compressed>
    @if ($kunjungans)
        @foreach ($kunjungans as $kunjungan)
            @if ($kunjungan->diagnosaicd)
                @if ($kunjungan->diagnosaicd->diag_utama)
                    <tr>
                    @else
                    <tr class="table-danger">
                @endif
            @else
                <tr class="table-danger">
            @endif
            <td>{{ $kunjungan->tgl_masuk }}</td>
            <td>{{ $kunjungan->no_rm }}</td>
            <td> {{ $kunjungan->pasien->nama_px ?? '-' }}</td>
            <td>{{ $kunjungan->unit->nama_unit }}</td>
            <td>{{ $kunjungan->dokter->nama_paramedis }}</td>
            <td>{{ $kunjungan->diagnosapoli->diag_00 ?? '-' }}</td>
            <td>{{ $kunjungan->diagnosaicd->diag_utama ?? '-' }}</td>
            <td>
                <a href="{{ route('encounter_sync') }}?kode={{ $kunjungan->kode_kunjungan }}"
                    class="btn btn-xs btn-primary">Sync</a>
            </td>
            </tr>
        @endforeach
    @endif
</x-adminlte-datatable>
<br>
Catatan : <br>
- Baris Berwana Merah : Belum isi ICD-10 <br>
<script>
    $(function() {
        $('#table1').DataTable({
            "paging": false,
            "info": false,
            "scrollCollapse": true,
            "scrollY": '300px'
        });
    });
</script>
