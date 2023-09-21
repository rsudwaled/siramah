@extends('adminlte::page')

@section('title', 'Kunjungan Pasien')
@section('content_header')
    <h1>Kunjungan Pasien : {{ \Carbon\Carbon::now()->format('Y-m-d') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1">
                    <i class="fas fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">IGD UMUM</span>
                    <span class="info-box-number"> {{ $ugd }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">IGD KEBIDANAN</span>
                    <span class="info-box-number">{{ $ugdkbd }}</span>
                </div>
            </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
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
        <div class="col-12 col-sm-6 col-md-3">
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
    <div class="col-lg-12">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4">
                    <button type="button" class="btn btn-block bg-gradient-primary btn-sm mb-2" data-toggle="modal"
                        data-target="#tutupKunjungan">Tutup
                        kunjungan</button>
                    <x-adminlte-modal id="tutupKunjungan" title="Tutup Kunjungan :" size="lg" theme="primary"
                        v-centered static-backdrop>
                        <form action="{{ route('tutup-kunjungan-bykode') }}" id="tutupkunjunganByKode" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <x-adminlte-input type="text" name="rm_tk" label="No RM" disable-feedback
                                                disabled />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-adminlte-input type="text" name="kunjungan_tk" label="Kode Kunjungan"
                                                disable-feedback disabled />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="danger" class="mr-auto" label="batal" data-dismiss="modal" />
                                <x-adminlte-button type="submit" form="tutupkunjunganByKode"
                                    class="btn btn-sm m-1 bg-green float-right" label="Tutup Kunjungan" />
                            </x-slot>
                        </form>
                    </x-adminlte-modal>
                </div>
            </div>
        </div>
        <x-adminlte-card theme="primary" collapsible title="Daftar Kunjungan :">
            @php
                $heads = ['No RM', 'Unit', 'Tanggal Masuk', 'Tanggal keluar', 'Diagnosa', 'No SEP', 'status kunjungan', 'action'];
                $config['order'] = ['0', 'asc'];
                $config['paging'] = true;
                $config['info'] = false;
                $config['scrollY'] = '350px';
                $config['scrollCollapse'] = true;
                $config['scrollX'] = true;
            @endphp
            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config" striped bordered
                hoverable compressed>
                @foreach ($kunjungan as $item)
                    <tr>
                        <td>{{ $item->no_rm }}</td>
                        <td>{{ $item->kode_unit }}</td>
                        <td>{{ $item->tgl_masuk }}</td>
                        <td>{{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}</td>
                        <td>{{ $item->diagx }}</td>
                        <td>{{ $item->no_sep }}</td>
                        <td><button type="button"
                                class="btn {{ $item->status_kunjungan == 2 ? 'btn-block bg-gradient-danger disabled' : ($item->status_kunjungan == 1 ? 'btn-success' : 'btn-success') }} btn-block btn-flat btn-xs">{{ $item->status_kunjungan == 2 ? 'kunjungan ditutup' : ($item->status_kunjungan == 1 ? 'kunjungan aktif' : 'kunjungan dibatalkan') }}</button>
                        </td>
                        <td>
                            <x-adminlte-button class="btn-xs" theme="danger" label="tutup kunjungan"
                                onclick="window.location='#'" />
                            <x-adminlte-button class="btn-xs" theme="warning" label="buka kunjungan"
                                onclick="window.location='#'" />
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>

        </x-adminlte-card>
    </div>
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
