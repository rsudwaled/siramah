@extends('adminlte::page')

@section('title', 'Scan E-File Rekam Medis')

@section('content_header')
    <h1>Scan E-File Rekam Medis</h1>
@stop

@section('content')
    <div class="row">
        <x-adminlte-card title="Data E-File Rekam Medis" theme="warning" collapsible>
            <div class="row">
                <div class="col-md-8">
                    <a class="btn btn-success mb-1" href="{{ route('efilerm.create') }}">Scan E-File RM</a>
                </div>
                <div class="col-md-4">
                    <form action="" id="cari" name="cari" method="GET">
                        <x-adminlte-input name="search" placeholder="Pencarian Berdasarkan No RM" igroup-size="sm"
                            value="{{ $request->search }}">
                            <x-slot name="appendSlot">
                                <x-adminlte-button type="submit" form="cari" theme="primary" label="Cari!" />
                            </x-slot>
                            <x-slot name="prependSlot">
                                <div class="input-group-text text-primary">
                                    <i class="fas fa-search"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </form>
                </div>
                <div class="col-md-12">
                    @php
                        $heads = ['Tgl Scan', 'No.', 'No RM', ' Nama', 'Tgl Lahir', 'Nama Berkas', 'Jenis', 'Action'];
                        $config['paging'] = false;
                        $config['lengthMenu'] = false;
                        $config['searching'] = false;
                        $config['info'] = false;
                        $config['order'] = ['0', 'desc'];
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" striped bordered
                        hoverable compressed>
                        @foreach ($filerm as $item)
                            <tr>
                                <td>{{ $item->tanggalscan }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggallahir)->format('Y-m-d') }}</td>
                                <td>{{ $item->namafile }}</td>
                                <td>
                                    @if ($item->jenisberkas == 1)
                                        Rawat Inap
                                    @endif
                                    @if ($item->jenisberkas == 2)
                                        Rawat Jalan
                                    @endif
                                    @if ($item->jenisberkas == 3)
                                        Penunjang
                                    @endif
                                    @if ($item->jenisberkas == 4)
                                        Berkas Pasien
                                    @endif
                                    @if ($item->jenisberkas == 5)
                                        IGD
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ $item->fileurl }}" target="_blank" class="btn btn-primary btn-xs"><i
                                            class=" fas fa-download"></i></a>
                                    <x-adminlte-button icon="fas fa-eye" theme="warning" class="btn-xs btnLihat"
                                        label="Lihat" data-id="{{ $item->id }}" />
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
                <div class="col-md-5">
                    <div class="dataTables_info">
                        Tampil {{ $filerm->firstItem() }} s/d {{ $filerm->lastItem() }} dari total
                        {{ $filerm->total() }}
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="dataTables_paginate pagination-sm float-right">
                        {{ $filerm->appends(['search' => $request->search])->links() }}
                    </div>
                </div>
            </div>
        </x-adminlte-card>
    </div>
    <x-adminlte-modal id="modalFile" size="lg" theme="warning" title="E-File Rekam Medis">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <dt class="col-sm-4">Pasien</dt>
                    <dd class="col-sm-8">: <span id="nama"></span> / <span id="norm"></span></dd>
                    <dt class="col-sm-4">BPJS / NIK</dt>
                    <dd class="col-sm-8">: <span id="nomorkartu"></span> / <span id="nik"></span></dd>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <dt class="col-sm-4">Nama Berkas</dt>
                    <dd class="col-sm-8">:
                        <span id="namafile"></span> /
                        <span id="jenisberkas"></span>
                    </dd>
                    <dt class="col-sm-4">Tanggal Scan</dt>
                    <dd class="col-sm-8">: <span id="tanggalscan"></span></dd>
                </div>
            </div>
        </div>
        <iframe id="fileurl" src="" width="100%" height="600px">
        </iframe>

        <form name="formDeleteJadwal" id="formDeleteJadwal" method="POST">
            @csrf
            @method('DELETE')
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button label="Hapus" form="formDeleteJadwal" class="withLoad" type="submit" theme="danger"
                icon="fas fa-trash-alt" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Close" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)

@section('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btnLihat').click(function() {
                var id = $(this).data('id');
                $.LoadingOverlay("show");
                var url = "{{ route('efilerm.index') }}" + '/' + id;
                $.get(url, function(data) {
                    // delete form
                    var urlDelete = "{{ route('efilerm.index') }}/" + id;
                    $('#formDeleteJadwal').attr('action', urlDelete);

                    $('#norm').html(data.norm);
                    $('#nama').html(data.nama);
                    $('#nik').html(data.nik);
                    $('#nomorkartu').html(data.nomorkartu);
                    $('#nomorantrean').html(data.nomorantrean);
                    $('#namafile').html(data.namafile);
                    $('#jenisberkas').html(data.jenisberkas);
                    $('#jenisberkas').html(data.jenisberkas);
                    $('#tanggalscan').html(data.tanggalscan);
                    $("#fileurl").attr("src", data.fileurl);
                    $('#modalFile').modal('show');
                    $.LoadingOverlay("hide", true);
                })
            });
        });
    </script>
@endsection
