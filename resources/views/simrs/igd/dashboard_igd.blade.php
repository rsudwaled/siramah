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
                                                <td></td>
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
                                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne"
                                        aria-expanded="false">
                                        Pasien Harus Di BRIDGING #1
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <ul class="products-list product-list-in-card">
                                        <li class="item">
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">Samsung TV
                                                    <span class="badge badge-warning float-right">$1800</span></a>
                                                <span class="product-description">
                                                    Samsung 32" 1080p 60Hz LED Smart HDTV.
                                                </span>
                                            </div>
                                        </li>

                                        <li class="item">
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">Bicycle
                                                    <span class="badge badge-info float-right">$700</span></a>
                                                <span class="product-description">
                                                    26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                                                </span>
                                            </div>
                                        </li>

                                        <li class="item">
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">
                                                    Xbox One <span class="badge badge-danger float-right">
                                                        $350
                                                    </span>
                                                </a>
                                                <span class="product-description">
                                                    Xbox One Console Bundle with Halo Master Chief Collection.
                                                </span>
                                            </div>
                                        </li>

                                        <li class="item">
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">PlayStation 4
                                                    <span class="badge badge-success float-right">$399</span></a>
                                                <span class="product-description">
                                                    PlayStation 4 500GB Console (PS4)
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
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
@endsection
