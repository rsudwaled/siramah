@extends('adminlte::page')

@section('title', 'Pilih Pendaftaran Pasien')
@section('content_header')
    <h1>Pilih Pendaftaran untuk Pasien : {{$pasien->nama_px}}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-lg-12">
                <x-adminlte-card theme="warning" icon="fas fa-info-circle" class="mt-5" title="Pilih Jenis Pendaftaran:">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4">
                                <x-adminlte-small-box title="IGD" text="Pasien BPJS" icon="fas fa-xs fa-address-card text-dark" theme="success" url="#" url-text="Daftarkan Pasien" id="sbUpdatable"/>
                            </div>
                            <div class="col-lg-4">
                                <x-adminlte-small-box title="IGD" text="Pasien Umum" icon="fas fa-xs fab fa-user-nurse text-dark" theme="info" url="#" url-text="Daftarkan Pasien" id="sbUpdatable"/>
                            </div>
                            <div class="col-lg-4">
                                <x-adminlte-small-box title="IGD" text="Pasien Ranap" icon="fas fa-xs fa-bed text-dark" theme="warning" url="#" url-text="Daftarkan Pasien" id="sbUpdatable"/>
                            </div>
                        </div>
                    </div>
                </x-adminlte-card>
            </div>
            <div class="col-lg-12">
                <x-adminlte-card theme="success" icon="fas fa-info-circle" collapsible
                        title="Data Pasien: {{$pasien->nama_px}}">
                        <div class="row">
                            <div class="col-md-3">
                                <x-adminlte-profile-widget name="{{$pasien->no_rm}}" desc="{{$pasien->nama_px}}" theme="success">
                                    <input type="hidden" value="{{$pasien->no_rm}}" id="pasien_id">
                                    <x-adminlte-profile-row-item icon="fas fa-fw fa-user-friends" title="{{$pasien->jenis_kelamin=='L'? 'Laki-Laki':'Perempuan'}}"
                                        url="#" badge="teal"/>
                                    <x-adminlte-profile-row-item icon="fas fa-fw fa-user-friends fa-flip-horizontal" title="{{$pasien->alamat}}"
                                        text="alamat" url="#" badge="lightblue"/>
                                    <x-adminlte-profile-row-item icon="fas fa-fw fa-sticky-note" title="{{$pasien->nik_bpjs}}" text="NIK"
                                        url="#" badge="navy"/>
                                    <x-adminlte-profile-row-item icon="fas fa-fw fa-sticky-note" title="{{$pasien->no_Bpjs==null ? 'tidak punya bpjs' : $pasien->no_Bpjs}}" text="No BPJS"
                                        url="#" badge="navy"/>
                                </x-adminlte-profile-widget>
                            </div>
                            <div class="col-md-8">
                                @php
                                    $heads = ['Kunjungan', 'Unit', 'Tanggal Masuk', 'Tanggal keluar', 'Penjamin', 'Petugas', 'Catatan'];
                                    $config['order'] = ['0', 'asc'];
                                    $config['paging'] = false;
                                    $config['info'] = false;
                                    $config['scrollY'] = '450px';
                                    $config['scrollCollapse'] = true;
                                    $config['scrollX'] = true;
                                @endphp
                                <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" :config="$config"
                                    striped bordered hoverable compressed>
                                    @foreach ($kunjungan as $item)
                                        <tr>
                                            <td>{{$item->Kun}}</td>
                                            <td>{{$item->nama_unit}}</td>
                                            <td>{{$item->tgl_masuk}}</td>
                                            <td>{{$item->tgl_keluar == null ? 'pasien belum keluar' :$item->tgl_keluar}}</td>
                                            <td>{{$item->nama_penjamin}}</td>
                                            <td>{{$item->nama_user}}</td>
                                            <td>{{$item->CATATAN==null? 'tidak ada' : $item->CATATAN}}</td>
                                        </tr>
                                    @endforeach
                                </x-adminlte-datatable>
                            </div>
                        </div>
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
@section('plugins.Sweetalert2', true)
@section('js')

@endsection