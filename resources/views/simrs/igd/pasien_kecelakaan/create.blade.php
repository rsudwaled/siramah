@extends('adminlte::page')

@section('title', 'PASIEN KECELAKAAN')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>FORM DAFTAR PASIEN KECELAKAAN</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><b>DAFTARKAN</b></li>
                    <li class="breadcrumb-item"><b>PASIEN KECELAKAAN</b></li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-12">
                    <x-adminlte-card theme="success" size="sm" id="div_rajal" icon="fas fa-info-circle" collapsible
                        title="Daftarkan Pasien Kecelakaan : {{ $pasien->jenis_kelamin == 'L' ? 'Sdr. ' : 'Ny. ' }} {{ $pasien->nama_px }}">

                        <form action="{{ route('pasien-kecelakaan.store') }}" id="formPendaftaranIGD" method="post">
                            @csrf
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <x-adminlte-input name="rm" value="{{ $pasien->no_rm }}" label="Nama Pasien"
                                            enable-old-support>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-olive">{{ $pasien->nama_px }}</div>
                                            </x-slot>
                                        </x-adminlte-input>

                                        @php
                                            $config = ['format' => 'YYYY-MM-DD'];
                                        @endphp
                                        <x-adminlte-input-date name="tanggal_daftar"
                                            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" label="Tanggal Daftar"
                                            :config="$config" />

                                        <x-adminlte-select name="isBpjs" id="isBpjs" label="Jenis Pasien">
                                            <option value="0">--Pasien UMUM--</option>
                                            <option value="1">--Pasien BPJS--</option>
                                        </x-adminlte-select>

                                        <x-adminlte-select name="alasan_masuk_id" label="Alasan Masuk">
                                            <option value="">--Pilih Alasan--</option>
                                            @foreach ($alasanmasuk as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->alasan_masuk }}</option>
                                            @endforeach
                                        </x-adminlte-select>

                                        <x-adminlte-select name="lakaLantas" id="status_kecelakaan"
                                            label="Status Kecelakaan">
                                            <option value="1">KLL & BUKAN KECELAKAAN KERJA (BKK)</option>
                                            <option value="2">KLL & KK</option>
                                            <option value="3">KECELAKAAN KERJA</option>
                                        </x-adminlte-select>
                                        <x-adminlte-select2 name="provinsi" id="provinsi" label="Provinsi">
                                            <option selected disabled>Cari Provinsi</option>
                                        </x-adminlte-select2>
                                        <x-adminlte-select2 name="kabupaten" label="Kota / Kabupaten">
                                            <option selected disabled>Cari Kota / Kabupaten
                                            </option>
                                        </x-adminlte-select2>
                                        <x-adminlte-select2 name="kecamatan" label="Kecamatan">
                                            <option selected disabled>Cari Kecamatan
                                            </option>
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputBorderWidth2">Perujuk
                                                <code>(jika pasien memiliki referensi instansi yang merujuk)</code></label>
                                            <select name="isPerujuk" id="isPerujuk" class="form-control">
                                                <option value="0">Tanpa Perujuk</option>
                                                <option value="1">Tambah Perujuk</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perujuk">
                                            <label for="exampleInputBorderWidth2">Nama Perujuk</label>
                                            <input type="text" name="nama_perujuk" class="form-control"
                                                id="nama_perujuk">
                                        </div>
                                        <x-adminlte-select2 name="dokter_id" label="Pilih Dokter">
                                            <option value="">--Pilih Dokter--</option>
                                            @foreach ($paramedis as $item)
                                                <option value="{{ $item->kode_paramedis }}">
                                                    {{ $item->nama_paramedis }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                        <x-adminlte-select2 name="penjamin_id" label="Pilih Penjamin">
                                            <option value="">--Pilih Penjamin--</option>
                                            @foreach ($penjamin as $item)
                                                <option value="{{ $item->kode_penjamin }}">
                                                    {{ $item->nama_penjamin }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                        <x-adminlte-input name="noTelp" type="number" label="No Telpon"
                                            value="{{ $pasien->no_tlp == null ? $pasien->no_hp : $pasien->no_tlp }}" />
                                        <x-adminlte-input name="noLP" label="NO Laporan Polisi"
                                            placeholder="no laporan polisi" id="noLP" disable-feedback />
                                        <x-adminlte-input name="keterangan" id="keterangan" label="Keterangan"
                                            placeholder="keterangan kecelakaan" disable-feedback />
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD'];
                                        @endphp
                                        <x-adminlte-input-date name="tglKejadian" id="tglKejadian"
                                            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" label="Tanggal Kejadian"
                                            :config="$config" />
                                    </div>
                                    
                                </div>
                                <x-adminlte-button type="submit"
                                    class="withLoad btn btn-sm m-1 bg-green float-right btn-flat " id="submitPasien"
                                    label="Simpan Data" />
                                <a href="{{ route('list.antrian') }}"
                                    class="btn btn-sm btn-flat m-1 bg-secondary float-right">kembali</a>
                            </div>
                        </form>
                    </x-adminlte-card>
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
        const perujuk = document.getElementById('isPerujuk');
        const pilihUnit = document.getElementById('div_stts_kecelakaan');
        const nolaporan = document.getElementById('noLP');
        const keterangan = document.getElementById('keterangan');
        const tanggalkejadian = document.getElementById('tglKejadian');
        const provinsi = document.getElementById('provinsi');
        $('#perujuk').hide();
        $(perujuk).on('change', function() {
            if (perujuk.value > 0 || perujuk.value == null) {
                $('#perujuk').show();
            } else {
                $('#perujuk').hide();
            }
        });
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#diagAwal").select2({
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
        });
    </script>
@endsection
