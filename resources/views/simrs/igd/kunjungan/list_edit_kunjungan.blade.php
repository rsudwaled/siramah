@extends('adminlte::page')

@section('title', 'List Pasien')
@section('content_header')
    <div class="callout callout-warning">
        <h5>Edit Kunjungan : RM ( {{ $noRM }} ) <x-adminlte-button class="btn-sm btn-flat float-right"
                theme="secondary" label="kembali" onclick="window.location='{{ route('kunjungan-pasien.today') }}'" /></h5>

    </div>
@stop

@section('content')

    <div class="col-lg-12">
        <x-adminlte-card theme="primary" collapsible title="List Kunjungan dari RM: {{ $noRM }}">
            @php
                $heads = ['Counter', 'No RM', 'Unit', 'Tanggal Masuk', 'Tanggal keluar', 'Diagnosa', 'No SEP', 'Dokter', 'penjamin', 'action'];
                $config['order'] = ['0', 'asc'];
                $config['paging'] = false;
                $config['info'] = false;
                $config['scrollY'] = '300px';
                $config['scrollCollapse'] = true;
                $config['scrollX'] = true;
            @endphp
            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config" striped bordered
                hoverable compressed>
                @foreach ($kunjungan as $item)
                    <tr>
                        <td>{{ $item->counter }}</td>
                        <td>{{ $item->no_rm }}</td>
                        <td>{{ $item->kode_unit }} || {{ $item->unit->nama_unit }}</td>
                        <td>{{ $item->tgl_masuk }}</td>
                        <td>{{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}</td>
                        <td>{{ $item->diagx }}</td>
                        <td>{{ $item->no_sep }}</td>
                        <td>{{ $item->dokter->nama_paramedis }}</td>
                        <td>{{ $item->kode_penjamin == null ? '-' : $item->penjamin_simrs->nama_penjamin }}</td>
                        <td>
                            <x-adminlte-button class="btn-xs modalKunjungan" data-counter="{{ $item->counter }}"
                                data-rm="{{ $item->no_rm }}" theme="warning" icon="fas fa-edit"
                                onclick="window.location='#'" data-toggle="modal" data-target="#editByKunjungan" />
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </x-adminlte-card>
    </div>
    <x-adminlte-modal id="editByKunjungan" title="Edit Kunjungan :" size="lg" theme="primary" v-centered
        static-backdrop>
        <form action="#" id="editByKunjungan" method="get">
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header small text-muted border-bottom-0">
                                    Data Pasien :
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="lead"><b id="nama_pasien">Nicole Pearson</b></h2>
                                            <p class="text-muted text-sm"><b id="alamat">About: </b> <br>
                                                <span id="jk" class="small text-muted"></span> <br>
                                                <span id="kontak" class="small text-muted"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <x-adminlte-input name="counter" label="Counter" id="counter"
                                        label-class="text-primary" disabled />
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input name="no_rm" label="no_rm" id="no_rm"
                                        label-class="text-primary" disabled />
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input name="kode_unit" label="kode unit" id="kode_unit"
                                        label-class="text-primary" disabled />
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input name="nama_unit" id="nama_unit" label="nama unit"
                                        label-class="text-primary" disabled />
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-select name="penjamin_id" id="penjamin_id" label-class="text-primary"
                                        label="Pilih Penjamin">
                                        <option value="">--Pilih Penjamin--</option>
                                        @foreach ($penjamin as $item)
                                            <option value="{{ $item->kode_penjamin }}">
                                                {{ $item->nama_penjamin }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-select name="status_kunjungan" id="status_kunjungan"
                                        label-class="text-primary" label="Status Kunjungan">
                                        <option value="13">Batal Periksa</option>
                                        <option value="8">Batal Rawat</option>
                                    </x-adminlte-select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="danger" class="mr-auto" label="batal" data-dismiss="modal" />
                <x-adminlte-button type="submit" form="editByKunjungan" class="btn btn-sm m-1 bg-primary float-right updateKunjungan"
                    label="Update" />
            </x-slot>
        </form>
    </x-adminlte-modal>
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

            // $('.updateKunjungan').click(function(e) {

            // });

            $('.modalKunjungan').click(function(e) {
                var counter = $(this).data('counter');
                var rm = $(this).data('rm');
                var url = "{{ route('kunjungan-terpilih.edit') }}/?counter=" + counter + "&rm=" + rm;
                $.LoadingOverlay("show");
                $.get(url, function(data) {
                    console.log(data);
                    var jk = data.pasien.jenis_kelamin;
                    if (jk == 'L') {
                        var gender = 'Laki - Laki';
                    } else {
                        var gender = 'Perempuan';
                    }
                    $('#nama_pasien').text(data.pasien.nama_px);
                    $('#alamat').text(data.pasien.alamat);
                    $('#kontak').text('kontak : ' + data.pasien.no_tlp);
                    $('#jk').text('Jenis Kelamin : ' + gender);
                    $('#counter').val(data.counter);
                    $('#no_rm').val(data.no_rm);
                    $('#kode_unit').val(data.kode_unit);
                    $('#nama_unit').val(data.unit.nama_unit);
                    $('#penjamin_id').val(data.penjamin_simrs.kode_penjamin).trigger('change');
                    $.LoadingOverlay("hide", true);
                });
            });
        });
    </script>
@endsection
