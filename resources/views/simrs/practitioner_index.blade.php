@extends('adminlte::page')

@section('title', 'Practitioner')

@section('content_header')
    <h1>Practitioner</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Data Dokter" theme="info" icon="fas fa-info-circle" collapsible maximizable>
                @php
                    $heads = ['Kode BPJS', 'Kode SIMRS', 'ID SatuSehat', 'NIK', 'Nama Dokter', 'SIP', 'Status', 'Action'];
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
                            <td>{{ $item->id_satusehat }}</td>
                            <td>{{ $item->paramedis ? $item->paramedis->nik : '-' }}

                                @if ($item->paramedis)
                                    @if ($item->paramedis->nik)
                                        <a href="{{ route('practitioner_sync') }}?kode_paramedis={{ $item->paramedis ? $item->paramedis->kode_paramedis : '' }}"
                                            class="btn btn-xs btn-warning"><i class="fas fa-sync"></i> </a>
                                    @endif
                                @endif
                            </td>
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
                                <x-adminlte-button class="btn-xs" onclick="editDokter(this)" theme="warning"
                                    icon="fas fa-edit" title="Edit Dokter {{ $item->nama_paramedis }}"
                                    data-kodeparamedis="{{ $item->paramedis ? $item->paramedis->kode_paramedis : '' }}"
                                    data-id="{{ $item->kodedokter }}" data-kodejkn="{{ $item->kodedokter }}"
                                    data-idsatusehat="{{ $item->id_satusehat }}"
                                    data-nik="{{ $item->paramedis ? $item->paramedis->nik : '' }}"
                                    data-namadokter="{{ $item->namadokter }}"
                                    data-sip="{{ $item->paramedis ? $item->paramedis->sip_dr : '' }}" />
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
            @method('PUT')
            <input type="hidden" name="id" id="id" value="">
            <x-adminlte-input name="kodedokter" placeholder="Kode BPJS" label="Kode BPJS" readonly />
            <x-adminlte-input name="kode_paramedis" placeholder="Kode SIMRS" label="Kode Dokter" readonly />
            <x-adminlte-input name="id_satusehat" placeholder="ID SatuSehat" label="ID SatuSehat" readonly />
            <x-adminlte-input name="nik" placeholder="NIK Dokter" label="NIK Dokter" />
            <x-adminlte-input name="namadokter" placeholder="Nama Dokter" label="Nama Dokter" />
            <x-adminlte-input name="sip_dr" placeholder="SIP" label="SIP" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" form="formInput" label="Update" theme="success"
                    icon="fas fa-save" />
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
        });

        function editDokter(params) {
            $.LoadingOverlay("show");
            var id = $(params).data("id");
            var urlAction = "{{ route('dokter.index') }}/" + id;
            $('#formInput').attr('action', urlAction);
            $('#id').val($(params).data("id"));
            $('#kodedokter').val($(params).data("kodejkn"));
            $('#kode_paramedis').val($(params).data("kodeparamedis"));
            $('#id_satusehat').val($(params).data("idsatusehat"));
            $('#nik').val($(params).data("nik"));
            $('#namadokter').val($(params).data("namadokter"));
            $('#sip_dr').val($(params).data("sip"));
            $('#modalEdit').modal('show');
            $.LoadingOverlay("hide", true);
        }
    </script>
@endsection
