@extends('adminlte::page')
@section('title', 'CPPT')
@section('content_header')
    <h1>Catatan Perkembangan Pasien Terintegrasi </h1>
@endsection

@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6">
            <x-adminlte-card title="Assesmen awal Keperawatan" theme="info" collapsible removable maximizable>
                LIHAT DATA CATATAN PERKEMBANGAN PASIEN TERINTEGRASI <br>
                <a target="_blank" theme="success" class="btn btn-sm btn btn-primary" href="{{route('cppt-anestesi-print.get')}}">Lihat Data</a>
            </x-adminlte-card>
        </div>
        <div class="col-lg-6">
            <x-adminlte-card title="Assesmen awal Medis" theme="purple" removable collapsible>
                LIHAT DATA CATATAN PERKEMBANGAN PASIEN TERINTEGRASI <br>
                <a target="_blank" theme="success" class="btn btn-sm btn btn-primary" href="{{route('cppt-print.get')}}">Lihat Data</a>
            </x-adminlte-card>
        </div>
    </div>
</div>
@endsection

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
