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
                    <form action="{{route('pegawai-mutasi.store')}}" id="mutasi" method="post">
                        @csrf
                    <div class="row">
                        <div class="col-lg-12">
                           <div class="row">
                                <div class="col-lg-12">
                                    <x-adminlte-select2 name="pegawai" label="Pegawai">
                                        <option value="" >--Pilih Pegawai--</option>
                                        @foreach ($pegawai as $item)
                                            <option value="{{ $item->id }}">{{$item->nama_lengkap}}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                                <div class="col-lg-6">
                                    @php
                                    $config = ['format' => 'YYYY-MM-DD'];
                                    @endphp
                                    <x-adminlte-input-date name="tgl_mutasi" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                        label="Tanggal Mutasi" :config="$config" />
                                </div>
                                <div class="col-lg-6">
                                    <x-adminlte-select2 name="jenis_mutasi" label="Jenis Mutasi">
                                        <option value="masuk" >Mutasi Masuk</option>
                                        <option value="keluar" >Mutasi Keluar</option>
                                    </x-adminlte-select2>
                                </div>
                                <div class="col-lg-6">
                                    <x-adminlte-input name="asal_tujuan_mutasi" label="Tujuan Mutasi"
                                        enable-old-support required />
                                </div>
                                <div class="col-lg-6">
                                    <x-adminlte-input name="alasan_mutasi" label="Alasan Mutasi"
                                        enable-old-support required />
                                </div>
                                
                            </div> 
                        </div>
                    </div>
                </form>
                </x-adminlte-card>
                <x-adminlte-button form="mutasi" type="submit" class="float-right" theme="success" label="Simpan" />
                <a href="{{ route('pegawai-mutasi.get') }}" class="btn btn-danger mr-1 float-right">Kembali</a>
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


