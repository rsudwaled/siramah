@extends('adminlte::page')
@section('title', 'data jabatan')
@section('content_header')
    <h1>Informasi Jabatan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-6">
                        <x-adminlte-card theme="success" icon="fas fa-info-circle" collapsible
                            title="List data jabatan">
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-adminlte-small-box
                                    title="Data Baru"
                                    theme="success" 
                                    text="Tambah Data Baru"
                                    icon="fas fa-user-injured"
                                    data-toggle="modal" data-target="#tambahJabatan"
                                    url-text="Buat Data Baru" />
                                </div>
                                <x-adminlte-modal id="tambahJabatan" title="Tambah jabatan" size="md" theme="green" v-centered static-backdrop scrollable>
                                    <form action="{{route('jabatan.add')}}" id="jabatan" method="post">
                                        @csrf
                                        <div style="height:100px;">
                                            <x-adminlte-input name="nama_jabatan" label="Nama Jabatan" placeholder="nama jabatan" label-class="text-green">
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-user text-green"></i>
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-input>
                                        </div>
                                        <x-slot name="footerSlot">
                                            <x-adminlte-button theme="danger" label="Batalkan" class="mr-auto"  data-dismiss="modal"/>
                                            <x-adminlte-button type="submit" form="jabatan" theme="success" label="Tambahkan"/>
                                        </x-slot>
                                    </form>
                                </x-adminlte-modal>
                            </div>
                            @php
                                $heads = ['No', 'Nama Jabatan', 'Action'];
                                $config['order'] = ['0', 'asc'];
                                $config['paging'] = false;
                                $config['info'] = false;
                                $config['scrollY'] = '450px';
                                $config['scrollCollapse'] = true;
                                $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config"
                                striped bordered hoverable compressed>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->nama_jabatan}}</td>
                                            <td>
                                                <x-adminlte-button class="btn-xs" theme="warning" icon="fas fa-edit"
                                                onclick="window.location='{{ route('jabatan-kepeg.edit', $item->id) }}'" />
                                            </td>
                                        </tr>
                                    @endforeach
                            </x-adminlte-datatable>
                        </x-adminlte-card>
                    </div>
                    {{-- data bidang pegawai --}}
                    <div class="col-lg-6">
                        <x-adminlte-card theme="warning" icon="fas fa-info-circle" collapsible
                            title="List Bidang Pegawai">
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-adminlte-small-box
                                    title="Data Baru"
                                    theme="yellow" 
                                    text="Tambah Data Baru"
                                    icon="fas fa-user-injured"
                                    data-toggle="modal" data-target="#tambahBidang"
                                    url-text="Buat Data Baru" />
                                    <x-adminlte-modal id="tambahBidang" title="Tambah Bidang" size="md" theme="yellow" v-centered static-backdrop scrollable>
                                        <form action="{{route('bidang.add')}}" id="bidang" method="post">
                                            @csrf
                                            <div style="height:100px;">
                                                <x-adminlte-input name="nama_bidang" label="Nama Bidang" placeholder="nama bidang" label-class="text-green">
                                                    <x-slot name="prependSlot">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-user text-green"></i>
                                                        </div>
                                                    </x-slot>
                                                </x-adminlte-input>
                                            </div>
                                            <x-slot name="footerSlot">
                                                <x-adminlte-button theme="danger" label="Batalkan" class="mr-auto"  data-dismiss="modal"/>
                                                <x-adminlte-button type="submit" form="bidang" theme="success" label="Tambahkan"/>
                                            </x-slot>
                                        </form>
                                    </x-adminlte-modal>
                                </div>
                                <div class="col-lg-6">
                                    <x-adminlte-small-box
                                    title="Import"
                                    theme="purple" 
                                    {{-- text="bidang pegawai" --}}
                                    icon="fas fa-upload"
                                    data-toggle="modal" data-target="#importDataBidang"
                                    url="#"
                                    url-text="Import Bidang Baru" />

                                    <x-adminlte-modal id="importDataBidang" title="Import Data Bidang" size="md" theme="purple"
                                    icon="fas fa-upload" v-centered static-backdrop scrollable>
                                    <form action="{{route('import-data-bidang')}}" id="importBidang" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div style="height:100px;">
                                            <x-adminlte-input-file name="file" igroup-size="sm" placeholder="Choose a file...">
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text bg-purple">
                                                        <i class="fas fa-upload"></i>
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-input-file>
                                        </div>
                                        <x-slot name="footerSlot">
                                            <x-adminlte-button theme="danger" label="batalkan" class="mr-auto" data-dismiss="modal"/>
                                            <x-adminlte-button type="submit" form="importBidang" class="bg-purple" label="import data"/>
                                        </x-slot>
                                    </form>
                                </x-adminlte-modal>
                                </div>
                            </div>
                            @php
                                $heads = ['No', 'Nama Bidang', 'Action'];
                                $config['order'] = ['0', 'asc'];
                                $config['paging'] = false;
                                $config['info'] = false;
                                $config['scrollY'] = '450px';
                                $config['scrollCollapse'] = true;
                                $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table2" class="nowrap text-xs" :heads="$heads" :config="$config"
                                striped bordered hoverable compressed>
                                    @foreach ($bidang as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->nama_bidang}}</td>
                                            <td>
                                                <x-adminlte-button class="btn-xs" theme="warning" icon="fas fa-edit"
                                                onclick="window.location='{{ route('bidang-kepeg.edit', $item->id) }}'" />
                                            </td>
                                        </tr>
                                    @endforeach
                            </x-adminlte-datatable>
                        </x-adminlte-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.BsCustomFileInput', true)


