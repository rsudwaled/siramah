@extends('adminlte::page')
@section('title', 'Dashboard Bulan - Antrian BPJS')
@section('content_header')
    <h1 class="m-0 text-dark">Dashboard Bulan Antrian BPJS</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Pencarian Dashboad Bulan Antrian" theme="secondary" icon="fas fa-info-circle" collapsible>
                <form action="">
                    @php
                        $config = ['format' => 'YYYY-MM'];
                    @endphp
                    <x-adminlte-input-date name="tanggal" placeholder="Silahkan Pilih Tanggal" value="{{ $request->tanggal }}"
                        label="Bulan Periksa" :config="$config" />
                    <x-adminlte-select name="waktu" label="Waktu">
                        <option value="rs">Waktu RS</option>
                        <option value="server">Waktu BPJS</option>
                    </x-adminlte-select>
                    <x-adminlte-button label="Cari Antrian" class="mr-auto withLoad" type="submit" theme="success"
                        icon="fas fa-search" />
                </form>
            </x-adminlte-card>
            @if ($antrians)
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-small-box title="{{ $antrians->sum('jumlah_antrean') }}" text="Selesai Antrian"
                        theme="success" icon="fas fa-user-injured" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-small-box title="{{ $antrian_total }}" text="Total Antrian" theme="warning"
                        icon="fas fa-user-injured" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-small-box
                        title="{{ number_format(($antrians->sum('jumlah_antrean') / $antrian_total) * 100, 2) }} %"
                        text="Quality Rate Antrian" theme="primary" icon="fas fa-user-injured" />
                </div>
            </div>
            <x-adminlte-card title="Laporan Waktu Pelayanan Antrian" theme="secondary" collapsible>
                @php
                    $heads = ['Poliklinik', 'Total Antrian', 'Checkin', 'Daftar', 'Tunggu Poli', 'Layan Poli', 'Terima Resep', 'Proses Farmasi', 'Total Waktu'];
                    $config = ['paging' => false];

                @endphp
                <x-adminlte-datatable id="table2" class="text-xs" :heads="$heads" :config="$config" hoverable bordered
                    compressed>
                    @isset($antrians)
                        @foreach ($antrians->groupBy('namapoli') as $key => $item)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $item->sum('jumlah_antrean') }}</td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds($item->sum('avg_waktu_task1') / $item->count())->cascade()->format('%H:%I:%S') }}
                                </td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds($item->sum('avg_waktu_task2') / $item->count())->cascade()->format('%H:%I:%S') }}
                                </td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds($item->sum('avg_waktu_task3') / $item->count())->cascade()->format('%H:%I:%S') }}
                                </td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds($item->sum('avg_waktu_task4') / $item->count())->cascade()->format('%H:%I:%S') }}
                                </td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds($item->sum('avg_waktu_task5') / $item->count())->cascade()->format('%H:%I:%S') }}
                                </td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds($item->sum('avg_waktu_task6') / $item->count())->cascade()->format('%H:%I:%S') }}
                                </td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds(($item->sum('avg_waktu_task1') + $item->sum('avg_waktu_task2') + $item->sum('avg_waktu_task3') + $item->sum('avg_waktu_task4') + $item->sum('avg_waktu_task5') + $item->sum('avg_waktu_task6') + $item->sum('avg_waktu_task7')) / $item->count())->cascade()->format('%H:%I:%S') }}
                                </td>

                            </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>{{ $antrians->sum('jumlah_antrean') }}</th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task1') / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task2') / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task3') / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task4') / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task5') / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task6') / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds(($antrians->sum('avg_waktu_task1') + $antrians->sum('avg_waktu_task2') + $antrians->sum('avg_waktu_task3') + $antrians->sum('avg_waktu_task4') + $antrians->sum('avg_waktu_task5') + $antrians->sum('avg_waktu_task6') + $antrians->sum('avg_waktu_task7')) / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                            </tr>
                        </tfoot>
                    @endisset
                </x-adminlte-datatable>
            </x-adminlte-card>
            @endif
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
