@extends('adminlte::page')
@section('title', 'Tambah pasien')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Tambah Pasien Baru</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><b>PASIEN</b></li>
                    <li class="breadcrumb-item"><b>BARU</b></li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <x-adminlte-card theme="purple" collapsible>
            <div class="col-lg-12">
                <div class="row">
                    @if ($errors->any())
                        <div class="col-lg-12">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <form action="{{ route('pasien-baru.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert bg-purple alert-dismissible">
                                        <h5>
                                            <i class="icon fas fa-users"></i>Informasi
                                            Pasien :
                                        </h5>
                                        <p>
                                            <small>* inputan wajib diisi</small> <br>
                                            <small>** inputan boleh diisi dan juga boleh dikosongkan</small><br>
                                            <small>*** inputan boleh diisi salah satu saja</small>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputRounded0">NIK <code>*<i>( maksimal 16 angka
                                                        )</i></code></label>
                                            <input class="form-control rounded-0" name="nik_pasien_baru"
                                                value="{{ old('nik_pasien_baru') }}" type="number"
                                                placeholder="masukan nik">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputRounded0">BPJS <code>*<i>( maksimal 16 angka
                                                        )</i></code></label>
                                            <input class="form-control rounded-0" name="no_bpjs" type="number"
                                                value="{{ old('no_bpjs') }}" placeholder="masukan bpjs">
                                        </div>
                                        <x-adminlte-input name="nama_pasien_baru" label="Nama *"
                                            value="{{ old('nama_pasien_baru') }}" placeholder="masukan nama pasien"
                                            fgroup-class="col-md-12" disable-feedback />
                                        <x-adminlte-input name="tempat_lahir" label="Tempat lahir *"
                                            value="{{ old('tempat_lahir') }}" placeholder="masukan tempat"
                                            fgroup-class="col-md-6" disable-feedback />
                                        <x-adminlte-select name="jk" label="Jenis Kelamin *" fgroup-class="col-md-6">
                                            <option value="L">Laki-Laki
                                            </option>
                                            <option value="P">Perempuan
                                            </option>
                                        </x-adminlte-select>
                                        <div class="col-lg-6">
                                            <label for="">Tanggal Lahir (bulan/tanggal/tahun)</label>
                                            <input type="date" class="form-control" name="tgl_lahir">
                                        </div>
                                        <x-adminlte-select name="agama" label="Agama *" fgroup-class="col-md-6">
                                            @foreach ($agama as $item)
                                                <option value="{{ $item->ID }}">
                                                    {{ $item->agama }}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="pekerjaan" label="Pekerjaan *" fgroup-class="col-md-6">
                                            @foreach ($pekerjaan as $item)
                                                <option value="{{ $item->ID }}">
                                                    {{ $item->pekerjaan }}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="pendidikan" label="Pendidikan *" fgroup-class="col-md-6">
                                            @foreach ($pendidikan as $item)
                                                <option value="{{ $item->ID }}">
                                                    {{ $item->pendidikan }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputRounded0">No Telpon <code>*<i>( maksimal 16 angka
                                                        )</i></code></label>
                                            <input class="form-control rounded-0" name="no_telp" type="number"
                                                value="{{ old('no_telp') }}" placeholder="masukan no tlp">
                                        </div>
                                        <x-adminlte-select name="provinsi_pasien" label="Provinsi *" id="provinsi_pasien"
                                            fgroup-class="col-md-6">
                                            @foreach ($provinsi as $item)
                                                <option value="{{ $item->kode_provinsi }}"
                                                    {{ $item->kode_provinsi == 32 ? 'selected' : '' }}>
                                                    {{ $item->nama_provinsi }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="kabupaten_pasien" label="Kabupaten *" id="kab_pasien"
                                            fgroup-class="col-md-6">
                                            @foreach ($kabupaten as $item)
                                                <option value="{{ $item->kode_kabupaten_kota }}"
                                                    {{ $item->kode_kabupaten_kota == 3209 ? 'selected' : '' }}>
                                                    {{ $item->nama_kabupaten_kota }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="kecamatan_pasien" label="Kecamatan *" id="kec_pasien"
                                            fgroup-class="col-md-6">
                                            @foreach ($kecamatan as $item)
                                                <option value="{{ $item->kode_kecamatan }}"
                                                    {{ $item->kode_kecamatan == 3209020 ? 'selected' : '' }}>
                                                    {{ $item->nama_kecamatan }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="desa_pasien" label="Desa *" id="desa_pasien"
                                            fgroup-class="col-md-6">
                                        </x-adminlte-select>
                                        <x-adminlte-textarea name="alamat_lengkap_pasien" label="Alamat Lengkap (RT/RW) *"
                                            placeholder="Alamat Lengkap (RT/RW)" fgroup-class="col-md-6" />
                                        <div class="form-group col-md-12">
                                            <div class="col-md-12 row">
                                                <div class="col-md-6">
                                                    <x-adminlte-select name="kewarganegaraan" id="kewarganegaraan_pasien"
                                                        label="Kewarganegaraan *">
                                                        <option value="1">WNI</option>
                                                        <option value="0">WNA</option>
                                                    </x-adminlte-select>
                                                </div>
                                                <div class="col-md-6" style="display: none;" id="pilih_negara">
                                                    <label for="" class="col-md-12">Pilih Negara</label>
                                                    <select id="negara_pasien" name="negara"
                                                        class="form-control select2 ">
                                                        @foreach ($negara as $item)
                                                            <option value="{{ $item->nama_negara }}">
                                                                {{ $item->nama_negara }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="alert alert-success alert-dismissible">
                                <h5>
                                    <i class="icon fas fa-users"></i>Info Keluarga
                                    Pasien :
                                </h5>
                                <h6>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="default_alamat_checkbox" value="1" id="default_alamat">
                                        <label class="form-check-label" for="default_alamat">CEKLIS UNTUK MENYAMAKAN
                                            ALAMAT</label>
                                    </div>
                                </h6>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="exampleInputBorderWidth2">Nama Keluarga</label>
                                    <input type="text" name="nama_keluarga" class="form-control"
                                        id="nama_keluarga">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="exampleInputBorderWidth2">Hubungan Dengan Pasien</label>
                                    <select name="hub_keluarga" id="hub_keluarga" class="form-control">
                                        @foreach ($hb_keluarga as $item)
                                            <option value="{{ $item->kode }}">
                                                {{ $item->nama_hubungan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-6" id="div_kontak">
                                    <label for="exampleInputBorderWidth2">Kontak</label>
                                    <input type="text" name="kontak" id="kontak" class="form-control">
                                </div>
                                <div class="form-group col-lg-6" id="div_alamat_keluarga">
                                    <label for="exampleInputBorderWidth2">Alamat Keluarga</label>
                                    <textarea name="alamat_lengkap_sodara" class="form-control" id="alamat_lengkap_sodara" cols="30" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <a href="{{ route('daftar-igd.v1') }}" class="btn btn-sm btn-secondary">Kembali</a>
                            <button type="submit" class="btn bg-purple btn-sm">Simpan Pasien</button>
                        </div>
                    </div>
                </form>
            </div>
        </x-adminlte-card>
    </div>
@endsection
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $(document).ready(function() {
            $('#provinsi_pasien').change(function() {
                var prov_pasien = $(this).val();
                if (prov_pasien) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('kab-pasien.get') }}?kab_prov_id=" + prov_pasien,
                        dataType: 'JSON',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(kabupatenpasien) {
                            if (kabupatenpasien) {
                                $('#kab_pasien').empty();
                                $("#kab_pasien").append(
                                    ' < option > --Pilih Kabupaten-- < /option>');
                                $.each(kabupatenpasien, function(key, value) {
                                    $('#kab_pasien').append('<option value="' + value
                                        .kode_kabupaten_kota + '">' + value
                                        .nama_kabupaten_kota + '</option>');
                                });
                            } else {
                                $('#kab_pasien').empty();
                            }
                        }
                    });
                } else {
                    $("#kab_pasien").empty();
                }
            });
            $('#kab_pasien').change(function() {
                var kec_kab_id = $("#kab_pasien").val();
                if (kec_kab_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('kec-pasien.get') }}?kec_kab_id=" + kec_kab_id,
                        dataType: 'JSON',
                        success: function(kecamatanpasien) {
                            console.log(kecamatanpasien);
                            if (kecamatanpasien) {
                                $('#kec_pasien').empty();
                                $("#kec_pasien").append(
                                    ' < option > --Pilih Kecamatan-- < /option>');
                                $.each(kecamatanpasien, function(key, value) {
                                    $('#kec_pasien').append('<option value="' + value
                                        .kode_kecamatan + '">' + value
                                        .nama_kecamatan + '</option>');
                                });
                            } else {
                                $('#kec_pasien').empty();
                            }
                        }
                    });
                } else {
                    $("#kec_pasien").empty();
                }
            });
            $('#kec_pasien').change(function() {
                var desa_kec_id = $("#kec_pasien").val();
                if (desa_kec_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('desa-pasien.get') }}?desa_kec_id=" + desa_kec_id,
                        dataType: 'JSON',
                        success: function(desapasien) {
                            console.log(desapasien);
                            if (desapasien) {
                                $('#desa_pasien').empty();
                                $("#desa_pasien").append(
                                    ' < option > --Pilih Desa-- < /option>');
                                $.each(desapasien, function(key, value) {
                                    $('#desa_pasien').append('<option value="' + value
                                        .kode_desa_kelurahan + '">' + value
                                        .nama_desa_kelurahan + '</option>');
                                });
                            } else {
                                $('#desa_pasien').empty();
                            }
                        }
                    });
                } else {
                    $("#desa_pasien").empty();
                }
            });
        });
        $(document).ready(function() {
            const defaultCheckbox = document.getElementById('default_alamat');

            $(defaultCheckbox).on('change', function() {
                if (this.checked) {
                    var kontak = $('#no_telp').val();
                    var alamat = $('#alamat_lengkap_pasien').val();

                    $('#alamat_lengkap_sodara').val(alamat); // Mengisi alamat sodara dengan alamat pasien
                    $('#kontak').val(kontak); // Mengisi nomor telepon dengan nomor telepon pasien

                    $('#div_alamat_keluarga').hide();
                    $('#div_kontak').hide(); // Menampilkan nomor telepon

                } else {
                    $('#alamat_lengkap_sodara').val(''); 
                    $('#kontak').val(''); 

                    $('#div_alamat_keluarga').show();
                    $('#div_kontak').show(); // Menyembunyikan nomor telepon
                }
            });
        });
    </script>
    <script>
        const kewarganegaraanSelect = document.getElementById('kewarganegaraan_pasien');
        const negaraSelect = document.getElementById('pilih_negara');

        // Function to show or hide the negara select based on the selected value of kewarganegaraan
        function toggleNegaraSelect() {
            const selectedValue = kewarganegaraanSelect.value;
            negaraSelect.style.display = selectedValue === '0' ? 'block' : 'none';
        }

        // Add event listener to the kewarganegaraan select
        kewarganegaraanSelect.addEventListener('change', toggleNegaraSelect);

        // Call the function initially to set the initial state of the negara select
        toggleNegaraSelect();
    </script>
@endsection
