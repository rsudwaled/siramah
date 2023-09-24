@extends('adminlte::page')

@section('title', 'Karcis Antrian')
@section('content_header')
    <h1>Karcis Antrian : {{ \Carbon\Carbon::now()->format('Y-m-d') }}</h1>
@stop

@section('content')
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">IGD UMUM</span>
                                <span class="info-box-number">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">IGD KEBIDANAN</span>
                                <span class="info-box-number">0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">RAWAT INAP</span>
                                <span class="info-box-number">100</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">PENUNJANG</span>
                                <span class="info-box-number">10</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <form action="{{route('d-karcis-igd-create')}}" method="post">
                @csrf
                <x-adminlte-button class="btn-xl btn-flat mb-2" type="submit" label="Karcis Umum" theme="success" icon="fas fa-id-card-alt"/>
                </form>
                <x-adminlte-button class="btn-flat" type="submit" label="Karcis IGD" theme="success" icon="fas fa-id-card"/>
                <form action="{{route('mining-pasien-igd')}}">
                    @csrf
                    <x-adminlte-button class="btn-flat mt-4" type="submit" label="Mining Pasien" theme="danger" icon="fas fa-id-card"/>
                </form>
            </div>
        </div>
    </div>
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
