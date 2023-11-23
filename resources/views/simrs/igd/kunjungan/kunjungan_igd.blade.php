@extends('adminlte::page')

@section('title', 'Kunjungan Pasien')
@section('content_header')
    <h1>Kunjungan Pasien : {{ \Carbon\Carbon::now()->format('Y-m-d') }}</h1>
@stop

@section('content')
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-6">
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
                                <span class="info-box-number">100 pasien</span>
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
                                <span class="info-box-number">10 pasien</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="info-box mb-3 bg-purple" data-toggle="modal" data-target="#editPenjamin">
                            <span class="info-box-icon"><i class="fas fa-door-open"></i></span>
                            <a href="#">
                                <div class="info-box-content">
                                    <span class="info-box-text">klik untuk buka edit Penjamin</span>
                                    <span class="info-box-number">Edit Penjamin</span>
                                </div>
                            </a>
                        </div>
                        <x-adminlte-modal id="editPenjamin" title="Edit Penjamin :" size="md" theme="purple" v-centered
                            static-backdrop>
                            <form action="{{ route('kunjungan-pasien.edit') }}" id="editPenjaminByKode" method="get">
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <x-adminlte-input name="no_rm" label="No RM" placeholder="no rm"
                                            label-class="text-purple">
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text">
                                                    <i class="fas fa-user text-purple"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                </div>
                                <x-slot name="footerSlot">
                                    <x-adminlte-button theme="danger" class="mr-auto" label="batal" data-dismiss="modal" />
                                    <x-adminlte-button type="submit" form="editPenjaminByKode"
                                        class="btn btn-sm m-1 bg-purple float-right" label="Cari Kunjungan" />
                                </x-slot>
                            </form>
                        </x-adminlte-modal>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-7">
                <x-adminlte-card theme="primary" collapsible title="Daftar Kunjungan :">
                    @php
                        $heads = ['Pasien', 'kunjungan', 'Unit', 'Tgl Masuk', 'Tgl keluar', 'Diagnosa', 'No SEP', 'status', 'action'];
                        $config['order'] = ['0', 'asc'];
                        $config['paging'] = true;
                        $config['info'] = false;
                        $config['scrollY'] = '500px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config" striped
                        bordered hoverable compressed>
                        @foreach ($kunjungan as $item)
                            <tr>
                                <td><b>{{ $item->pasien->nama_px }}</b> <br>RM : {{ $item->no_rm }} <br>NIK :
                                    {{ $item->pasien->nik_bpjs }}</td>
                                <td>{{ $item->kode_kunjungan }}</td>
                                <td>{{ $item->kode_unit }} ({{ $item->unit->nama_unit }})</td>
                                <td>{{ $item->tgl_masuk }}</td>
                                <td>{{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}</td>
                                <td>{{ $item->diagx }}</td>
                                <td>{{ $item->no_sep }}</td>
                                <td><button type="button"
                                        class="btn {{ $item->status_kunjungan == 2 ? 'btn-block bg-gradient-danger disabled' : ($item->status_kunjungan == 1 ? 'btn-success' : 'btn-success') }} btn-block btn-flat btn-xs">{{ $item->status_kunjungan == 2 ? 'ditutup' : ($item->status_kunjungan == 1 ? 'aktif' : 'dibatalkan') }}</button>
                                </td>
                                <td>
                                    <x-adminlte-button type="button" data-rm="{{ $item->no_rm }}"
                                        data-kunjungan="{{ $item->kode_kunjungan }}" data-diagx="{{ $item->diagx }}"
                                        theme="primary" class="btn-flat btn-xs btn-singkron" id="btn-singkron"
                                        label="Synch Diagnosa" />
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
            <div class="col-lg-5">
                <x-adminlte-card theme="warning" collapsible title="Synch Diagnosa :">
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="rm" id="rm" label="RM" label-class="primary" disabled>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="fas fa-user primary"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                                <x-adminlte-input name="kunjungan" id="kunjungan" label="Kunjungan" disabled
                                    label-class="primary">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="fas fa-user primary"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="refDiagnosa" id="refDiagnosa" label="Diagnosa Dokter" disabled
                                    label-class="primary">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="fas fa-user primary"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                                <x-adminlte-select2 name="syncDiagnosa" id="diagnosa" label="Pilih Diagnosa">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="fas fa-user primary"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <x-adminlte-button type="submit" class="btn btn-sm m-1 bg-primary float-right" label="update diagnosa" />
                    </form>
                </x-adminlte-card>
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
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btn-singkron').on('click', function() {
                let diag = $(this).data('diagx');
                let kunj = $(this).data('kunjungan');
                let rm = $(this).data('rm');
                $('#refDiagnosa').val(diag);
                $('#kunjungan').val(kunj);
                $('#rm').val(rm);
            });

            $("#diagnosa").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_diagnosa_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            diagnosa: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection
