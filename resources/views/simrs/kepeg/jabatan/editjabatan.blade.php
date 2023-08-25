@extends('adminlte::page')
@section('title', 'Edit Jabatan')
@section('content_header')
    <h1>Edit Jabatan {{ $data->nama_jabatan }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <x-adminlte-card title="Edit Data Jabatan" theme="success" collapsible>
                <form action="{{ route('jabatan-kepeg.update', $data->id) }}" id="myform" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-12">
                            <x-adminlte-input value="{{ $data->nama_jabatan }}" name="nama_jabatan" label="Nama Jabatan"
                                placeholder="Nama Jabatan" enable-old-support required />
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
            <x-adminlte-button form="myform" type="submit" class="float-right" theme="success" label="Simpan" />
            <a href="{{ route('jabatan-kepeg.get') }}" class="btn btn-danger mr-1 float-right">Kembali</a>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
