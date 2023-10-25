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
                            <x-adminlte-input-date name="tgl_lahir_bayi" fgroup-class="col-md-6" label="Tanggal Lahir"
                                :config="$config">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                            <x-adminlte-select name="jk" label="Jenis Kelamin" fgroup-class="col-md-6">
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </x-adminlte-select>
                            <x-adminlte-textarea name="alamat_lengkap_sodara" id="alamat_lengkap_sodara"
                                label="Alamat Lengkap (RT/RW)" placeholder="Alamat Lengkap (RT/RW)"
                                fgroup-class="col-md-12" />

                            <x-adminlte-input name="nik_orangtua" id="nik_orangtua" label="NIK ORANTUA"
                                placeholder="masukan nik orangtua bayi" fgroup-class="col-md-12" disable-feedback />
                            <button type="button"
                                class="btn btn-flat btn-block bg-gradient-primary btn-sm mr-2 mb-2 cari_orangtua"
                                data-toggle="modal" data-target="#modalCariOrangTua">Cari Orang Tua Bayi</button>
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
                                    <x-adminlte-input name="nik_pasien_baru" label="NIK" placeholder="masukan nik"
                                        fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="no_bpjs" label="BPJS" placeholder="masukan bpjs"
                                        fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="nama_pasien_baru" label="Nama"
                                        placeholder="masukan nama pasien" fgroup-class="col-md-12" disable-feedback />
                                    <x-adminlte-input name="tempat_lahir" label="Tempat lahir" placeholder="masukan tempat"
                                        fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-select name="jk" label="Jenis Kelamin" fgroup-class="col-md-6">
                                        <option value="L">
                                            Laki-Laki
                                        </option>
                                        <option value="P">
                                            Perempuan
                                        </option>
                                    </x-adminlte-select> @php $config = ['format' => 'DD-MM-YYYY']; @endphp
                                    <x-adminlte-input-date name="tgl_lahir" fgroup-class="col-md-6" label="Tanggal Lahir"
                                        :config="$config">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-primary">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                    <x-adminlte-select name="agama" label="Agama" fgroup-class="col-md-6">
                                        @foreach ($agama as $item)
                                            <option value="{{ $item->ID }}">
                                                {{ $item->agama }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="pekerjaan" label="Pekerjaan" fgroup-class="col-md-6">
                                        @foreach ($pekerjaan as $item)
                                            <option value="{{ $item->ID }}">
                                                {{ $item->pekerjaan }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="pendidikan" label="Pendidikan" fgroup-class="col-md-6">
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
                                    <x-adminlte-input name="no_telp" label="No Telpon" placeholder="masukan no tlp"
                                        fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="no_hp" label="No Hp" placeholder="masukan hp"
                                        fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-select name="provinsi_pasien" label="Provinsi" id="provinsi_pasien"
                                        fgroup-class="col-md-6">
                                        @foreach ($provinsi as $item)
                                            <option value="{{ $item->kode_provinsi }}">
                                                {{ $item->nama_provinsi }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="kabupaten_pasien" label="Kabupaten" id="kab_pasien"
                                        fgroup-class="col-md-6">
                                        <option id="kab_pasien_first"></option>
                                    </x-adminlte-select>
                                    <x-adminlte-select name="kecamatan_pasien" label="Kecamatan" id="kec_pasien"
                                        fgroup-class="col-md-6">
                                        <option id="kec_pasien_first"></option>
                                    </x-adminlte-select>
                                    <x-adminlte-select name="desa_pasien" label="Desa" id="desa_pasien"
                                        fgroup-class="col-md-6">
                                        <option id="desa_pasien_first"></option>
                                    </x-adminlte-select>
                                    <x-adminlte-select2 name="negara" label="Negara" id="negara_pasien"
                                        fgroup-class="col-md-6">
                                        @foreach ($negara as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_negara }}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    <x-adminlte-select name="kewarganegaraan" id="kewarganegaraan_pasien"
                                        label="Kewarganegaraan" fgroup-class="col-md-6">
                                        <option value="1">WNI</option>
                                        <option value="0">WNA</option>
                                    </x-adminlte-select>
                                    <x-adminlte-textarea name="alamat_lengkap_pasien" label="Alamat Lengkap (RT/RW)"
                                        fgroup-class="col-md-12"></x-adminlte-textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <x-adminlte-button id="updatePasien" class="float-right btn-sm btn-flat" theme="success"
                    label="SIMPAN DATA" />
                <a href="{{ route('pendaftaran-pasien-igdbpjs') }}"
                    class="btn btn-secondary btn-sm btn-flat float-right">kembali</a>
                <x-adminlte-button label="Refresh" class="btn btn-flat" theme="danger" icon="fas fa-retweet"
                    onClick="window.location.reload();" />
            </form>
        </div>
    </div>
    <x-adminlte-modal id="modalCariOrangTua" title="Cari Orangtua Bayi" size="lg" theme="primary" v-centered
        static-backdrop scrollable>
        <div class="row" id="daftarOrantua">
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="batal pilih" onclick="batalPilih()" data-dismiss="modal" />
        </x-slot>
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

            $('.cari_orangtua').click(function(e) {
                var nikOrangtua = $('#nik_orangtua').val();
                $('#cariNikORTU').text('NIK ' + nikOrangtua);
                if (nikOrangtua) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('cari-ortu.bayi') }}?nik_ortu=" + nikOrangtua,
                        dataType: 'JSON',
                        success: function(res) {
                            if (res) {
                                $.each(res.data, function(key, value) {
                                    $("#daftarOrantua").append(`<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">``<div class="card bg-light d-flex flex-fill">``<div class="card-body pt-0"><div class="row">`
                                                    `<div class="col-7"><h2 class="lead"><b>`+value.nama_px+`</b></h2><p class="text-muted text-sm"><b>Tempat Lahir: </b> `+value.tempat_lahir+`/ `+value.tgl_lahir+` / Coffee Lover</p>`
                                                            `<ul class="ml-4 mb-0 fa-ul text-muted"><li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>`
                                                                   `Alamat: `+value.desas.nama_desa_kelurahan+ `,` +value.kecamatans.nama_kecamatan+ `- `+value.kabupatens.nama_kabupaten_kota+` </li>`
                                                                    `<li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Telpon`
                                                                        `#:`+value.no_tlp+`</li></ul></div></div></div></div></div>`);
                                });
                            } else {
                                $("#daftarOrantua").empty();
                            }
                        }
                    });
                }
            });
        });

        function chooseORTU(nik, nama, no_rm) {
            swal.fire({
                icon: 'question',
                title: 'ANDA YAKIN PILIH RUANGAN ' + nama + ' No ' + no_rm + ' ?',
                showDenyButton: true,
                confirmButtonText: 'Pilih',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    //
                    $("#ruanganSend").val(nik);
                    $('#pilihRuangan').modal('toggle');
                    $("#showRuangan").text('RUANGAN : ' + nama);
                    $("#showBed").text('NO : ' + no_rm);
                    $("#showRuangan").css("display", "block");
                    $("#showBed").css("display", "block");
                    $(".ortuCheck").remove();
                }
            })
        }

        function batalPilih() {
            $(".ortuCheck").remove();
        }
    </script>
@endsection
