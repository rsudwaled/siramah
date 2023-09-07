@extends('adminlte::page')

@section('title', 'Pendaftaran Pasien')
@section('content_header')
    <h1>Pendaftaran Pasien</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
            <div class="row">
                <div class="col-lg-6">
                    <x-adminlte-card title="PASIEN LAMA " theme="success" >
                        <x-adminlte-profile-widget name="{{$data->no_rm}}" desc="{{$data->nama_px}}" theme="success"
                        img="https://picsum.photos/id/1/100" layout-type="classic">
                        <x-adminlte-profile-row-item icon="fas fa-fw fa-user-friends" title="{{$riwayat[0]->tgl_masuk}}" text="125"
                            url="#" badge="teal"/>
                        <x-adminlte-profile-row-item icon="fas fa-fw fa-user-friends fa-flip-horizontal" title="{{$riwayat[0]->nama_penjamin}}"
                            text="243" url="#" badge="success"/>
                        <x-adminlte-profile-row-item icon="fas fa-fw fa-sticky-note" title="Posts" text="37"
                            url="#" badge="navy"/>
                    </x-adminlte-profile-widget>
                        
                    </x-adminlte-card>
                </div>
            </div>
    </div>
</div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
@endsection