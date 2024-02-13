<div class="row">
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $kunjungans->where('tgl_keluar', null)->count() }}" text="Sedang Ranap"
            theme="primary" icon="fas fa-user-injured" />
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $kunjungans->where('budget.kode_cbg', null)->count() }}" text="Belum Groupping"
            theme="danger" icon="fas fa-user-injured" />
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box
            title="{{ $kunjungans->where('tgl_keluar', '!=', null)->where('erm_ranap.status', '!=', 2)->count() }}"
            text="Belum Resume Ranap" theme="warning" icon="fas fa-user-injured" />
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $kunjungans->where('tgl_keluar', '!=', null)->count() }}" text="Sudah Pulang"
            theme="success" icon="fas fa-user-injured" />
    </div>
</div>
@php
    $heads = ['Tgl Masuk', 'Tgl Keluar ', 'LOS', 'Action', 'No RM', 'Pasien', 'No BPJS', 'Ruangan', 'No SEP', 'Tarif Eklaim', 'Tagihan RS', '%', 'Status'];
    $config['order'] = [['0', 'asc']];
    $config['paging'] = false;
    $config['autoEmpty'] = false;
    $config['language'] = ['emptyTable' => '', 'zeroRecords' => ''];
    $config['processing'] = true;
    $config['serverside'] = true;
    $config['scrollY'] = '400px';
@endphp
<x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
    compressed>
    @if ($kunjungans)
        @foreach ($kunjungans as $kunjungan)
            @if ($kunjungan->budget)
                @if ($kunjungan->tgl_keluar)
                    @if ($kunjungan->erm_ranap)
                        @switch($kunjungan->erm_ranap->status)
                            @case(1)
                                <tr class="table-warning">
                                @break

                                @case(2)
                                <tr class="table-success">
                                @break

                                @default
                                <tr class="table-warning">
                            @endswitch
                        @else
                        <tr class="table-warning">
                    @endif
                @else
                    <tr>
                @endif
            @else
                <tr class="table-danger">
            @endif
            <td>{{ $kunjungan->tgl_masuk }}</td>
            <td>{{ $kunjungan->tgl_keluar }}
            </td>
            <td>
                {{ \Carbon\Carbon::parse($kunjungan->tgl_masuk)->startOfDay()->diffInDays(\Carbon\Carbon::parse($kunjungan->tgl_keluar)->endOfDay() ?? now()) }}
                Hari
            </td>
            <td>
                <a href="{{ route('pasienranapprofile') }}?kode={{ $kunjungan->kode_kunjungan }}"
                    class="btn btn-primary btn-xs withLoad"><i class="fas fa-file-medical"></i>ERM</a>
            </td>
            <td>{{ $kunjungan->no_rm }}
            </td>
            <td>{{ $kunjungan->pasien->nama_px ?? '-' }}</td>
            <td>{{ $kunjungan->pasien->no_Bpjs ?? '-' }}</td>
            <td>{{ $kunjungan->unit->nama_unit }}</td>
            <td>{{ $kunjungan->no_sep }}</td>
            <td
                class="{{ $kunjungan->tagihan && $kunjungan->budget ? ($kunjungan->tagihan->total_biaya > $kunjungan->budget->tarif_inacbg ? 'table-danger' : null) : null }}">
                {{ $kunjungan->budget ? money($kunjungan->budget->tarif_inacbg, 'IDR') : 'Rp 0' }}
            </td>
            <td
                class="{{ $kunjungan->tagihan && $kunjungan->budget ? ($kunjungan->tagihan->total_biaya > $kunjungan->budget->tarif_inacbg ? 'table-danger' : null) : null }}">
                {{ $kunjungan->tagihan ? money($kunjungan->tagihan->total_biaya, 'IDR') : 'Rp 0' }}
            </td>
            <td
                class="{{ $kunjungan->tagihan && $kunjungan->budget ? ($kunjungan->tagihan->total_biaya > $kunjungan->budget->tarif_inacbg ? 'table-danger' : null) : null }}">
                @if ($kunjungan->tagihan && $kunjungan->budget)
                    @if ($kunjungan->tagihan->total_biaya && $kunjungan->budget->tarif_inacbg)
                        {{ round(($kunjungan->tagihan->total_biaya / $kunjungan->budget->tarif_inacbg) * 100) }}
                    @endif
                @endif
            </td>
            <td>
                @if ($kunjungan->status_kunjungan == 1)
                    <span class="badge badge-success">{{ $kunjungan->status_kunjungan }}.
                        {{ $kunjungan->status->status_kunjungan }}</span>
                @else
                    <span class="badge badge-danger">{{ $kunjungan->status_kunjungan }}.
                        {{ $kunjungan->status->status_kunjungan }}</span>
                @endif
            </td>
            </tr>
        @endforeach
    @endif
</x-adminlte-datatable>
<br>
Catatan : <br>
- Baris Berwana Merah : belum groupping <br>
- Baris Berwana Kuning : pasien sudah pulang tapi belum diisi erm resume<br>
- Baris Berwana Hijau : pasien sudah pulang dan resumenya sudah diisi<br>
<script>
    $(function() {
        blmgroupping = "{{ $kunjungans->where('budget.kode_cbg', null)->count() }}";
        if (blmgroupping != 0) {
            swal.fire(
                blmgroupping + " Pasien Belum Groupping",
                "Mohon lakukan Groupping Eklaim, sebelum 3 hari setelah pasien masuk rawat inap",
                'warning'
            );
        }
        $('#table1').DataTable({
            "paging": false,
            "info": false,
            "scrollCollapse": true,
            "scrollY": '300px'
        });
    });
</script>
