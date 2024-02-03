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
    $heads = ['Tgl Masuks', 'Tgl Keluar ', 'LOS', 'Action', 'No RM', 'Pasien', 'No BPJS', 'Ruangan', 'No SEP', 'Tarif Eklaim', 'Tagihan RS', '%', 'Status'];
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
            @if (isset($kunjungan->erm_ranap))
                @switch($kunjungan->erm_ranap->status)
                    @case(1)
                        <tr class="table-warning">
                        @break

                        @case(2)
                        <tr class="table-success">
                        @break

                        @default
                        <tr>
                    @endswitch
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
                <div class="btn btn-xs btn-primary" onclick="lihatResume(this)"
                    data-kode="{{ $kunjungan->kode_kunjungan }}"><i class="fas fa-file-medical"></i> Resume
                </div>
                @if (isset($kunjungan->erm_ranap))
                    <a href="{{ route('verif_resume_ranap') }}?kode={{ $kunjungan->kode_kunjungan }}"
                        class="btn btn-success btn-xs withLoad"><i class="fas fa-check"></i></a>
                    <a href="{{ route('revisi_resume_ranap') }}?kode={{ $kunjungan->kode_kunjungan }}"
                        class="btn btn-warning btn-xs withLoad"><i class="fas fa-edit"></i></a>
                    {{ $kunjungan->erm_ranap->status }}
                @endif
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
