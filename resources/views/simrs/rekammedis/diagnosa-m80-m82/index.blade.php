@extends('adminlte::page')
@section('title', 'DIAGNOSA M80-M82')
@section('content_header')
    <div class="alert bg-primary alert-dismissible">
        <div class="row">
            <div class="col-sm-4">
                <h5>
                    <i class="fas fa-user-tag"></i> DIAGNOSA M80-M82 :
                </h5>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card theme="primary" collapsible>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="{{ url('laporan-rm/diagnosa-m80-m82') }}"
                                    class="nav-link {{ Request::get('view') != 'rawat_inap' ? 'active' : '' }}">
                                    RAWAT JALAN&nbsp;
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="?view=rawat_inap"
                                    class="nav-link {{ Request::get('view') == 'rawat_inap' ? 'active' : '' }}">
                                    RAWAT INAP&nbsp;
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active">
                                <table id="table1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>COUNT</th>
                                            <th>KUNJUNGAN</th>
                                            <th>NO RM</th>
                                            <th>PASIEN</th>
                                            <th colspan="2">ALAMAT</th>
                                            <th>TANGGAL</th>
                                            <th>JML KUNJUNGAN</th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody>
                                        @foreach ($results as $item)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>{{ $item->counter }}</td>
                                            <td>{{ $item->kode_kunjungan }}</td>
                                            <td>{{ $item->no_rm }}</td>
                                            <td>{{ $item->nama_px }}</td>
                                            <td colspan="2">-</td>
                                            <td>{{ $item->tgl_masuk }}</td>
                                            <td>{{ $item->total_kunjungan }}</td>
                                        </tr>
                                        <tr class="expandable-body d-none">
                                            <td colspan="8">
                                               <p style="display: none;"></p>
                                               <div class="col-lg-12" style="display: none;">
                                                   <table class="col-lg-12">
                                                    <thead>
                                                        <th>No</th>
                                                        <th>COUNT</th>
                                                        <th>KUNJUNGAN</th>
                                                        <th>NO RM</th>
                                                        <th>PASIEN</th>
                                                        <th>POLI</th>
                                                        <th>DIAGNOSA</th>
                                                        <th>TANGGAL</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($details->where('no_rm', $item->no_rm) as $detail)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{ $detail->counter }}</td>
                                                            <td>{{ $detail->kode_kunjungan }}</td>
                                                            <td>{{ $detail->no_rm }}</td>
                                                            <td>{{ $detail->nama_px }}</td>
                                                            <td>{{ $detail->nama_unit }}</td>
                                                            <td>{{ $detail->diagx }}</td>
                                                            <td>{{ $detail->tgl_masuk }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                   </table>
                                               </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card theme="primary" collapsible>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="table1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>COUNT</th>
                                    <th>KUNJUNGAN</th>
                                    <th>NO RM</th>
                                    <th>PASIEN</th>
                                    <th colspan="2">ALAMAT</th>
                                    <th>TANGGAL</th>
                                    <th>JML KUNJUNGAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>

@endsection
@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')

@endsection
