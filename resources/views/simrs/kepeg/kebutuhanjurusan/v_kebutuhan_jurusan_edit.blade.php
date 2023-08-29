@extends('adminlte::page')
@section('title', 'Edit Kebutuhan')
@section('content_header')
    <h1>Edit Kebutuhan {{ $data->nama_jurusan }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <x-adminlte-card title="Edit Kebutuhan Jurusan" theme="success" collapsible>
                <form action="{{ route('data-kebutuhan.update', $data->id) }}" id="myform" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6">
                            <x-adminlte-input type="number" value="{{ $data->keadaan_lk }}" name="keadaan_lk" label="Keadaan Laki-Laki" enable-old-support required />
                        </div>
                        <div class="col-lg-6">
                            <x-adminlte-input type="number" value="{{ $data->keadaan_pr }}" name="keadaan_pr" label="Keadaan Perempuan" enable-old-support required />
                        </div>
                        <div class="col-lg-6">
                            <x-adminlte-input type="number" value="{{ $data->kebutuhan_lk }}" name="kebutuhan_lk" label="Kebutuhan Laki-Laki"  enable-old-support required />
                        </div>
                        <div class="col-lg-6">
                            <x-adminlte-input type="number" value="{{ $data->kebutuhan_pr }}" name="kebutuhan_pr" label="Kebutuhan Perempuan" enable-old-support required />
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
            <x-adminlte-button form="myform" type="submit" class="float-right" theme="success" label="Update Data" />
            <a href="{{ route('data-jurusan.get') }}" class="btn btn-danger mr-1 float-right">Kembali</a>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)

