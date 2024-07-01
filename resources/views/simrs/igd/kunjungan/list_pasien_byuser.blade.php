@extends('adminlte::page')

@section('title', 'RIWAYAT PENDAFTARAN')
@section('content_header')
    <div class="alert bg-primary alert-dismissible">
        <h5>
            <i class="fas fa-user-tag"></i> RIWAYAT PENDAFTARAN :
        </h5>
    </div>
@stop

@section('content')

    <div class="card card-primary card-outline card-tabs ">
        <div class="col-lg-12 mt-2">
            <div class="row">
                <div class="col-lg-6">
                    @php
                        $heads = [
                            'MASUK',
                            'JENIS DAFTAR',
                            'JENIS RANAP',
                            'UNIT',
                            'PETUGAS',
                            'PASIEN',
                            'DIAGNOSA | SEP | SPRI',
                        ];
                        $config['order'] = ['0', 'asc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '400px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark" :config="$config"
                        striped bordered hoverable compressed>
                        @foreach ($kunjungan as $item)
                            <tr>
                                <td>{{ $item->tgl_masuk }} </td>
                                <td>
                                    <b>{{ $item->jp_daftar == 1 ? 'BPJS' : ($item->jp_daftar == 0 ? 'UMUM' : 'BPJS PROSES') }}</b>
                                    <br>
                                    @role('Admin Super')
                                        <small>
                                            <a class="btn btn-success btn-xs">
                                                @if (is_null($item->form_send_by))
                                                    DEKSTOP
                                                @else
                                                    {{ $item->form_send_by == 0 ? 'FORM DAFTAR' : 'FORM RANAP' }}
                                                @endif
                                            </a>
                                        </small>
                                    @endrole
                                </td>
                                <td><b>{{ $item->jp_daftar == 1 ? 'RANAP BPJS' : ($item->is_ranap == 0 ? 'RANAP UMUM' : 'RAWAT INAP') }}</b>
                                </td>
                                <td><b>{{ $item->unit->nama_unit }}</b></td>
                                <td>
                                    {{-- @role('Admin Super')
                                        @php
                                            $user = App\Models\User::where('id', $item->pic2)->first();
                                        @endphp
                                        <b>{{ $user->username }}</b>
                                    @endrole --}}
                                    -
                                </td>
                                <td>
                                    <b>
                                        No RM : {{ $item->no_rm }} <br>
                                        Nama : {{ $item->pasien->nama_px }}<br>
                                        NIK : {{ $item->pasien->nik_bpjs }} <br>
                                    </b>
                                </td>
                                <td>
                                    <b>Diagnosa : {{ $item->diagx ?? '-' }}</b><br>
                                    SEP : {{ $item->no_sep ?? '-' }} <br>
                                    SPRI : {{ $item->no_spri ?? '-' }} <br>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
                <div class="col-lg-6">
                    @php
                        $heads = ['RM','PASIEN', 'ALAMAT', 'LOKASI TERBARU'];
                        $config['order'] = ['0', 'asc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '400px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" head-theme="dark"
                        :config="$config" striped bordered hoverable compressed>
                        @foreach ($pasiens as $data)
                            <tr>
                                <td>{{$data->no_rm}}</td>
                                <td>{{$data->nama_px}}</td>
                                <td>
                                    <strong>
                                        Provinsi: {{$data->lokasiProvinsi->name}}<br>
                                        Kabupaten: {{$data->lokasiKabupaten->name}}<br>
                                        Kecamatan: {{$data->lokasiKecamatan->name}}<br>
                                        Desa: {{$data->lokasiDesa->name??'DATA TIDAK ADA'}}<br>
                                    </strong>
                                </td>
                                <td>-</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
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
