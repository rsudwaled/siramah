@extends('adminlte::page')
@section('title', 'EDIT PENJAMIN')
@section('content_header')
    <div class="alert bg-primary alert-dismissible">
        <div class="row">
            <div class="col-sm-4">
                <h5>
                    <i class="fas fa-user-tag"></i> EDIT PENJAMIN :
                </h5>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card theme="purple" collapsible>
                <table id="table1" class="semuaKunjungan table table-bordered">
                    <thead>
                        <tr>
                            <th>COUNT</th>
                            <th>KUNJUNGAN</th>
                            <th>NO RM</th>
                            <th>PASIEN</th>
                            <th>POLI</th>
                            <th>STATUS</th>
                            <th>TANGGAL</th>
                            <th>PENJAMIN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjunganSama as $item)
                            <tr>
                                <td>{{$item->counter}}</td>
                                <td>{{$item->kode_kunjungan}}</td>
                                <td>{{$item->no_rm}}</td>
                                <td>{{$item->pasien->nama_px}}</td>
                                <td>{{$item->unit->nama_unit}}</td>
                                <td>{{$item->status->status_kunjungan}}</td>
                                <td>{{$item->tgl_masuk}}</td>
                                <td>{{$item->penjamin_simrs->nama_penjamin}}</td>
                                <td>{{$item->counter}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
