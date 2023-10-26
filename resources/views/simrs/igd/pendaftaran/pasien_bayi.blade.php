@extends('adminlte::page')

@section('title', 'Pendaftaran Pasien Bayi')
@section('content_header')
    <h1>Pendaftaran Pasien Bayi </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="alert alert-warning alert-dismissible">
                            <h5>
                                <i class="icon fas fa-users"></i>Informasi Bayi :
                            </h5>
                        </div>
                        <div class="row">
                            <x-adminlte-input name="nama_bayi" id="nama_bayi" label="Nama Bayi" placeholder="masukan nama bayi"
                                fgroup-class="col-md-12" disable-feedback />
                            @php $config = ['format' => 'DD-MM-YYYY']; @endphp
                            <x-adminlte-input-date name="tgl_lahir_bayi" id="tgl_lahir_bayi" fgroup-class="col-md-6"
                                label="Tanggal Lahir" :config="$config">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                            <x-adminlte-select name="jk_bayi" label="Jenis Kelamin" id="jk_bayi" fgroup-class="col-md-6">
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </x-adminlte-select>
                            <x-adminlte-textarea name="alamat_bayi" id="alamat_bayi" label="Alamat Lengkap (RT/RW)"
                                placeholder="Alamat Lengkap (RT/RW)" fgroup-class="col-md-12" />

                            <x-adminlte-input name="nik_orangtua" id="nik_orangtua" label="NIK ORANTUA"
                                placeholder="masukan nik orangtua bayi" fgroup-class="col-md-12" disable-feedback />
                            <button type="button"
                                class="btn btn-flat btn-block bg-gradient-primary btn-sm mr-2 mb-2 cari_orangtua">Cari Orang
                                Tua Bayi</button>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-success alert-dismissible">
                                    <h5>
                                        <i class="icon fas fa-users"></i>Informasi Orangtua Bayi :
                                    </h5>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <x-adminlte-input name="nik_ortu" id="nik_ortu" label="NIK"
                                        placeholder="masukan nik" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="no_bpjs_ortu" id="no_bpjs_ortu" label="BPJS"
                                        placeholder="masukan bpjs" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="nama_ortu" id="nama_ortu" label="Nama"
                                        placeholder="masukan nama orangtua" fgroup-class="col-md-12" disable-feedback />
                                    <x-adminlte-input name="tempat_lahir" id="tempat_lahir_ortu" label="Tempat lahir"
                                        placeholder="masukan tempat" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-select name="jk" id="jk_ortu" label="Jenis Kelamin"
                                        fgroup-class="col-md-6">
                                        <option value="L">
                                            Laki-Laki
                                        </option>
                                        <option value="P">
                                            Perempuan
                                        </option>
                                    </x-adminlte-select> @php $config = ['format' => 'DD-MM-YYYY']; @endphp
                                    <x-adminlte-input-date name="tgl_lahir" id="tgl_lahir_ortu" fgroup-class="col-md-6"
                                        label="Tanggal Lahir" :config="$config">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-primary">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                    <x-adminlte-select name="agama" id="agama_ortu" label="Agama"
                                        fgroup-class="col-md-6">
                                        @foreach ($agama as $item)
                                            <option value="{{ $item->ID }}">
                                                {{ $item->agama }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="pekerjaan" id="pekerjaan_ortu" label="Pekerjaan"
                                        fgroup-class="col-md-6">
                                        @foreach ($pekerjaan as $item)
                                            <option value="{{ $item->ID }}">
                                                {{ $item->pekerjaan }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="pendidikan" id="pendidikan_ortu" label="Pendidikan"
                                        fgroup-class="col-md-6">
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
                                    <x-adminlte-input name="no_telp" id="no_telp_ortu" label="No Telpon"
                                        placeholder="masukan no tlp" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="no_hp" id="no_hp_ortu" label="No Hp"
                                        placeholder="masukan hp" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-select name="provinsi_pasien" label="Provinsi" id="provinsi_ortu"
                                        fgroup-class="col-md-6">
                                        @foreach ($provinsi as $item)
                                            <option value="{{ $item->kode_provinsi }}">
                                                {{ $item->nama_provinsi }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="kabupaten_pasien" label="Kabupaten" id="kab_ortu"
                                        fgroup-class="col-md-6">
                                        @foreach ($kab as $item)
                                            <option value="{{ $item->kode_kabupaten_kota }}">
                                                {{ $item->nama_kabupaten_kota }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="kecamatan_pasien" label="Kecamatan" id="kec_ortu"
                                        fgroup-class="col-md-6">
                                        @foreach ($kec as $item)
                                            <option value="{{ $item->kode_kecamatan }}">
                                                {{ $item->nama_kecamatan }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="desa_pasien" label="Desa" id="desa_ortu"
                                        fgroup-class="col-md-6">
                                        @foreach ($desa as $item)
                                            <option value="{{ $item->kode_desa_kelurahan }}">
                                                {{ $item->nama_desa_kelurahan }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select2 name="negara" label="Negara" id="negara_ortu"
                                        fgroup-class="col-md-6">
                                        @foreach ($negara as $item)
                                            <option value="{{ strtoupper($item->nama_negara) }}">
                                                {{ strtoupper($item->nama_negara) }}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    <x-adminlte-select name="kewarganegaraan" id="kewarganegaraan_ortu"
                                        label="Kewarganegaraan" fgroup-class="col-md-6">
                                        <option value="0">WNA</option>
                                        <option value="1">WNI</option>
                                    </x-adminlte-select>
                                    <x-adminlte-textarea name="alamat_lengkap_ortu" label="Alamat Lengkap (RT/RW)"
                                        fgroup-class="col-md-12"></x-adminlte-textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <x-adminlte-button class="float-right btn-sm btn-flat simpan-data" theme="success" label="SIMPAN DATA" />
                <a href="{{ route('pendaftaran-pasien-igdbpjs') }}"
                    class="btn btn-secondary btn-sm btn-flat float-right">kembali</a>
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
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.cari_orangtua').click(function(e) {
                var nikOrangtua = $('#nik_orangtua').val();
                $.LoadingOverlay("show");
                if (nikOrangtua) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('cari-ortu.bayi') }}?nik_ortu=" + nikOrangtua,
                        dataType: 'JSON',
                        success: function(res) {
                            console.log(res);
                            if (res.data != null) {
                                $('#nik_ortu').val(res.data.nik_bpjs);
                                $('#no_bpjs_ortu').val(res.data.no_Bpjs);
                                $('#nama_ortu').val(res.data.nama_px);
                                $('#tempat_lahir_ortu').val(res.data.tempat_lahir);
                                $('#alamat_lengkap_ortu').val(res.data.alamat);
                                $('#no_hp_ortu').val(res.data.no_hp);
                                $('#no_telp_ortu').val(res.data.no_telp);
                                $('#tgl_lahir_ortu').val(res.data.tgl_lahir);
                                $('#jk_ortu').val(res.data.jenis_kelamin).trigger('change');
                                $('#agama_ortu').val(res.data.agama).trigger('change');
                                $('#pendidikan_ortu').val(res.data.pendidikan).trigger(
                                    'change');
                                $('#pekerjaan_ortu').val(res.data.pekerjaan).trigger('change');
                                $('#kewarganegaraan_ortu').val(res.data.kewarganegaraan)
                                    .trigger('change');
                                $('#provinsi_ortu').val(res.data.kode_propinsi).trigger(
                                    'change');
                                $('#kab_ortu').val(res.data.kode_kabupaten).trigger('change');
                                $('#kec_ortu').val(res.data.kode_kecamatan).trigger('change');
                                $('#desa_ortu').val(res.data.kode_desa).trigger('change');
                                $('#negara_ortu').val(res.data.negara).trigger('change');
                                $.LoadingOverlay("hide", true);

                            } else {
                                Swal.fire('NIK Orangtua tidak ditemukan!',
                                    ' silahkan masukan data orangtua baru / periksa kembali nik yang dimasukan',
                                    'error');
                                $.LoadingOverlay("hide", true);
                            }
                        }
                    });
                }
            });

            $('.simpan-data').click(function(e) {
                swal.fire({
                    icon: 'question',
                    title: 'ANDA YAKIN SIMPAN DATA INI ?',
                    showDenyButton: true,
                    confirmButtonText: 'Pilih',
                    denyButtonText: `Batal`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data: {
                                nik_ortu : $('#nik_ortu').val(),
                                no_bpjs_ortu : $('#no_bpjs_ortu').val(),
                                nama_ortu : $('#nama_ortu').val(),
                                tempat_lahir_ortu : $('#tempat_lahir_ortu').val(),
                                alamat_lengkap_ortu : $('#alamat_lengkap_ortu').val(),
                                no_hp_ortu : $('#no_hp_ortu').val(),
                                no_telp_ortu : $('#no_telp_ortu').val(),
                                tgl_lahir_ortu : $('#tgl_lahir_ortu').val(),
                                jk_ortu : $('#jk_ortu').val(),
                                agama_ortu : $('#agama_ortu').val(),
                                pendidikan_ortu : $('#pendidikan_ortu').val(),
                                pekerjaan_ortu : $('#pekerjaan_ortu').val(),
                                kewarganegaraan_ortu : $('#kewarganegaraan_ortu').val(),
                                provinsi_ortu : $('#provinsi_ortu').val(),
                                kab_ortu : $('#kab_ortu').val(),
                                kec_ortu : $('#kec_ortu').val(),
                                desa_ortu : $('#desa_ortu').val(),
                                negara_ortu : $('#negara_ortu').val(),

                                nama_bayi : $('#nama_bayi').val(),
                                jk_bayi : $('#jk_bayi').val(),
                                tgl_lahir_bayi : $('#tgl_lahir_bayi').val(),
                                alamat_bayi : $('#alamat_bayi').val(),
                            },
                            url: "{{route('pasien_bayi.create')}}",
                            type: "POST",
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                            },
                            
                        });
                    }
                })

            });
        });
    </script>
@endsection