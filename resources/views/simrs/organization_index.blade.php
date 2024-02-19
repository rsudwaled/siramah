@extends('adminlte::page')

@section('title', 'Referensi Unit')

@section('content_header')
    <h1>Referensi Unit</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Unit" theme="info" icon="fas fa-info-circle" collapsible maximizable>
                @php
                    $heads = ['Kode Unit', 'Kode JKN', 'ID Organization', 'ID Location', 'Nama Unit', 'Kelas', 'Lokasi', 'Daftar', 'Status'];
                    $config['paging'] = false;
                    $config['info'] = false;
                    $config['scrollY'] = '500px';
                    $config['scrollCollapse'] = true;
                    $config['scrollX'] = true;
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($unit as $item)
                        <tr>
                            <td>{{ $item->kode_unit }}</td>
                            <td>{{ $item->KDPOLI }}</td>
                            <td>
                                {{ $item->id_satusehat }}
                                @if ($item->id_satusehat)
                                    <a href="{{ route('organization_sync') }}?kode={{ $item->kode_unit }}"
                                        class="btn btn-xs btn-warning"> <i class="fas fa-sync"></i> Sync</a>
                                @else
                                    <a href="{{ route('organization_sync') }}?kode={{ $item->kode_unit }}"
                                        class="btn btn-xs btn-warning"> <i class="fas fa-sync"></i> Sync</a>
                                @endif
                            </td>
                            <td>
                                {{ $item->id_location }}
                                @if ($item->id_location)
                                    <a href="{{ route('location_sync') }}?kode={{ $item->kode_unit }}"
                                        class="btn btn-xs btn-warning"> <i class="fas fa-sync"></i> Sync</a>
                                @else
                                    <a href="{{ route('location_sync') }}?kode={{ $item->kode_unit }}"
                                        class="btn btn-xs btn-warning"> <i class="fas fa-sync"></i> Sync</a>
                                @endif
                            </td>
                            <td>{{ $item->nama_unit }}</td>
                            <td>{{ $item->kelas_unit }}</td>
                            <td>{{ $item->lokasi ? $item->lokasi->lokasi : '-' }}</td>
                            <td>{{ $item->lokasi ? $item->lokasi->loket_pendaftaran : '-' }}</td>

                            <td>
                                <x-adminlte-button class="btn-xs btnEditPoli" theme="warning" icon="fas fa-edit"
                                    data-toggle="tooltip" title="Edit Unit" data-id="{{ $item->id }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    {{-- modal poliklinik --}}
    <x-adminlte-modal id="modalPoli" name="modalPoli" title="Unit" theme="warning" icon="fas fa-prescription-bottle-alt"
        static-backdrop>
        <form name="formUpdatePoli" id="formUpdatePoli" action="{{ route('poliklinik.store') }}" method="POST">
            @csrf
            <input type="hidden" name="method" value="UPDATE">
            <input type="hidden" name="idpoli" id="idpoli">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="kodepoli" label="Kode Unit" placeholder="Kode Unit" enable-old-support
                        readonly />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="namapoli" label="Nama Unit" placeholder="Nama Unit" enable-old-support
                        readonly />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="kodesubspesialis" label="Kode Subspesialis" placeholder="Kode Subspesialis"
                        enable-old-support readonly />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="namasubspesialis" label="Nama Subspesialis" placeholder="Nama Subspesialis"
                        enable-old-support readonly />
                </div>
                <div class="col-md-4">
                    <x-adminlte-input name="lokasi" label="Lokasi Unit" placeholder="Lokasi Unit" enable-old-support />
                </div>
                <div class="col-md-4">
                    <x-adminlte-input name="lantaipendaftaran" label="Lantai Pendaftaran" placeholder="Lantai Pendaftaran"
                        enable-old-support />
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="status" value="false">
                    <x-adminlte-input-switch name="status" label="Stasus Aktif" data-on-text="YES" data-off-text="NO"
                        data-on-color="primary" />
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button label="Update" form="formUpdatePoli" class="mr-auto withLoad" type="submit"
                    theme="success" icon="fas fa-edit" />
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Close" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.BootstrapSwitch', true)
