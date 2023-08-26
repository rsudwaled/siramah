@extends('adminlte::page')
@section('title', 'Data Pegawai Mutasi')
@section('content_header')
    <h1>Informasi Pegawai Mutasi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="col-md-12">
                <x-adminlte-card theme="success" icon="fas fa-info-circle" collapsible
                    title="List Data Pegawai">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12">
                                <x-adminlte-small-box
                                    class="float-right"
                                    theme="success" 
                                    text="Tambah Data Baru"
                                    url="{{route('pegawai-mutasi.add')}}"
                                    url-text="Buat Data Baru" />
                            </div>
                        </div>
                    </div>
                    {{-- <form id="formFilter" action="" method="get">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="unit-group">
                                    <x-adminlte-select2 name="id_pegawai" label="Pilih Pegawai">
                                        @foreach ($data as $item)
                                            <option value="{{ $item->id }}">{{$item->nama_lengkap}}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <x-adminlte-button type="submit" id="lihatData" class="withLoad float-right btn btn-sm m-1 mt-4 bg-purple" label="Lihat Data" />
                            </div>
                        </div>
                    </form> --}}
                    @php
                        $heads = ['NIK', ' Nama', 'Tanggal', 'Jenis','Tujuan','Alasan'];
                        $config['order'] = ['0', 'asc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '500px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config"
                        striped bordered hoverable compressed>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{$item->nik}}</td>
                                    <td>{{$item->nama_lengkap}}</td>
                                    <td>{{$item->tgl_mutasi}}</td>
                                    <td>{{$item->jenis_mutasi}}</td>
                                    <td>{{$item->asal_tujuan_mutasi}}</td>
                                    <td>{{$item->alasan_mutasi}}</td>
                                   
                                </tr>
                            @endforeach
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

        function ActiveConfirmation(id) {
        swal.fire({
            icon: 'warning',
            title: "Apakah Anda Yakin?",
            text: "Mengaktifkan Pegawai ini!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "IYA, Aktifkan!",
            cancelButtonText: "Batal!",
            reverseButtons: !0
        }).then(function (e) {

            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: "{{url('data-pegawai/set-pegawai-aktif/')}}/" + id,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            swal.fire("Done!", results.message, "success");
                            setTimeout(function(){
                                $.LoadingOverlay("show");
                                location.reload();
                            },1500);
                            $.LoadingOverlay("hide");
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });

            } else {
                e.dismiss;
            }

        }, function (dismiss) {
            return false;
        })
    }
    </script>
@endsection


