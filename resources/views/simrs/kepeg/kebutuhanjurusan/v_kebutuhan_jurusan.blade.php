@extends('adminlte::page')
@section('title', 'Kebutuhan Jurusan')
@section('content_header')
    <h1>Kebutuhan Jurusan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            
            <div class="col-md-12">
                <x-adminlte-card theme="success" icon="fas fa-info-circle" collapsible
                title="List Jurusan dan Kebutuhan">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-3">
                            <x-adminlte-small-box
                            theme="success" 
                            text="Tambah Data Baru"
                            url="#"
                            data-toggle="modal" data-target="#addKebutuhan"
                            url-text="Buat Data Baru" />
                            <x-adminlte-modal id="addKebutuhan" title="Kebutuhan Jurusan" size="md" theme="success"
                                v-centered static-backdrop scrollable>
                                <form action="{{route('data-jurusan.add')}}" id="addKebutuhanJurusan" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div style="height:220px;">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <x-adminlte-select2 name="id_jurusan" label="Pilih Jurusan">
                                                        <option value="" >--Pilih Jurusan--</option>
                                                        @foreach ($data as $item)
                                                            <option value="{{ $item->id }}">{{$item->nama_jurusan}}</option>
                                                        @endforeach
                                                    </x-adminlte-select2>
                                                </div>
                                                <div class="col-lg-6">
                                                    <x-adminlte-input name="kebutuhan_lk" label="Kebutuhan Laki-Laki"
                                                    enable-old-support required />
                                                </div>
                                                <div class="col-lg-6">
                                                    <x-adminlte-input name="kebutuhan_pr" label="Kebutuhan Perempuan"
                                                    enable-old-support required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <x-slot name="footerSlot">
                                        <x-adminlte-button theme="danger" label="batalkan" class="mr-auto" data-dismiss="modal"/>
                                        <x-adminlte-button type="submit" form="addKebutuhanJurusan"  class="bg-success" label="Simpan Data"/>
                                    </x-slot>
                                </form>
                            </x-adminlte-modal>
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box
                                theme="purple" 
                                text="jurusan & Kebutuhan"
                                data-toggle="modal" data-target="#importJurusan"
                                url="#"
                                url-text="Import Data Baru" />
                        </div>
                        <x-adminlte-modal id="importJurusan" title="Import Jurusan" size="md" theme="purple"
                            icon="fas fa-upload" v-centered static-backdrop scrollable>
                            <form action="{{route('data-jurusan.import')}}" id="importBidang" method="post" enctype="multipart/form-data">
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
                    $heads = ['No', 'Nama Jurusan','Keadaan L','Keadaan P','Kebutuhan L','Kebutuhan P','Kekurangan L','Kekurangan P', 'Action'];
                    $config['order'] = ['0', 'asc'];
                    $config['paging'] = false;
                    $config['info'] = false;
                    $config['scrollY'] = '400px';
                    $config['scrollCollapse'] = true;
                    $config['scrollX'] = true;
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config"
                    striped bordered hoverable compressed>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td >{{$item->nama_jurusan}}</td>
                                <td style="text-align: center; font-weight:bold;">{{$item->keadaan_lk == Null ? '-':$item->keadaan_lk}}</td>
                                <td style="text-align: center; font-weight:bold;">{{$item->keadaan_pr == Null ? '-': $item->keadaan_pr}}</td>
                                <td style="text-align: center; font-weight:bold;">{{$item->kebutuhan_lk == Null ? '-': $item->kebutuhan_lk}}</td>
                                <td style="text-align: center; font-weight:bold;">{{$item->kebutuhan_pr == Null ? '-': $item->kebutuhan_pr}}</td>
                                <td style="text-align: center; font-weight:bold;">{{$item->kekurangan_lk == Null ? '-': $item->kekurangan_lk}}</td>
                                <td style="text-align: center; font-weight:bold;">{{$item->kekurangan_pr == Null ? '-': $item->kekurangan_pr}}</td>
                                <td> 
                                    <x-adminlte-button class="btn-xs" theme="warning" icon="fas fa-edit"
                                    onclick="window.location='{{ route('data-kebutuhan.edit', $item->id) }}'" />
                                </td>
                            </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                @php
                                    $total = $data->sum('keadaan_lk')+$data->sum('keadaan_pr');
                                @endphp
                                <th style="text-align: center; font-weight:bold;" colspan="2">Total ( {{$total}})</th>
                                <th style="text-align: center; font-weight:bold;">{{$sum->sum('keadaan_lk')}}</th>
                                <th style="text-align: center; font-weight:bold;">{{$sum->sum('keadaan_pr')}}</th>
                                <th style="text-align: center; font-weight:bold;">{{$sum->sum('kebutuhan_lk')}}</th>
                                <th style="text-align: center; font-weight:bold;">{{$sum->sum('kebutuhan_pr')}}</th>
                                <th style="text-align: center; font-weight:bold;">{{$sum->sum('kekurangan_lk')}}</th>
                                <th style="text-align: center; font-weight:bold;">{{$sum->sum('kekurangan_pr')}}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                </x-adminlte-datatable>
                
            </x-adminlte-card>
            </div>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.BsCustomFileInput', true)


