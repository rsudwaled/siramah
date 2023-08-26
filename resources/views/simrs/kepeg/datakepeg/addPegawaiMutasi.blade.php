@extends('adminlte::page')
@section('title', 'Tambah Pegawai Mutasi')
@section('content_header')
    <h1>Tambah Pegawai Mutasi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="col-md-12">
                <x-adminlte-card theme="success" icon="fas fa-info-circle" collapsible
                    title="Tambah Pegawai Mutasi">
                    <form id="formFilter" action="" method="get">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="unit-group" id="pegawai">
                                <x-adminlte-select2 name="pegawai" label="Pegawai">
                                    <option value="" >--Pilih Pegawai--</option>
                                    @foreach ($pegawai as $item)
                                        <option value="{{ $item->id }}">{{$item->nama_lengkap}}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <x-adminlte-button type="submit" id="lihatData" class="withLoad float-right btn btn-sm m-1 mt-4 bg-purple" label="Cari Pegawai" />
                        </div>
                    </div>
                </form>
                    @php
                        $heads = ['NIK', ' Nama', 'Tanggal', 'Jenis','Tujuan','Alasan','Asal Mutasi', 'Action'];
                        $config['order'] = ['0', 'asc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '500px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config"
                        striped bordered hoverable compressed>
                           
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.BsCustomFileInput', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $(document).on('click', '#lihatData', function(e) {
            $.LoadingOverlay("show");
            var data = $('#formFilter').serialize();
            var url = "{{ route('jabatan-kepeg.get') }}?" + data;
            window.location = url;
            $.ajax({
                    data: data,
                    url: url,
                    type: "GET",
                    success: function(data) {
                        setInterval(() => {
                            $.LoadingOverlay("hide");
                        }, 7000);
                    },
                }).then(function() {
                    setInterval(() => {
                        $.LoadingOverlay("hide");
                    }, 2000);
                });
        })
    </script>
@endsection


