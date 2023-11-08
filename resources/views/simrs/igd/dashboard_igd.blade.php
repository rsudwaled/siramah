@extends('adminlte::page')

@section('title', 'Dashboard IGD')
@section('content_header')
    <h1>Dashboard IGD</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="accordion">
                        <div class="card card-success">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#pasienbpjs" aria-expanded="true">
                                        PASIEN BPJS
                                    </a>
                                </h4>
                            </div>
                            <div id="pasienbpjs" class="collapse show" data-parent="#accordion" style="">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="card-body">
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
                                                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads"
                                                        :config="$config" striped bordered hoverable compressed>
                                                        @foreach ($kunNow as $item)
                                                            <tr>
                                                                <td>{{ $item->no_rm }}</td>
                                                                <td><span
                                                                        class="badge {{ $item->prefix_kunjungan == 'UGD' ? 'badge-warning' : 'badge-info' }}">{{ $item->prefix_kunjungan }}</span>
                                                                </td>
                                                                <td><span class="badge badge-success">IN : </span>
                                                                    {{ $item->tgl_masuk }} /
                                                                    <span class="badge badge-danger">OUT :
                                                                    </span>
                                                                    {{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}
                                                                </td>
                                                                <td>{{ $item->diagx }}</td>
                                                                <td>{{ $item->no_sep }}</td>
                                                                <td><span class="badge badge-danger p-1 btn-xs">BELUM
                                                                        BRIDGING</span></td>
                                                                <td>
                                                                    <x-adminlte-button class="btn-xs" theme="success"
                                                                        label="BRIDGING NOW!"
                                                                        onclick="window.location='#'" />
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </x-adminlte-datatable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mt-3">
                                        <div id="accordion">
                                            <div class="card card-success">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        <a class="d-block w-100 collapsed" data-toggle="collapse"
                                                            aria-expanded="false">
                                                            Pasien Harus Di BRIDGING ada : {{ $kunNow->count() }}
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div class="collapsed" data-parent="#accordion" style="">
                                                    <ul class="products-list product-list-in-card">
                                                        <li class="item">
                                                            <div class="product-info">
                                                                <a class="product-title">PASIEN IGD UMUM
                                                                    <span class="badge badge-warning float-right"
                                                                        style="font-size: 15px;">{{ $igdbpjs_count }}
                                                                        PASIEN</span></a>
                                                                <span class="product-description">
                                                                    JUMLAH IGD YANG BELUM BRIDGING
                                                                </span>
                                                            </div>
                                                        </li>

                                                        <li class="item">
                                                            <div class="product-info">
                                                                <a class="product-title">PASIEN IGD KEBIDANAN
                                                                    <span class="badge badge-info float-right"
                                                                        style="font-size: 15px;">{{ $igkbpjs_count }}
                                                                        PASIEN</span></a>
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

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                    PASIEN RANAP
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="col-lg-12">
                                        @php
                                            $heads = ['Unit', 'Tanggal', 'Ruangan', 'Data Pasien', 'alamat', 'action'];
                                            $config['order'] = ['0', 'asc'];
                                            $config['paging'] = true;
                                            $config['info'] = true;
                                            $config['scrollY'] = '450px';
                                            $config['scrollCollapse'] = true;
                                            $config['scrollX'] = true;
                                        @endphp
                                        <x-adminlte-datatable id="table2" class="text-xs" :heads="$heads"
                                            :config="$config" striped bordered hoverable compressed>
                                            @foreach ($pasienRanap as $item)
                                                <tr>
                                                    <td><span
                                                            class="badge {{ $item->prefix_kunjungan == 'UGD' ? 'badge-warning' : 'badge-info' }}">{{ $item->prefix_kunjungan }}</span>
                                                    </td>
                                                    <td><span class="badge badge-success">IN : </span>
                                                        {{ $item->tgl_masuk }}
                                                        <br><span class="badge badge-danger">OUT :
                                                        </span>
                                                        {{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}
                                                    </td>
                                                    <td>{{ $item->ruanganRawat->nama_kamar }} / ( BED:
                                                        {{ $item->ruanganRawat->no_bed }} )</td>
                                                    <td>RM : {{ $item->no_rm }} <br><b>NAMA :
                                                            {{ $item->pasien->nama_px }}</b>
                                                        <br>
                                                        {{ $item->pasien->nik_bpjs == null ? 'NIK BELUM DIISI' : $item->pasien->nik_bpjs }}
                                                    </td>
                                                    <td>alamat : {{ $item->pasien->alamat }} / <br>
                                                        {{ $item->pasien->kode_desa < 1101010001 ? 'ALAMAT LENGKAP BELUM DI ISI!' : $item->pasien->desas->nama_desa_kelurahan . ' , Kec. ' . $item->pasien->kecamatans->nama_kecamatan . ' - Kab. ' . $item->pasien->kabupatens->nama_kabupaten_kota }}
                                                    </td>
                                                    <td>
                                                        <x-adminlte-button class="btn-xs" theme="primary" label="detail"
                                                            onclick="window.location='#'" />
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
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
@endsection
