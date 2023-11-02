@extends('adminlte::page')

@section('title', 'Dashboard IGD')
@section('content_header')
    <h1>Dashboard IGD</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card card card-primary card-outline">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">DATA PASIEN YANG BELUM BRIDGING BPJS : </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <div class="col-lg-12">
                                    @php
                                        $heads = ['RM', 'Unit', 'Tanggal', 'Diagnosa', 'No SEP', 'status kunjungan', 'action'];
                                        $config['order'] = ['0', 'asc'];
                                        $config['paging'] = true;
                                        $config['info'] = true;
                                        $config['scrollY'] = '450px';
                                        $config['scrollCollapse'] = true;
                                        $config['scrollX'] = true;
                                    @endphp
                                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config"
                                        striped bordered hoverable compressed>
                                        @foreach ($kunNow as $item)
                                            <tr>
                                                <td>{{ $item->no_rm }}</td>
                                                <td>{{ $item->prefix_kunjungan}}</td>
                                                <td><span class="badge badge-success">IN : </span> {{ $item->tgl_masuk }} /
                                                    <span class="badge badge-danger">OUT :
                                                    </span> {{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}
                                                </td>
                                                <td>{{ $item->diagx }}</td>
                                                <td>{{ $item->no_sep }}</td>
                                                <td><span class="badge badge-success">SUDAH BRIDGING</span></td>
                                                <td>
                                                    <x-adminlte-button class="btn-xs" theme="primary" label="BRIDGING"
                                                        onclick="window.location='#'" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </x-adminlte-datatable>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-success float-right">Lihat Semua Data</a>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3">
                    <div id="accordion">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100 collapsed" data-toggle="collapse"
                                        aria-expanded="false">
                                        Pasien Harus Di BRIDGING #1
                                    </a>
                                </h4>
                            </div>
                            <div class="collapsed" data-parent="#accordion" style="">
                                <ul class="products-list product-list-in-card">
                                    <li class="item">
                                        <div class="product-info">
                                            <a class="product-title">PASIEN IGD UMUM
                                                <span class="badge badge-warning float-right">10 PASIEN</span></a>
                                            <span class="product-description">
                                               JUMLAH IGD YANG BELUM BRIDGING
                                            </span>
                                        </div>
                                    </li>

                                    <li class="item">
                                        <div class="product-info">
                                            <a class="product-title">PASIEN IGD KEBIDANAN
                                                <span class="badge badge-info float-right">5 PASIEN</span></a>
                                            <span class="product-description">
                                                JUMLAH IGK YANG BELUM DI BRIDGING.
                                            </span>
                                        </div>
                                    </li>
                                </ul>

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
