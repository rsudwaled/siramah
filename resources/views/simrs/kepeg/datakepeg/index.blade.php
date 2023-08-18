@extends('adminlte::page')
@section('title', 'Data Pegawai')
@section('content_header')
    <h1>Informasi Pegawai</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-4">
                    <x-adminlte-small-box
                        title="99"
                        theme="primary" 
                        text="Pegawai Pria"
                        icon="fas fa-user-injured"
                        url="#"
                        url-text="Lihat Data" />
                </div>
                <div class="col-md-4">
                    <x-adminlte-small-box
                        title="100"
                        theme="warning"
                        text="Pegawai Pria" 
                        icon="fas fa-user-injured"
                        url="#"
                        url-text="Lihat Data" />
                </div>
                <div class="col-md-4">
                    <x-adminlte-small-box
                        title="Data Baru"
                        theme="success" 
                        text="Tambah Data Baru"
                        icon="fas fa-user-injured"
                        url="#"
                        url-text="Buat Data Baru" />
                </div>
            </div>
            <div class="col-md-12">
                <x-adminlte-card theme="success" icon="fas fa-info-circle" collapsible
                    title="List Data Pegawai">
                    @php
                        $heads = ['NIK', ' Nama', 'Jenis Kelamin', 'Alamat', 'Kedudukan', 'Pendidikan','Action'];
                        $config['order'] = ['0', 'asc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '400px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config"
                        striped bordered hoverable compressed>
                            <tr>
                                <td>
                                    <b>sngk</b>
                                </td>
                                <td>
                                    nomr<br>
                                </td>
                                <td>
                                    jns
                                </td>
                                <td>Offline</td>
                                <td>
                                    000
                                </td>
                                <td>
                                    ...
                                </td>
                                <td>
                                    <span class="badge bg-secondary">0. Antri Pendaftaran</span>
                                    
                                </td>
                                <td>
                                    Loket
                                </td>
                                <td>
                                    <a class="btn btn-xs mt-1 btn-success"
                                        href="#">
                                        <i class="fas fa-user-plus"></i> Selesai</a>

                                    <x-adminlte-button class="btn-xs mt-1 withLoad" label="Panggil" theme="primary"
                                        icon="fas fa-volume-down" data-toggle="tooltip"
                                        title="Panggil Antrian "
                                        onclick="window.location='#'" />

                                    <x-adminlte-button class="btn-xs mt-1 withLoad" theme="danger"
                                        icon="fas fa-times" data-toggle="tooltop"
                                        title="Batal Antrian "
                                        onclick="window.location='#'" />

                                </td>
                            </tr>
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)


