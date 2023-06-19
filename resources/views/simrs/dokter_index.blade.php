@extends('adminlte::page')

@section('title', 'Data Dokter')

@section('content_header')
    <h1>Data Dokter</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Data Dokter" theme="info" icon="fas fa-info-circle" collapsible maximizable>
                @php
                    $heads = ['Kode BPJS', 'Kode SIMRS', 'Nama Dokter', 'SIP', 'Status', 'Action'];
                    $config['paging'] = false;
                    $config['info'] = false;
                    $config['scrollY'] = '500px';
                    $config['scrollCollapse'] = true;
                @endphp
                <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($dokter as $item)
                        <tr>
                            <td>{{ $item->kodedokter }}</td>
                            <td>{{ $item->paramedis ? $item->paramedis->kode_paramedis : '-' }}</td>
                            <td>{{ $item->namadokter }}</td>
                            <td>{{ $item->paramedis ? $item->paramedis->sip_dr : '-' }}</td>
                            <td>
                                @if ($item->paramedis)
                                    <a href="#" class="btn btn-xs btn-secondary">Sudah
                                        Ada</a>
                                @else
                                    <a href="#" class="btn btn-xs btn-danger">Belum
                                        Ada</a>
                                @endif
                            </td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" label="Edit" theme="warning" icon="fas fa-edit"
                                    data-toggle="tooltip" title="Edit Dokter {{ $item->nama_paramedis }}"
                                    data-id="{{ $item->kodedokter }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalEdit" title="Edit Dokter" theme="warning" icon="fas fa-user-plus">
        <form name="formInput" id="formInput" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" id="id" value="">
            <x-adminlte-input name="kodedokter" placeholder="Kode BPJS" label="Kode BPJS" readonly />
            <x-adminlte-input name="kode_paramedis" placeholder="Kode Dokter" label="Kode Dokter" readonly />
            <x-adminlte-input name="namadokter" placeholder="Nama Dokter" label="Nama Dokter" />
            <x-adminlte-input name="sip_dr" placeholder="SIP" label="SIP" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" form="formInput" label="Update" theme="success" icon="fas fa-save" />
                <x-adminlte-button theme="danger " label="Tutup" icon="fas fa-times" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)

@section('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btnEdit').click(function() {
                var id = $(this).data('id');
                $.LoadingOverlay("show");
                var url = "{{ route('dokter.index') }}/" + id;
                $.get(url, function(data) {
                    var urlAction = "{{ route('dokter.index') }}/" + id ;
                    $('#formInput').attr('action', urlAction);
                    $('#kodedokter').val(data.kodedokter);
                    $('#namadokter').val(data.namadokter);
                    $('#kode_paramedis').val(data.paramedis.kode_paramedis);
                    $('#sip_dr').val(data.paramedis.sip_dr);
                    $('#modalEdit').modal('show');
                })
                $.LoadingOverlay("hide", true);
            });
        });
    </script>
@endsection
