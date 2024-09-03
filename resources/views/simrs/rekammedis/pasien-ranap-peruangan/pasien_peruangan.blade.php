@extends('adminlte::page')
@section('title', 'PASIEN PERUANGAN')
@section('content_header')
    <h1>PASIEN PERUANGAN</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- <x-adminlte-card title="Filter Periode Tanggal Dan Unit" theme="secondary" id="hide_div" collapsible>
                <form id="formFilter" action="" method="get">
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="date" name="startdate" id="startdate" class="form-control"
                                        value="{{ $startdate == null ? \Carbon\Carbon::parse($request->startdate)->format('Y-m-d') : $startdate }}">
                                </div>
                                <div class="col-lg-6">
                                    <input type="date" name="enddate" id="enddate" class="form-control"
                                        value="{{ $enddate == null ? \Carbon\Carbon::parse($request->enddate)->format('Y-m-d') : $enddate }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select2 label-class="text-right" igroup-size="sm" name="kodeunit">
                                <option value="-">SEMUA POLIKLINIK</option>
                                @foreach ($units as $key => $item)
                                    <option value="{{ $key }}"
                                        {{ $key == $request->kodeunit ? 'selected' : null }}>
                                        {{ strtoupper($item) }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                        <x-adminlte-button type="submit" class="withLoad btn btn-sm col-md-2" theme="primary"
                            label="Lihat Laporan" />
                        <x-adminlte-button class="btn btn-sm col-md-2" theme="success" label="TOTAL: {{$jumlah??0}}" />
                    </div>
                </form>
            </x-adminlte-card> --}}
            <div class="row">
                @foreach ($ruangan as $data)
                    <div class="col-md-3 col-sm-6 col-12">
                        <a href="">
                        <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-bed"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><strong>{{ $data->unit->nama_unit }}</strong></span>
                                    <span class="info-box-number">KELAS: {{ $data->id_kelas ==4?'VIV':$data->id_kelas }}</span>
                                    <span class="info-box-number text-danger">KOSONG: {{ $data->count_status_0 }}</span>
                                    <span class="info-box-number">ISI : {{ $data->count_status_1 }}</span>
                                    <span class="info-box-number">RENCANA PULANG : {{ $data->count_status_2 }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            {{-- <x-adminlte-card title="DAFTAR PASIEN PERUANGAN" theme="primary" collapsible>
                <table class="table table-bordered table-hover table-sm nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>KUNJUNGAN</th>
                            <th>MASUK</th>
                            <th>NAMA PASIEN</th>
                            <th>RUANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungans as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->kode_kunjungan}}</td>
                                <td>{{$item->tgl_masuk}}</td>
                                <td>
                                    {{$item->pasien->nama_px}} <br>
                                    {{$item->pasien->no_rm}} <br>

                                </td>
                                <td>
                                    {{$item->kamar}} <br>
                                    {{$item->no_bed}} <br>

                                    <span class="badge {{$item->ruanganRawat->status_incharge==1?'badge-success':'badge-danger'}}">{{$item->ruanganRawat->status_incharge==1?'AKTIF':'TIDAK'}}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-adminlte-card> --}}
        </div>
    </div>

@endsection

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "scrollY": "600px",
                "scrollCollapse": true, // Allow the table to shrink or grow
                "paging": false // Disable pagination
            });
        });
    </script>

@endsection
