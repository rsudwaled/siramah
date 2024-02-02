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
                <tr>
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
            <td>
                {{ $kunjungan->budget ? money($kunjungan->budget->tarif_inacbg, 'IDR') : 'Rp 0' }}
            </td>
            <td>
                {{ $kunjungan->tagihan ? money($kunjungan->tagihan->total_biaya, 'IDR') : 'Rp 0' }}
            </td>
            <td>
                @if ($kunjungan->tagihan && $kunjungan->budget)
                    {{ round(($kunjungan->tagihan->total_biaya / $kunjungan->budget->tarif_inacbg) * 100) }}
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
