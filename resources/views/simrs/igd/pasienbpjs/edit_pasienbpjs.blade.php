@extends('adminlte::page')

@section('title', 'Edit Pasien')
@section('content_header')
    <h1>Edit Pasien : {{ $pasien->nama_px }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-success alert-dismissible">
                                    <h5>
                                        <i class="icon fas fa-users"></i>Informasi
                                        Pasien :
                                    </h5>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <input type="hidden" name="rm" id="rm" value="{{ $pasien->no_rm }}">
                                    <x-adminlte-input name="nik_pasien_baru" value="{{ $pasien->nik_bpjs }}" label="NIK"
                                        placeholder="masukan nik" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="no_bpjs" label="BPJS" value="{{ $pasien->no_Bpjs }}"
                                        placeholder="masukan bpjs" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="nama_pasien_baru" label="Nama" value="{{ $pasien->nama_px }}"
                                        placeholder="masukan nama pasien" fgroup-class="col-md-12" disable-feedback />
                                    <x-adminlte-input name="tempat_lahir" label="Tempat lahir" placeholder="masukan tempat"
                                        value="{{ $pasien->tempat_lahir }}" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-select name="jk" label="Jenis Kelamin" fgroup-class="col-md-6">
                                        <option value="L" {{ $pasien->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                            Laki-Laki
                                        </option>
                                        <option value="P" {{ $pasien->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </x-adminlte-select> @php $config = ['format' => 'DD-MM-YYYY']; @endphp
                                    <x-adminlte-input-date name="tgl_lahir" value="{{ $pasien->tgl_lahir }}"
                                        fgroup-class="col-md-6" label="Tanggal Lahir" :config="$config">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-primary">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                    <x-adminlte-select name="agama" label="Agama" fgroup-class="col-md-6">
                                        @foreach ($agama as $item)
                                            <option value="{{ $item->ID }}"
                                                {{ $pasien->agama == $item->ID ? 'selected' : '' }}>
                                                {{ $item->agama }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="pekerjaan" label="Pekerjaan" fgroup-class="col-md-6">
                                        @foreach ($pekerjaan as $item)
                                            <option value="{{ $item->ID }}"
                                                {{ $pasien->pekerjaan == $item->ID ? 'selected' : '' }}>
                                                {{ $item->pekerjaan }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="pendidikan" label="Pendidikan" fgroup-class="col-md-6">
                                        @foreach ($pendidikan as $item)
                                            <option value="{{ $item->ID }}"
                                                {{ $pasien->pendidikan == $item->ID ? 'selected' : '' }}>
                                                {{ $item->pendidikan }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <x-adminlte-input name="no_telp" label="No Telpon" value="{{ $pasien->no_tlp }}"
                                        placeholder="masukan no tlp" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="no_hp" label="No Hp" placeholder="masukan hp"
                                        value="{{ $pasien->no_hp }}" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-select name="provinsi_pasien" label="Provinsi" id="provinsi_pasien"
                                        fgroup-class="col-md-6">
                                        @foreach ($provinsi as $item)
                                            <option value="{{ $item->kode_provinsi }}"
                                                {{ $pasien->kode_propinsi == $item->kode_provinsi ? 'selected' : '' }}>
                                                {{ $item->nama_provinsi }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="kabupaten_pasien" label="Kabupaten" id="kab_pasien"
                                        fgroup-class="col-md-6">
                                        <option id="kab_pasien_first">{{ $pasien->kabupaten==null?'data belum diisi':$pasien->kabupatens->nama_kabupaten_kota }}
                                        </option>
                                    </x-adminlte-select>
                                    <x-adminlte-select name="kecamatan_pasien" label="Kecamatan" id="kec_pasien"
                                        fgroup-class="col-md-6">
                                        <option id="kec_pasien_first">{{ $pasien->kecamatan==null?'data belum diisi':$pasien->kecamatans->nama_kecamatan }}</option>
                                    </x-adminlte-select>
                                    <x-adminlte-select name="desa_pasien" label="Desa" id="desa_pasien"
                                        fgroup-class="col-md-6">
                                        <option id="desa_pasien_first">{{ $pasien->desa==null?'data belum diisi':$pasien->desas->nama_desa_kelurahan }}</option>
                                    </x-adminlte-select>
                                    <x-adminlte-select2 name="negara" label="Negara" id="negara_pasien"
                                        fgroup-class="col-md-6">
                                        @foreach ($negara as $item)
                                            <option value="{{ $item->id }}"
                                                {{ ucfirst(strtolower($pasien->negara)) == $item->nama_negara ? 'selected' : '' }}>
                                                {{ $item->nama_negara }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    <x-adminlte-select name="kewarganegaraan" id="kewarganegaraan_pasien"
                                        label="Kewarganegaraan" fgroup-class="col-md-6">
                                        <option value="1" {{ $pasien->kewarganegaraan == '1' ? 'selected' : '' }}>WNI
                                        </option>
                                        <option value="0" {{ $pasien->kewarganegaraan == '0' ? 'selected' : '' }}>WNA
                                        </option>
                                    </x-adminlte-select>
                                    <x-adminlte-textarea name="alamat_lengkap_pasien" label="Alamat Lengkap (RT/RW)"
                                        fgroup-class="col-md-12">{{ $pasien->alamat }}</x-adminlte-textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-warning alert-dismissible">
                            <h5>
                                <i class="icon fas fa-users"></i>Info Keluarga
                                Pasien :
                            </h5>
                        </div>
                        <div class="row">
                            <x-adminlte-input name="nama_keluarga" id="nama_keluarga" value="{{ $klp == null ? '' : $klp->nama_keluarga }}"
                                label="Nama Keluarga" placeholder="masukan nama keluarga" fgroup-class="col-md-12"
                                disable-feedback />
                            <x-adminlte-input name="tlp_keluarga" id="tlp_keluarga" label="Kontak" placeholder="no tlp"
                                value="{{ $klp == null ? '' : $klp->tlp_keluarga }}" fgroup-class="col-md-6" disable-feedback />
                            <x-adminlte-select name="hub_keluarga" id="hub_keluarga" label="Hubungan Dengan Pasien"
                                fgroup-class="col-md-6">
                                @foreach ($hb_keluarga as $item)
                                    <option value="{{ $item->kode }}"
                                        {{ ($klp == null ? '' : $klp->hubungan_keluarga == $item->kode) ? 'selected' : '' }}>
                                        {{ $item->nama_hubungan }}</option>
                                @endforeach
                            </x-adminlte-select>

                            <x-adminlte-textarea name="alamat_lengkap_sodara" id="alamat_lengkap_sodara" label="Alamat Lengkap (RT/RW)"
                                placeholder="Alamat Lengkap (RT/RW)"
                                fgroup-class="col-md-12">{{ $klp == null ? '' : $klp->alamat_keluarga }}</x-adminlte-textarea>
                        </div>
                    </div>
                </div>
                <x-adminlte-button id="updatePasien" class="float-right btn-sm btn-flat" theme="success" label="update data" />
                <a href="{{ route('pendaftaran-pasien-igdbpjs') }}" class="btn btn-secondary btn-sm btn-flat float-right">kembali</a>
                <x-adminlte-button label="Refresh" class="btn btn-flat" theme="danger" icon="fas fa-retweet"
                    onClick="window.location.reload();" />
            </form>
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
        // alamat pasien
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
                                $('#kab_pasien_first').empty();
                                $('#kec_pasien_first').empty();
                                $('#desa_pasien_first').empty();
                                $('#kab_pasien').empty();
                                $('#kec_pasien').empty();
                                $("#desa_pasien").empty();
                                $("#kab_pasien").append(
                                    ' < option > --Pilih Kabupaten-- < /option>');
                                $.each(kabupatenpasien, function(key, value) {
                                    $('#kab_pasien').append('<option value="' + value
                                        .kode_kabupaten_kota + '">' + value
                                        .nama_kabupaten_kota + '</option>');
                                });
                            } else {
                                $('#kab_pasien').empty();
                                $('#kec_pasien').empty();
                                $("#desa_pasien").empty();

                            }
                        }
                    });
                } else {
                    $("#kab_pasien").empty();
                    $('#kec_pasien').empty();
                    $("#desa_pasien").empty();

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
                                $("#desa_pasien").empty();
                                $("#kec_pasien").append(
                                    ' < option > --Pilih Kecamatan-- < /option>');
                                $.each(kecamatanpasien, function(key, value) {
                                    $('#kec_pasien').append('<option value="' + value
                                        .kode_kecamatan + '">' + value
                                        .nama_kecamatan + '</option>');
                                });
                            } else {
                                $('#kec_pasien').empty();
                                $("#desa_pasien").empty();
                            }
                        }
                    });
                } else {
                    $("#kec_pasien").empty();
                    $("#desa_pasien").empty();
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
        $('#updatePasien').on('click', function() {
            swal.fire({
                icon: 'question',
                title: 'ANDA YAKIN UPDATE DATA INI ?',
                showDenyButton: true,
                confirmButtonText: 'Update',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    var urlUpdate = "{{ route('update-pasien.update') }}?rm=" + $('#rm').val();
                    $.ajax({
                        type: 'PUT',
                        url: urlUpdate,
                        data: {
                            _token: "{{ csrf_token() }}",
                            rm: $('#rm').val(),
                            nik: $('#nik_pasien_baru').val(),
                            no_bpjs: $('#no_bpjs').val(),
                            nama_pasien_baru: $('#nama_pasien_baru').val(),
                            jk: $('#jk').val(),
                            tempat_lahir: $('#tempat_lahir').val(),
                            tgl_lahir: $('#tgl_lahir').val(),
                            agama: $('#agama').val(),
                            pekerjaan: $('#pekerjaan').val(),
                            pendidikan: $('#pendidikan').val(),
                            no_tlp: $('#no_tlp').val(),
                            no_hp: $('#no_hp').val(),
                            provinsi_pasien: $('#provinsi_pasien').val(),
                            kabupaten_pasien: $('#kab_pasien').val(),
                            kecamatan_pasien: $('#kec_pasien').val(),
                            desa_pasien: $('#desa_pasien').val(),
                            negara: $('#negara_pasien').val(),
                            kewarganegaraan: $('#kewarganegaraan_pasien').val(),
                            alamat_lengkap_pasien: $('#alamat_lengkap_pasien').val(),

                            nama_keluarga: $('#nama_keluarga').val(),
                            tlp_keluarga: $('#tlp_keluarga').val(),
                            hub_keluarga: $('#hub_keluarga').val(),
                            alamat_lengkap_sodara: $('#alamat_lengkap_sodara').val(),
                        },
                        success: function(res) {
                            if (res.status == 200) {
                                Swal.fire('data pasien berhasil diupdate', '', 'success');
                                window.location.href =
                                    "{{ route('pendaftaran-pasien-igdbpjs') }}"
                            }else{
                                Swal.fire('data keluarga harus dilengkapi', '', 'error');
                            }
                        }
                    });

                }
            })

        });
    </script>
@endsection
