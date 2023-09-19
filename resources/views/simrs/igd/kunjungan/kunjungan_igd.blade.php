@extends('adminlte::page')

@section('title', 'Kunjungan Pasien')
@section('content_header')
    <h1>Kunjungan Pasien : {{\Carbon\Carbon::now()->format('Y-m-d');}}</h1>
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
          <span class="info-box-number"> 10</span>
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
          <span class="info-box-number">50</span>
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
    <x-adminlte-card theme="primary" collapsible title="Daftar Kunjungan :">
        @php
            $heads = ['No RM', 'Unit', 'Tanggal Masuk', 'Tanggal keluar', 'Diagnosa', 'No SEP','action'];
            $config['order'] = ['0', 'asc'];
            $config['paging'] = true;
            $config['info'] = false;
            $config['scrollY'] = '350px';
            $config['scrollCollapse'] = true;
            $config['scrollX'] = true;
        @endphp
        <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config"
            striped bordered hoverable compressed>
            @foreach ($kunjungan as $item)
                <tr>
                    <td>{{$item->no_rm}}</td>
                    <td>{{$item->kode_unit}}</td>
                    <td>{{$item->tgl_masuk}}</td>
                    <td>{{$item->tgl_keluar == null ? 'pasien belum keluar' :$item->tgl_keluar}}</td>
                    <td>{{$item->diagx}}</td>
                    <td>{{$item->no_sep}}</td>
                    <td>
                        <x-adminlte-button class="btn-xs" theme="warning" icon="fas fa-edit"
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