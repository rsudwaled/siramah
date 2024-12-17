@extends('adminlte::page')
@section('title', 'Pengajuan Pembukaan Resume')
@section('content_header')
    <h1>Pengajuan Pembukaan Resume</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Jumlah Pengajuan : {{$countPengajuan}} Pengajuan" theme="secondary" collapsible>
                <table class="table table-bordered table-hover table-sm nowrap" id="myTableLama">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pemohon</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuan as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->pemohon}}</td>
                                <td>{{$data->keterangan}}</td>
                                <td>{{$data->status_approval==0?'Belum':'Approve'}}</td>
                                <td style="width: 10%;">
                                    <button class="btn btn-xs btn-danger">Tolak</button>
                                    <button class="btn btn-xs btn-success">Acc</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
    
@endsection