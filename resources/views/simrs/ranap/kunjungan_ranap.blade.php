@extends('adminlte::page')
@section('title', 'Pasien Rawat Inap')
@section('content_header')
    <h1>Pasien Rawat Inap</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="secondary" icon="fas fa-procedures" title="Data Pasien Rawat Inap">
                <form action="">
                    <div class="row">
                        <div class="col-md-4">
                            {{-- @php
                                $user = Auth::user();
                                $role = $user->roles->first()->name;
                            @endphp
                            @if ($role === 'Admin Super')
                                <x-adminlte-select2 fgroup-class="row" label-class="text-right col-4" igroup-size="sm"
                                    igroup-class="col-8" name="kodeunit" label="Ruangan">
                                    @foreach ($units as $key => $item)
                                        <option value="{{ $key }}"
                                            {{ $key == $request->kodeunit ? 'selected' : null }}>
                                            {{ $item }} ({{ $key }})
                                        </option>
                                    @endforeach
                                </x-adminlte-select2>
                            @else
                                @if ($role === 'Dokter')
                                    <x-adminlte-select2 fgroup-class="row" label-class="text-right col-4" igroup-size="sm"
                                        igroup-class="col-8" name="kodeunit" label="Ruangan">
                                        @foreach ($units as $key => $item)
                                            <option value="{{ $key }}"
                                                {{ $key == $request->kodeunit ? 'selected' : null }}>
                                                {{ $item }} ({{ $key }})
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                @else
                                    <x-adminlte-select2 fgroup-class="row" label-class="text-right col-4" igroup-size="sm"
                                        igroup-class="col-8" name="kodeunit" label="Ruangan" readonly>
                                        @foreach ($units as $key => $item)
                                            <option value="{{ $key }}"
                                                {{ $key == Auth::user()->unit_user ? 'selected' : null }}>
                                                {{ $item }} ({{ $key }})
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                @endif
                            @endif --}}
                            <x-adminlte-select2 fgroup-class="row" label-class="text-right col-4" igroup-size="sm"
                                    igroup-class="col-8" name="kodeunit" label="Ruangan">
                                    @foreach ($units as $key => $item)
                                        <option value="{{ $key }}"
                                            {{ $key == $request->kodeunit ? 'selected' : null }}>
                                            {{ $item }} ({{ $key }})
                                        </option>
                                    @endforeach
                                </x-adminlte-select2>
                        </div>
                        <div class="col-md-6">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date fgroup-class="row" label-class="text-right col-4" igroup-size="sm"
                                igroup-class="col-8" igroup-size="sm" name="tanggal" label="Tanggal Ranap" :config="$config"
                                value="{{ $request->tanggal ?? now()->format('Y-m-d') }}">
                                <x-slot name="appendSlot">
                                    <button class="btn btn-sm btn-primary withLoad" type="submit"><i
                                            class="fas fa-search "></i>
                                        Submit Pencarian</button>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>
                </form>
                @if ($kunjungans->count())
                    <div class="row">
                        <div class="col-md-3">
                            <x-adminlte-small-box title="{{ $kunjungans->where('tgl_keluar', null)->count() }}"
                                text="Sedang Ranap" theme="primary" icon="fas fa-user-injured" />
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box title="{{ $kunjungans->where('budget.kode_cbg', null)->count() }}"
                                text="Belum Groupping" theme="danger" icon="fas fa-user-injured" />
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box
                                title="{{ $kunjungans->where('tgl_keluar', '!=', null)->where('erm_ranap.status', '!=', 2)->count() }}"
                                text="Belum Resume Ranap" theme="warning" icon="fas fa-user-injured" />
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box title="{{ $kunjungans->where('tgl_keluar', '!=', null)->count() }}"
                                text="Sudah Pulang" theme="success" icon="fas fa-user-injured" />
                        </div>
                    </div>
                @endif
                @php
                    $heads = [
                        'Tgl Masuks',
                        'Tgl Keluar ',
                        'LOS',
                        'No RM',
                        'Pasien',
                        'No BPJS',
                        'Action',
                        'Tagihan RS',
                        'Tarif Eklaim',
                        '%',
                        'Status',
                        'No SEP',
                        'Ruangan',
                        'DPJP',
                        'Penjamin',
                        'Alasan',
                    ];
                    $config['order'] = [['0', 'asc']];
                    $config['fixedColumns'] = [
                        'leftColumns' => 7,
                    ];
                    $config['paging'] = false;
                    $config['scrollX'] = true;
                    $config['scrollY'] = '400px';
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                    hoverable compressed>
                    @if ($kunjungans)
                        @foreach ($kunjungans as $kunjungan)
                            @php
                                $statusClass = 'table-secondary';
                                $statusTextColor = 'text-warning';

                                // Determine the row color based on conditions
                                if ($kunjungan->budget) {
                                    if ($kunjungan->tgl_keluar) {
                                        $statusClass = 'table-secondary';
                                        $statusTextColor = $kunjungan->erm_ranap
                                            ? ($kunjungan->erm_ranap->status == 1
                                                ? 'text-warning'
                                                : ($kunjungan->erm_ranap->status == 2
                                                    ? 'text-success'
                                                    : 'text-warning'))
                                            : 'text-warning';
                                    } else {
                                        $statusClass = 'table-secondary';
                                        $statusTextColor = 'text-dark';
                                    }
                                } else {
                                    $statusClass = 'table-secondary';
                                    $statusTextColor = 'text-danger';
                                }

                                // Calculate days difference
                                $days = \Carbon\Carbon::parse($kunjungan->tgl_masuk)
                                    ->startOfDay()
                                    ->diffInDays(\Carbon\Carbon::parse($kunjungan->tgl_keluar)->endOfDay() ?? now());

                                // Calculate percentage if tagihan and budget exist
                                $percentage = null;
                                if ($kunjungan->tagihan && $kunjungan->budget) {
                                    $percentage =
                                        $kunjungan->tagihan->total_biaya && $kunjungan->budget->tarif_inacbg
                                            ? round(
                                                ($kunjungan->tagihan->total_biaya / $kunjungan->budget->tarif_inacbg) *
                                                    100,
                                            )
                                            : null;
                                }

                                // Determine tagihan and budget amounts
                                $tagihanAmount = $kunjungan->tagihan
                                    ? money($kunjungan->tagihan->total_biaya, 'IDR')
                                    : 'Rp 0';
                                $budgetAmount = $kunjungan->budget
                                    ? money($kunjungan->budget->tarif_inacbg, 'IDR')
                                    : 'Rp 0';
                            @endphp

                            <tr class="{{ $statusClass }} {{ $statusTextColor }}">
                                <td>{{ $kunjungan->tgl_masuk }}</td>
                                <td>{{ $kunjungan->tgl_keluar }}</td>
                                <td>{{ $days }} Hari</td>
                                <td>{{ $kunjungan->no_rm }}</td>
                                <td>{{ $kunjungan->pasien->nama_px ?? '-' }}</td>
                                <td>{{ $kunjungan->pasien->no_Bpjs ?? '-' }}</td>
                                <td>
                                    {{-- {{$role}} --}}
                                    {{-- <a href="{{ route('dashboard.erm-ranap.dokters.dashboard', ['kode' => $kunjungan->kode_kunjungan]) }}"
                                        class="btn btn-success btn-xs withLoad">
                                        <i class="fas fa-file-medical"></i> ERM DOKTER
                                    </a> --}}
                                    {{-- <a href="{{ route('dashboard.erm-ranap.dashboard', ['kode' => $kunjungan->kode_kunjungan]) }}"
                                        class="btn btn-success btn-xs withLoad">
                                        <i class="fas fa-file-medical"></i> ERM RANAP
                                    </a> --}}
                                    <a href="{{ route('resume-pemulangan.vbeta.resume-vbeta.cepat', ['kode' => $kunjungan->kode_kunjungan]) }}"
                                        class="btn btn-secondary btn-xs withLoad">
                                        <i class="fas fa-file-medical"></i> Resume
                                    </a>
                                    <a href="{{ route('pasienranapprofile', ['kode' => $kunjungan->kode_kunjungan]) }}"
                                        class="btn btn-primary btn-xs withLoad">
                                        <i class="fas fa-file-medical"></i> ERM
                                    </a>
                                </td>
                                <td
                                    class="{{ $kunjungan->tagihan && $kunjungan->budget && $kunjungan->tagihan->total_biaya > $kunjungan->budget->tarif_inacbg ? 'text-danger' : '' }}">
                                    {{ $tagihanAmount }}
                                </td>
                                <td
                                    class="{{ $kunjungan->tagihan && $kunjungan->budget && $kunjungan->tagihan->total_biaya > $kunjungan->budget->tarif_inacbg ? 'text-danger' : '' }}">
                                    {{ $budgetAmount }}
                                </td>
                                <td
                                    class="{{ $kunjungan->tagihan && $kunjungan->budget && $kunjungan->tagihan->total_biaya > $kunjungan->budget->tarif_inacbg ? 'text-danger' : '' }}">
                                    {{ $percentage ?? '-' }}
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $kunjungan->status_kunjungan == 1 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $kunjungan->status_kunjungan }}. {{ $kunjungan->status->status_kunjungan }}
                                    </span>
                                </td>
                                <td>{{ $kunjungan->no_sep }}</td>
                                <td>{{ $kunjungan->unit->nama_unit }}</td>
                                <td>{{ $kunjungan->dokter->nama_paramedis }}</td>
                                <td>{{ $kunjungan->penjamin_simrs->nama_penjamin }}</td>
                                <td>{{ $kunjungan->alasan_masuk->alasan_masuk }}</td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
                <br>
                Catatan : <br>
                - Baris Berwana Merah : belum groupping <br>
                - Baris Berwana Kuning : pasien sudah pulang tapi belum diisi erm resume<br>
                - Baris Berwana Hijau : pasien sudah pulang dan resumenya sudah diisi<br>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesFixedColumns', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
