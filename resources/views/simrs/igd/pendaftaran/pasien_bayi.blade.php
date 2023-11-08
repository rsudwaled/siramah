@extends('adminlte::page')

@section('title', 'Pendaftaran Pasien Bayi')
@section('content_header')
    <h1>Pendaftaran Pasien Bayi </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card theme="primary" size="sm" collapsible title="Riwayat Kunjungan UGK :">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            @php
                                $heads = ['Pasien', 'Alamat', 'Kunjungan', 'Kode Kunjungan', 'Unit', 'Tanggal Masuk', 'Tanggal keluar', 'Penjamin', 'Status'];
                                $config['order'] = ['0', 'asc'];
                                $config['paging'] = false;
                                $config['info'] = false;
                                $config['scrollY'] = '300px';
                                $config['scrollCollapse'] = true;
                                $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config" striped
                                bordered hoverable compressed>
                                @foreach ($kunjungan_igd as $item)
                                    <tr>
                                        <td><b>Nama: {{ $item->pasien->nama_px }}</b><br>RM : {{ $item->pasien->no_rm }}
                                            <br> NIK : {{ $item->pasien->nik_bpjs }} <br>BPJS :
                                            {{ $item->pasien->no_Bpjs == null ? '-' : $item->pasien->no_Bpjs }}
                                        </td>
                                        <td>alamat : {{ $item->pasien->alamat }} / <br>
                                            {{ $item->pasien->kode_desa < 1101010001 ? 'ALAMAT LENGKAP BELUM DI ISI!' : $item->pasien->desas->nama_desa_kelurahan . ' , Kec. ' . $item->pasien->kecamatans->nama_kecamatan . ' - Kab. ' . $item->pasien->kabupatens->nama_kabupaten_kota }}
                                        </td>
                                        <td>{{ $item->counter }}</td>
                                        <td>{{ $item->kode_kunjungan }}</td>
                                        <td>{{ $item->unit->nama_unit }}</td>
                                        <td>{{ $item->tgl_masuk }}</td>
                                        <td>{{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}
                                        </td>
                                        <td>{{ $item->kode_penjamin }}</td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-block bg-gradient-success btn-block btn-flat btn-xs show-formbayi"
                                                data-kunjungan="{{ $item->kode_kunjungan }}"
                                                data-rmibu="{{ $item->no_rm }}">daftarkan bayi</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                        <div class="col-lg-12">
                            <a href="{{ route('pendaftaran.pasien') }}"
                                class="btn btn-secondary btn-sm btn-flat float-right">kembali ke pendaftaran</a>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
            <x-adminlte-modal id="formBayi" title="Data Bayi" theme="success" size='lg' disable-animations>
                <div class="col-lg-12">
                    <div class="alert alert-warning alert-dismissible">
                        <h5>
                            <i class="icon fas fa-users"></i>Informasi Bayi :
                        </h5>
                    </div>
                    <form id="form_pasien_bayi" method="post" action="{{ route('pasien_bayi.create') }}">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="isbpjs" id="isbpjs">
                            <input type="hidden" name="isbpjs_keterangan" id="isbpjs_keterangan">
                            <x-adminlte-input name="nama_bayi" id="nama_bayi" label="Nama Bayi *" required
                                placeholder="masukan nama bayi" fgroup-class="col-md-12" disable-feedback />

                            <x-adminlte-input name="tempat_lahir_bayi" id="tempat_lahir_bayi" label="Kota Lahir *" required
                                placeholder="masukan kota ketika bayi lahir" fgroup-class="col-md-12" disable-feedback />

                            @php $config = ['format' => 'DD-MM-YYYY']; @endphp
                            <x-adminlte-input-date name="tgl_lahir_bayi" id="tgl_lahir_bayi" fgroup-class="col-md-6" required
                                label="Tanggal Lahir *" :config="$config"
                                value="{{ \Carbon\Carbon::parse()->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                            <x-adminlte-select name="jk_bayi" label="Jenis Kelamin *" id="jk_bayi" required
                                fgroup-class="col-md-6">
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </x-adminlte-select>

                            <x-adminlte-input name="rm_ibu" id="rm_ibu" label="NIK ORANTUA **" type="text" disabled
                                fgroup-class="col-md-6" disable-feedback />
                            <x-adminlte-input name="kunjungan" id="kunjungan" label="Kunjungan **" type="text" disabled
                                fgroup-class="col-md-6" disable-feedback />
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="danger" label="Batal" data-dismiss="modal" />
                                <x-adminlte-button class="float-right save-bayi" type="submit" theme="success" label="Simpan Data" />
                            </x-slot>
                        </div>
                    </form>
                </div>
            </x-adminlte-modal>
        </div>
        {{-- <div class="col-lg-12">
            @if ($errors->any())
                <div class="alert alert-danger alert-error" id="validation-errors">
                    <ul>
                        <li>
                            <h5>DATA YANG WAJIB DIISI:</h5>
                        </li>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="form_pasien_bayi" method="post" action="{{ route('pasien_bayi.create') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="alert alert-warning alert-dismissible">
                            <h5>
                                <i class="icon fas fa-users"></i>Informasi Bayi :
                            </h5>
                        </div>
                        <div class="row">
                            <input type="hidden" name="isbpjs" id="isbpjs">
                            <input type="hidden" name="rm_ibu" id="rm_ibu">
                            <input type="hidden" name="isbpjs_keterangan" id="isbpjs_keterangan">
                            <x-adminlte-input name="nama_bayi" id="nama_bayi" label="Nama Bayi *"
                                placeholder="masukan nama bayi" fgroup-class="col-md-12" disable-feedback />

                            <x-adminlte-input name="tempat_lahir_bayi" id="tempat_lahir_bayi" label="Kota Lahir *"
                                placeholder="masukan nik orangtua bayi" fgroup-class="col-md-12" disable-feedback />

                            @php $config = ['format' => 'DD-MM-YYYY']; @endphp
                            <x-adminlte-input-date name="tgl_lahir_bayi" id="tgl_lahir_bayi" fgroup-class="col-md-6"
                                label="Tanggal Lahir *" :config="$config"
                                value="{{ \Carbon\Carbon::parse()->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                            <x-adminlte-select name="jk_bayi" label="Jenis Kelamin *" id="jk_bayi"
                                fgroup-class="col-md-6">
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </x-adminlte-select>

                            <x-adminlte-input name="nik_orangtua" id="nik_orangtua" label="NIK ORANTUA **" type="number"
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
                            <div class="col-lg-12">
                                <div class="callout callout-success" id="card_desc_bpjs" style="display: none;">
                                    <h5 id="cek_bpjs">I am a success callout!</h5>
                                    <p id="cek_keterangan_bpjs">This is a green callout.</p>
                                    <p id="cek_jenis_peserta">This is a green callout.</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <x-adminlte-input name="nik_ortu" id="nik_ortu" label="NIK *"
                                        placeholder="masukan nik" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="no_bpjs_ortu" id="no_bpjs_ortu" label="BPJS **"
                                        placeholder="masukan bpjs" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="nama_ortu" id="nama_ortu" label="Nama *"
                                        placeholder="masukan nama orangtua" fgroup-class="col-md-12" disable-feedback />
                                    <x-adminlte-input name="tempat_lahir_ortu" id="tempat_lahir_ortu"
                                        label="Tempat lahir *" placeholder="masukan tempat" fgroup-class="col-md-6"
                                        disable-feedback />
                                    <x-adminlte-select name="jk_ortu" id="jk_ortu" label="Jenis Kelamin *"
                                        fgroup-class="col-md-6">
                                        <option value="P">
                                            Perempuan
                                        </option>
                                        <option value="L">
                                            Laki-Laki
                                        </option>
                                    </x-adminlte-select>
                                    @php $config = ['format' => 'DD-MM-YYYY']; @endphp
                                    <x-adminlte-input-date name="tgl_lahir_ortu" id="tgl_lahir_ortu"
                                        fgroup-class="col-md-6" label="Tanggal Lahir *" :config="$config"
                                        value="{{ \Carbon\Carbon::parse()->format('Y-m-d') }}">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-primary">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                    <x-adminlte-select name="agama_ortu" id="agama_ortu" label="Agama *"
                                        fgroup-class="col-md-6">
                                        @foreach ($agama as $item)
                                            <option value="{{ $item->ID }}">
                                                {{ $item->agama }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="pekerjaan_ortu" id="pekerjaan_ortu" label="Pekerjaan *"
                                        fgroup-class="col-md-6">
                                        @foreach ($pekerjaan as $item)
                                            <option value="{{ $item->ID }}">
                                                {{ $item->pekerjaan }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="pendidikan_ortu" id="pendidikan_ortu" label="Pendidikan *"
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
                                    <x-adminlte-input name="no_telp_ortu" id="no_telp_ortu" label="No Telpon **"
                                        placeholder="masukan no tlp" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="no_hp_ortu" id="no_hp_ortu" label="No Hp *"
                                        placeholder="masukan hp" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-select2 name="provinsi_ortu" label="Provinsi *" id="provinsi_ortu"
                                        fgroup-class="col-md-6">
                                        @foreach ($provinsi as $item)
                                            <option value="{{ $item->kode_provinsi }}">
                                                {{ $item->nama_provinsi }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    <x-adminlte-select2 name="kab_ortu" label="Kabupaten *" id="kab_ortu"
                                        fgroup-class="col-md-6">
                                        @foreach ($kab as $item)
                                            <option value="{{ $item->kode_kabupaten_kota }}">
                                                {{ $item->nama_kabupaten_kota }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    <x-adminlte-select2 name="kec_ortu" label="Kecamatan *" id="kec_ortu"
                                        fgroup-class="col-md-6">
                                        @foreach ($kec as $item)
                                            <option value="{{ $item->kode_kecamatan }}">
                                                {{ $item->nama_kecamatan }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    <x-adminlte-select2 name="desa_ortu" label="Desa *" id="desa_ortu"
                                        fgroup-class="col-md-6">
                                    </x-adminlte-select2>
                                    <x-adminlte-select2 name="negara_ortu" label="Negara *" id="negara_ortu"
                                        fgroup-class="col-md-6">
                                        @foreach ($negara as $item)
                                            <option value="{{ strtoupper($item->nama_negara) }}">
                                                {{ strtoupper($item->nama_negara) }}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    <x-adminlte-select name="kewarganegaraan_ortu" id="kewarganegaraan_ortu"
                                        label="Kewarganegaraan *" fgroup-class="col-md-6">
                                        <option value="1">WNI</option>
                                        <option value="0">WNA</option>
                                    </x-adminlte-select>
                                    <x-adminlte-textarea name="alamat_lengkap_ortu" label="Alamat Lengkap (RT/RW) *"
                                        fgroup-class="col-md-12"></x-adminlte-textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <x-adminlte-button class="float-right btn-sm btn-flat withLoad" type="submit" theme="success"
                    label="SIMPAN DATA" />
                <a href="{{ route('pendaftaran-pasien-igdbpjs') }}"
                    class="btn btn-secondary btn-sm btn-flat float-right">kembali</a>
                <x-adminlte-button label="Refresh" class="btn btn-flat" theme="danger" icon="fas fa-retweet"
                    onClick="window.location.reload();" />
                <x-adminlte-button label="Reset Form" class="btn btn-flat reset_form" theme="warning"
                    icon="fas fa-retweet" />
            </form>
        </div> --}}
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


            $('#kec_ortu').change(function() {
                var desa_kec_id = $("#kec_ortu").val();
                if (desa_kec_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('desa-pasien.get') }}?desa_kec_id=" + desa_kec_id,
                        dataType: 'JSON',
                        success: function(desapasien) {
                            console.log(desapasien);
                            if (desapasien) {
                                $('#desa_ortu').empty();
                                $.each(desapasien, function(key, value) {
                                    $('#desa_ortu').append('<option value="' + value
                                        .kode_desa_kelurahan + '">' + value
                                        .nama_desa_kelurahan + '</option>');
                                });
                            } else {
                                $("#desa_ortu").append(' < option > --Pilih Desa-- < /option>');
                            }
                        }
                    });
                } else {
                    $("#desa_ortu").append(' < option > --Pilih Desa-- < /option>');
                }
            });


            
            $('.reset_form').click(function(e) {
                $.LoadingOverlay("show");
                $("#form_pasien_bayi")[0].reset();
                document.getElementById('card_desc_bpjs').style.display = "none";
                $.LoadingOverlay("hide");
            });


            $('.show-formbayi').click(function(e) {
                $("#rm_ibu").val($(this).data('rmibu'));
                $("#kunjungan").val($(this).data('kunjungan'));
                $('#formBayi').modal('show');
            });
            
            $('.save-bayi').click(function(e) {
               
                $.ajax({
                        type: "post",
                        url: "{{ route('pasien_bayi.create') }}",
                        data:{
                            rm:$("#rm_ibu").val(),
                            kunjungan:$("#kunjungan").val(),
                            nama_bayi:$("#nama_bayi").val(),
                            jk_bayi:$("#jk_bayi").val(),
                            tgl_lahir_bayi:$("#tgl_lahir_bayi").val(),
                            tempat_lahir_bayi:$("#tempat_lahir_bayi").val(),
                        },
                        dataType: 'JSON',
                        success: function(res) {
                           
                        }
                    });
                $('#formBayi').modal('hide');
            });
        });
    </script>
@endsection
