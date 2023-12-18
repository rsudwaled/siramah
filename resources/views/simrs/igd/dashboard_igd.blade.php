@extends('adminlte::page')

@section('title', 'Dashboard IGD')
@section('content_header')
    <h1>Dashboard IGD</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1">
                                        <i class="fas fa-users"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">IGD UMUM</span>
                                        <span class="info-box-number"> {{ $ugd }} pasien</span>
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
                                        <span class="info-box-number">{{ $ugdkbd }} pasien</span>
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
                                        <span class="info-box-number">- pasien</span>
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
                                        <span class="info-box-number">- pasien</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#pasienbpjs" aria-expanded="true">
                                            PASIEN IGD / IGK
                                        </a>
                                    </h4>
                                </div>
                                <div id="pasienbpjs" class="collapse show" data-parent="#accordion" style="">
                                    <div class="card-body">
                                        <div class="col-lg-12">
                                            @php
                                                $heads = ['Pasien', 'kunjungan', 'Diagnosa / No SEP', 'status', 'detail'];
                                                $config['order'] = false;
                                                $config['paging'] = true;
                                                $config['info'] = false;
                                                $config['scrollY'] = '500px';
                                                $config['scrollCollapse'] = true;
                                                $config['scrollX'] = true;
                                            @endphp
                                            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads"
                                                :config="$config" striped bordered hoverable compressed>
                                                @foreach ($kunjungan as $item)
                                                    <tr>
                                                        <td><b>{{ $item->pasien }}</b> <br>RM : {{ $item->rm }} <br>NIK :
                                                            {{ $item->nik }} <br>No Kartu : {{ $item->noKartu }}</td>
                                                        <td>
                                                            <b>Tanggal Masuk : {{ $item->tgl_kunjungan }}</b> <br>
                                                            {{ $item->kunjungan }} <br> ({{ $item->nama_unit }})
                                                        </td>
                                                        <td>
                                                            {{ $item->diagx == null ? '': 'Diagnosa : '.$item->diagx.' / ' }} <br>
                                                           <b> {{ $item->sep == null ? '': 'SEP : '. $item->sep}}</b>
                                                        </td>
                                                        <td>{{ $item->status }}</td>
                                                        <td>
                                                            @if (!empty($item->sep))
                                                                <x-adminlte-button type="button" theme="success"
                                                                    class="btn-flat btn-xs" label="sudah bridging" />
                                                            @else
                                                                <x-adminlte-button type="button" theme="danger"
                                                                    class="btn-flat btn-xs" label="belum bridging" />
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </x-adminlte-datatable>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-lg-6">
                            <div class="card card-purple">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" >
                                            PASIEN RANAP
                                        </a>
                                    </h4>
                                </div>
                                <div class="collapse show">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="col-lg-12">
                                                @php
                                                    $heads = ['KUNJUNGAN', 'PASIEN', 'ALAMAT','STATUS'];
                                                    $config['order'] = ['0', 'desc'];
                                                    $config['paging'] = false;
                                                    $config['info'] = false;
                                                    $config['scrollY'] = '500px';
                                                    $config['scrollCollapse'] = true;
                                                    $config['scrollX'] = true;
                                                @endphp
                                                <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads"
                                                    :config="$config" striped bordered hoverable compressed>
                                                    @foreach ($pasienranap as $ranap)
                                                        <tr>
                                                            <td>
                                                                <b>TGL : {{ $ranap->tgl_kunjungan }}</b> <br>
                                                                Kunjungan : {{ $ranap->kunjungan }} ({{ $ranap->nama_unit }}) <br>
                                                                Status : {{ $ranap->status }}
                                                            </td>
                                                            <td>
                                                                <b>NAMA : {{ $ranap->pasien }}</b> <br>
                                                                RM : {{ $ranap->rm }} <br>
                                                                BPJS : {{ $ranap->noKartu }} <br>
                                                                NIK : {{ $ranap->nik }} <br>
                                                                Gender : {{ $ranap->jk == 'P' ? 'Perempuan' : 'Laki-Laki' }}
                                                            </td>
                                                            <td width="15%">
                                                                <small>{{ $ranap->alamat }}</small>
                                                            </td>
        
                                                            <td>
                                                                Ranap :
                                                                {{ $ranap->status_ranap == 1 ? 'Pasien Ranap' : 'Pasien Umum' }}
                                                                <br>
                                                                <b>Daftar :
                                                                    {{ $ranap->status_pasien_daftar == 1 ? 'PASIEN BPJS' : 'UMUM' }}</b>
                                                            </td>
                                                            
                                                        </tr>
                                                    @endforeach
                                                </x-adminlte-datatable>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
