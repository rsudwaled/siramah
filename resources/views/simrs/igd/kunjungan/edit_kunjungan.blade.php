@extends('adminlte::page')

@section('title', 'Edit Kunjungan')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>FORM EDIT KUNJUNGAN: </h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><b>Kunjungan</b></li>
                    <li class="breadcrumb-item"><b>{{ $kunjungan->kode_kunjungan }}</b></li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <form action="{{ route('update.kunjungan', ['kunjungan' => $kunjungan->kode_kunjungan]) }}"
                                id="formPendaftaranIGD" method="post">
                                @csrf
                                @method('PUT')
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Tanggal Masuk</label>
                                                <input type="text" class="form-control"
                                                    value="{{ Carbon\Carbon::parse($kunjungan->tgl_masuk)->format('Y-m-d') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputBorderWidth2">Perujuk
                                                    <code>(jika pasien memiliki referensi instansi yang
                                                        merujuk)</code></label>
                                                <input type="text" name="nama_perujuk" value="{{ $kunjungan->perujuk }}"
                                                    class="form-control" id="nama_perujuk">
                                            </div>
                                            <x-adminlte-select name="alasan_masuk_id" label="Alasan Masuk">
                                                <option value="">--Pilih Alasan--</option>
                                                @foreach ($alasanmasuk as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $kunjungan->id_alasan_masuk ? 'selected' : '' }}>
                                                        {{ $item->alasan_masuk }}</option>
                                                @endforeach
                                            </x-adminlte-select>
                                        </div>
                                        <div class="col-lg-6">
                                            <x-adminlte-select name="isBpjs" label="Jenis Pasien">
                                                <option value="0" {{ $kunjungan->jp_daftar == 0 ? 'selected' : '' }}>
                                                    --Pasien UMUM--</option>
                                                <option value="1" {{ $kunjungan->jp_daftar == 1 ? 'selected' : '' }}>
                                                    --Pasien BPJS--</option>
                                                <option value="2" {{ $kunjungan->jp_daftar == 2 ? 'selected' : '' }}>
                                                    --BPJS PROSES--</option>
                                            </x-adminlte-select>
                                            <div class="form-group" id="show_penjamin_umum">
                                                <x-adminlte-select2 name="penjamin_id_umum" label="Pilih Penjamin">
                                                    <option value="" selected>Penjamin UMUM</option>
                                                    @foreach ($penjamin as $penjaminumum)
                                                    <option value="{{ $penjaminumum->kode_penjamin }}"
                                                        {{ $penjaminumum->kode_penjamin == $kunjungan->kode_penjamin ? 'selected' : '' }}>
                                                        {{ $penjaminumum->nama_penjamin }}</option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                            </div>
                                            <div class="form-group" id="show_penjamin_bpjs">
                                                <x-adminlte-select2 name="penjamin_id_bpjs" label="Pilih Penjamin BPJS">
                                                    <option value="" selected>Penjamin BPJS</option>
                                                    @foreach ($penjaminbpjs as $penjaminbpjs)
                                                    <option value="{{ $penjaminbpjs->kode_penjamin_simrs }}"
                                                        {{ $penjaminbpjs->kode_penjamin_simrs == $kunjungan->kode_penjamin ? 'selected' : '' }}>
                                                        {{ $penjaminbpjs->nama_penjamin_bpjs }}</option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                            </div>
                                            <div class="form-group">
                                                <x-adminlte-select2 name="status_kunjungan" label="Status Kunjungan">
                                                    @foreach ($statusKunjungan as $status)
                                                        <option value="{{ $status->ID }}"
                                                            {{ $status->ID == $kunjungan->status_kunjungan ? 'selected' : '' }}>
                                                            {{ $status->status_kunjungan }}</option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                            </div>
                                            <x-adminlte-select name="alasan_edit" label="Alasan Edit Data">
                                                <option value="">--Alasan Edit--</option>
                                                @foreach ($alasanedit as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $kunjungan->id_alasan_edit ? 'selected' : '' }}>
                                                        {{ $item->nama_alasan }}</option>
                                                @endforeach
                                            </x-adminlte-select>
                                        </div>
                                    </div>
                                    <x-adminlte-button type="submit"
                                        class="withLoad  btn btn-sm m-1 bg-primary float-right" id="submitPasien"
                                        label="Simpan Data" />
                                    <a href="{{ route('daftar.kunjungan') }}"
                                        class="btn btn-sm  btn-secondary float-right m-1 withLoad">Kembali</a>
                                </div>
                            </form>
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
    <script>
        const isbpjs = document.getElementById('isBpjs');
        $("#provinsi").select2({
            theme: "bootstrap4",
            ajax: {
                url: "{{ route('ref_provinsi_api') }}",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        nama: params.term // search term
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
        if (isbpjs.value == 1) {
            $('#show_penjamin_umum').hide();
            $('#show_penjamin_bpjs').show();
        } else {
            $('#show_penjamin_bpjs').hide();
            $('#show_penjamin_umum').show();
        }
        if (isbpjs.value == 2) {
            $('#show_penjamin_umum').show();
            $('#show_penjamin_bpjs').show();
        }
        $(isbpjs).on('change', function() {
            if (isbpjs.value == 0 || isbpjs.value == null) {
                $('#show_penjamin_umum').show();
                $('#show_penjamin_bpjs').hide();
            } else if (isbpjs.value == 1) {
                $('#show_penjamin_umum').hide();
                $('#show_penjamin_bpjs').show();
            } else if(isbpjs.value == 2){
                $('#show_penjamin_umum').show();
                $('#show_penjamin_bpjs').show();
            }else{
                $('#show_penjamin_umum').hide();
                $('#show_penjamin_bpjs').hide();
            }
        });
        $("#kabupaten").select2({
            theme: "bootstrap4",
            ajax: {
                url: "{{ route('ref_kabupaten_api') }}",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        kodeprovinsi: $("#provinsi option:selected").val(),
                        nama: params.term // search term
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
        $("#kecamatan").select2({
            theme: "bootstrap4",
            ajax: {
                url: "{{ route('ref_kecamatan_api') }}",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        kodekabupaten: $("#kabupaten option:selected").val(),
                        nama: params.term // search term
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
    </script>
@endsection
