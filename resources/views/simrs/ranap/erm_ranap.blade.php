@extends('adminlte::page')
@section('title', 'ERM Rawat Inap')
@section('content_header')
    <h1>ERM Rawat Inap</h1>
@stop
@section('content')
    @php
        $total = 0;
    @endphp
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <a href="{{ route('kunjunganranap') }}?tanggal={{ \Carbon\Carbon::parse($kunjungan->tgl_masuk)->format('Y-m-d') }}&kodeunit={{ $kunjungan->kode_unit }}"
                class="btn btn-xs mb-2 btn-danger withLoad"><i class="fas fa-arrow-left"></i> Kembali</a>
            <x-adminlte-card theme="primary" theme-mode="outline">
                @include('simrs.ranap.erm_ranap_profil')
            </x-adminlte-card>
        </div>
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        {{-- riwayat --}}
                        @include('simrs.ranap.erm_ranap_riwayat')
                        {{-- rincian --}}
                        @include('simrs.ranap.erm_ranap_biaya')
                        {{-- administrasi --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cAdministrasi">
                                <h3 class="card-title">
                                    Administrasi Kunjungan
                                </h3>
                            </a>
                            <div id="cAdministrasi" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    <form action="" name="formAdm" id="formAdm" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                                        @endphp
                                        <x-adminlte-input-date name="tgl_masuk" class="tgl_masuk-id" label="Tgl Masuk"
                                            value="{{ $kunjungan->tgl_masuk }}" igroup-size="sm" :config="$config"
                                            readonly />
                                        <x-adminlte-input-date name="tgl_keluar" class="tgl_keluar-id" label="Tgl Keluar"
                                            value="{{ $kunjungan->tgl_keluar }}" igroup-size="sm" :config="$config"
                                            readonly />
                                        <input type="hidden" name="kodekunjungan" value="{{ $kunjungan->kode_kunjungan }}">


                                        <x-adminlte-input name="no_sep" placeholder="No SEP" igroup-size="sm"
                                            label="No SEP" enable-old-support required value="{{ $kunjungan->no_sep }}" />
                                        <button type="submit" form="formAdm" class="btn btn-success">
                                            <i class="fas fa-edit"></i> Update Administrasi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- groupping --}}
                        @include('simrs.ranap.erm_ranap_groupping')
                        {{-- keperawatan --}}
                        @include('simrs.ranap.erm_ranap_keperawatan')
                        {{-- resume --}}
                        @include('simrs.ranap.erm_ranap_resume')
                        {{-- dokter --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cDokter">
                                <h3 class="card-title">
                                    Pemeriksaan Spesialistik
                                </h3>
                            </a>
                            <div id="cDokter" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div>
                        {{-- laboratorium --}}
                        @include('simrs.ranap.erm_ranap_lab')
                        {{-- radiologi --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cRadiologi">
                                <h3 class="card-title">
                                    Radiologi
                                </h3>
                            </a>
                            <div id="cRadiologi" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div>
                        {{-- tindakan --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cTindakan">
                                <h3 class="card-title">
                                    Tindakan
                                </h3>
                            </a>
                            <div id="cTindakan" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div>
                        {{-- resep --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cResepObat">
                                <h3 class="card-title">
                                    Resep Obat
                                </h3>
                            </a>
                            <div id="cResepObat" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div>
                        {{-- suratkontrol --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cSuratKontrol">
                                <h3 class="card-title">
                                    Surat Kontrol
                                </h3>
                                <div class="card-tools">
                                    @if ($kunjungan->surat_kontrol)
                                        Sudah Dibuatkan Surat Kontrol {{ $kunjungan->surat_kontrol->noSuratKontrol }}
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        Belum Dibuatkan Surat Kontrol <i class="fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </a>
                            <div id="cSuratKontrol" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    @if ($kunjungan->surat_kontrol)
                                        <input type="hidden" name="nomorsuratkontrol" class="nomorsuratkontrol-id"
                                            value="{{ $kunjungan->surat_kontrol->noSuratKontrol }}">
                                        <form action="{{ route('suratkontrol_update_v2') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-adminlte-input name="nomorkartu" class="nomorkartu-id"
                                                        value="{{ $pasien->no_Bpjs }}" igroup-size="sm"
                                                        label="Nomor Kartu" placeholder="Nomor Kartu" readonly />
                                                    <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                                        igroup-size="sm" placeholder="No RM "
                                                        value="{{ $pasien->no_rm }}" readonly />
                                                    <x-adminlte-input name="nama" class="nama-id"
                                                        value="{{ $pasien->nama_px }}" label="Nama Pasien"
                                                        igroup-size="sm" placeholder="Nama Pasien" readonly />
                                                    <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                                        igroup-size="sm" placeholder="Nomor HP" />
                                                </div>
                                                <div class="col-md-6">
                                                    <x-adminlte-input name="noSuratKontrol" igroup-size="sm"
                                                        label="Nomor Surat Kontrol" placeholder="Nomor SEP"
                                                        value="{{ $kunjungan->surat_kontrol->noSuratKontrol }}"
                                                        readonly />
                                                    <x-adminlte-input name="noSEP" class="nomorsep-id" igroup-size="sm"
                                                        label="Nomor SEP" placeholder="Nomor SEP"
                                                        value="{{ $kunjungan->surat_kontrol->noSepAsalKontrol }}"
                                                        readonly />
                                                    @php
                                                        $config = ['format' => 'YYYY-MM-DD'];
                                                    @endphp
                                                    <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm"
                                                        label="Tanggal Rencana Kontrol"
                                                        value="{{ $kunjungan->surat_kontrol->tglRencanaKontrol }}"
                                                        placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariPoli">
                                                                <i class="fas fa-search"></i> Cari Poli
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input-date>
                                                    <x-adminlte-select2 igroup-size="sm" name="poliKontrol"
                                                        label="Poliklinik">
                                                        <option value="{{ $kunjungan->surat_kontrol->poliTujuan }}"
                                                            selected>{{ $kunjungan->surat_kontrol->namaPoliTujuan }}
                                                        </option>
                                                        <option disabled>Silahkan Klik Cari Poliklinik</option>
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariDokter">
                                                                <i class="fas fa-search"></i> Cari Dokter
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-select2>
                                                    <x-adminlte-select2 igroup-size="sm" name="kodeDokter"
                                                        label="Dokter">
                                                        <option value="{{ $kunjungan->surat_kontrol->kodeDokter }}"
                                                            selected>{{ $kunjungan->surat_kontrol->namaDokter }}</option>
                                                        <option disabled>Silahkan Klik Cari Dokter</option>
                                                    </x-adminlte-select2>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-warning withLoad">
                                                <i class="fas fa-save"></i> Update</button>
                                            <div class="btn  btn-success btnPrintSuratKontrol"> <i
                                                    class="fas fa-print"></i> Print</div>
                                            <a href="{{ route('suratkontrol_delete') }}?nomorsuratkontrol={{ $kunjungan->surat_kontrol->noSuratKontrol }}"
                                                class="btn btn-danger withLoad">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </a>
                                        </form>
                                    @else
                                        <form action="{{ route('suratkontrol_simpan') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="counter" id="counter"
                                                value="{{ $kunjungan->counter }}" class="counter-id" value="">
                                            <input type="hidden" name="kodekunjungan" id="kodekunjungan"
                                                class="kodekunjungan-id" value="{{ $kunjungan->kode_kunjungan }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-adminlte-input name="noSEP" class="nomorsep-id" igroup-size="sm"
                                                        label="Nomor SEP" value="{{ $kunjungan->no_sep }}"
                                                        placeholder="Nomor SEP" readonly>
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariSEP">
                                                                <i class="fas fa-search"></i> Cari SEP
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input>
                                                    <x-adminlte-input name="nomorkartu" class="nomorkartu-id"
                                                        value="{{ $pasien->no_Bpjs }}" igroup-size="sm"
                                                        label="Nomor Kartu" placeholder="Nomor Kartu" readonly />
                                                    <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                                        igroup-size="sm" placeholder="No RM "
                                                        value="{{ $pasien->no_rm }}" readonly />
                                                    <x-adminlte-input name="nama" class="nama-id"
                                                        value="{{ $pasien->nama_px }}" label="Nama Pasien"
                                                        igroup-size="sm" placeholder="Nama Pasien" readonly />
                                                    <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                                        igroup-size="sm" placeholder="Nomor HP" />
                                                </div>
                                                <div class="col-md-6">
                                                    @php
                                                        $config = ['format' => 'YYYY-MM-DD'];
                                                    @endphp
                                                    <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm"
                                                        label="Tanggal Rencana Kontrol"
                                                        placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariPoli">
                                                                <i class="fas fa-search"></i> Cari Poli
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input-date>
                                                    <x-adminlte-select igroup-size="sm" name="poliKontrol"
                                                        label="Poliklinik">
                                                        <option selected disabled>Silahkan Klik Cari Poliklinik</option>
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariDokter">
                                                                <i class="fas fa-search"></i> Cari Dokter
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-select>
                                                    <x-adminlte-select igroup-size="sm" name="kodeDokter" label="Dokter">
                                                        <option selected disabled>Silahkan Klik Cari Dokter</option>
                                                    </x-adminlte-select>
                                                    <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan"
                                                        placeholder="Catatan Pasien" />
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-warning withLoad"> <i
                                                    class="fas fa-save"></i>
                                                Buat
                                                Surat Kontrol</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- pemulangan --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cPulang">
                                <h3 class="card-title">
                                    Pemulangan Pasien
                                </h3>
                                <div class="card-tools">
                                    @if ($kunjungan->tgl_keluar)
                                        Sudah Dipulangkan {{ $kunjungan->tgl_keluar }}
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        Belum Dipulangkan <i class="fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </a>
                            <div id="cPulang" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    <form action="{{ route('pemulangan_sep_pasien') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kodebooking" class="kodebooking-id">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-adminlte-input name="nomorkartu" class="nomorkartu-id"
                                                    value="{{ $pasien->no_Bpjs }}" igroup-size="sm" label="Nomor Kartu"
                                                    placeholder="Nomor Kartu" readonly />
                                                <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                                    igroup-size="sm" placeholder="No RM " value="{{ $pasien->no_rm }}"
                                                    readonly />
                                                <x-adminlte-input name="nama" class="nama-id"
                                                    value="{{ $pasien->nama_px }}" label="Nama Pasien" igroup-size="sm"
                                                    placeholder="Nama Pasien" readonly />
                                                <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                                    igroup-size="sm" placeholder="Nomor HP" />
                                                <input type="hidden" name="gender"
                                                    value="{{ $pasien->jenis_kelamin }}">
                                                <input type="hidden" name="tgllahir" value="{{ $pasien->tgl_lahir }}">
                                            </div>
                                            <div class="col-md-6">
                                                <x-adminlte-input name="noSep" class="nomorsep-id" igroup-size="sm"
                                                    label="Nomor SEP" value="{{ $kunjungan->no_sep }}"
                                                    placeholder="Nomor SEP" readonly>
                                                    <x-slot name="appendSlot">
                                                        <div class="btn btn-primary btnCariSEP">
                                                            <i class="fas fa-search"></i> Cari SEP
                                                        </div>
                                                    </x-slot>
                                                </x-adminlte-input>
                                                <x-adminlte-select igroup-size="sm" name="statusPulang"
                                                    label="Alasan Pulang">
                                                    <option selected disabled>Pilih Alasan Pulang</option>
                                                    <option value="1">Atas Persetujuan Dokter</option>
                                                    <option value="3">Atas Permintaan Sendiri</option>
                                                    <option value="4">Meninggal</option>
                                                    <option value="5">Lain-lain</option>
                                                </x-adminlte-select>
                                                @php
                                                    $config = ['format' => 'YYYY-MM-DD'];
                                                @endphp
                                                <x-adminlte-input-date name="tglPulang" igroup-size="sm"
                                                    label="Tanggal Pulang" value="{{ now()->format('Y-m-d') }}"
                                                    placeholder="Pilih Tanggal Pulang" :config="$config" />
                                                <p class="text-danger">Isi Jika Pasien Meninggal</p>
                                                <x-adminlte-input-date name="tglMeninggal" igroup-size="sm"
                                                    label="Tanggal Meninggal" placeholder="Pilih Tanggal Meninggal"
                                                    :config="$config" />
                                                <x-adminlte-input name="noSuratMeninggal" class="suratmeninggal-id"
                                                    igroup-size="sm" label="Nomor Surat Meninggal"
                                                    placeholder="Nomor Surat Meninggal" />
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-warning withLoad">
                                            <i class="fas fa-save"></i> Pulangkan Pasien</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- filepenunjang --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collapseFile">
                                <h3 class="card-title">
                                    File Penunjang
                                </h3>
                            </a>
                            <div id="collapseFile" class="collapse" role="tabpanel" aria-labelledby="headFile">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn  btn-danger">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="modalSEP" name="modalSEP" title="SEP Peserta" theme="success" icon="fas fa-file-medical"
        size="xl">
        @php
            $heads = ['tglSep', 'tglPlgSep', 'noSep', 'jnsPelayanan', 'poli', 'diagnosa', 'Action'];
            $config['paging'] = false;
            $config['order'] = ['0', 'desc'];
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableSEP" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
            compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('js')
    {{-- gorupping --}}
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            $(".masuk_icu").hide();
            $(".naik_kelas").hide();
            $(".pake_ventilator").hide();
            $(".checkVentilator").hide();
            $(".checkTB").hide();
            $(".checkCovid").hide();
            $(".formbb").hide();
            $('.btnCariSEP').click(function(e) {
                var nomorkartu = $('.nomorkartu-id').val();
                $('#modalSEP').modal('show');
                var table = $('#tableSEP').DataTable();
                table.rows().remove().draw();
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('suratkontrol_sep') }}?nomorkartu=" + nomorkartu;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $.each(data.response, function(key, value) {
                                if (value.jnsPelayanan == 1) {
                                    var jenispelayanan = "Rawat Inap";
                                }
                                if (value.jnsPelayanan == 2) {
                                    var jenispelayanan = "Rawat Jalan";
                                }
                                table.row.add([
                                    value.tglSep,
                                    value.tglPlgSep,
                                    value.noSep,
                                    jenispelayanan,
                                    value.poli,
                                    value.diagnosa,
                                    "<button class='btnPilihSEP btn btn-success btn-xs' data-id=" +
                                    value.noSep +
                                    ">Pilih</button>",
                                ]).draw(false);

                            });
                            $('.btnPilihSEP').click(function() {
                                var nomorsep = $(this).data('id');
                                $.LoadingOverlay("show");
                                $('.nomorsep-id').val(nomorsep);
                                $('#modalSEP').modal('hide');
                                $.LoadingOverlay("hide");
                            });
                        } else {
                            swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        // swal.fire(
                        //     'Error ' + data.metadata.code,
                        //     data.metadata.message,
                        //     'error'
                        // );
                        $.LoadingOverlay("hide");
                    }
                });
            });
        });
    </script>
    {{-- checkbox --}}
    <script>
        function bayiFunc() {
            if ($('#bayi').is(":checked"))
                $(".formbb").show();
            else
                $(".formbb").hide();
        }

        function covidFunc() {
            if ($('#covid').is(":checked"))
                $(".checkCovid").show();
            else
                $(".checkCovid").hide();
        }

        function tbFunc() {
            if ($('#tb').is(":checked"))
                $(".checkTB").show();
            else
                $(".checkTB").hide();
        }

        function perawatanIcuFunc() {
            if ($('#perawatan_icu').is(":checked")) {
                $(".masuk_icu").show();
                $(".checkVentilator").show();
                $(".pake_ventilator").hide();
            } else {
                $(".masuk_icu").hide();
                $(".checkVentilator").hide();
                $(".pake_ventilator").hide();
            }
        }

        function pakeVentilatorFunc() {
            if ($('#ventilator').is(":checked"))
                $(".pake_ventilator").show();
            else
                $(".pake_ventilator").hide();
        }
    </script>
    {{-- search select2 --}}
    <script>
        $(function() {
            $(".diagnosaID").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.eclaim.search_diagnosis') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            keyword: params.term // search term
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
            $(".procedure").select2({
                placeholder: 'Silahkan pilih Tindakan ICD-9',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.eclaim.search_procedures') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            keyword: params.term // search term
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
            // $("#obat").select2({
            //     placeholder: 'Silahkan pilih obat',
            //     theme: "bootstrap4",
            //     ajax: {
            //         url: "{{ route('api.simrs.get_obats') }}",
            //         type: "get",
            //         dataType: 'json',
            //         delay: 100,
            //         data: function(params) {
            //             return {
            //                 search: params.term // search term
            //             };
            //         },
            //         processResults: function(response) {
            //             return {
            //                 results: response
            //             };
            //         },
            //         cache: true
            //     }
            // });
        });
    </script>
    {{-- dynamic input --}}
    <script>
        // row select diagnosa
        $("#rowAdder").click(function() {
            newRowAdd =
                '<div id="row"><div class="form-group"><div class="input-group">' +
                '<select name="diagnosa[]" class="form-control diagnosaID"></select>' +
                '<div class="input-group-append"><button type="button" class="btn btn-xs btn-danger" id="DeleteRow">' +
                '<i class="fas fa-trash "></i> Hapus </button></div>' +
                '</div></div></div>';
            $('#newinput').append(newRowAdd);
            $(".diagnosaID").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.eclaim.search_diagnosis') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            keyword: params.term // search term
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
        $("body").on("click", "#DeleteRow", function() {
            $(this).parents("#row").remove();
        })
        // row select tindakan
        $("#rowAddTindakan").click(function() {
            newRowAdd =
                '<div id="row" class="row"><div class="col-md-7"><div class="form-group"><div class="input-group">' +
                '<div class="input-group-prepend"><span class="input-group-text">' +
                '<i class="fas fa-hand-holding-medical "></i></span></div>' +
                '<select name="procedure[]" class="form-control procedure "></select></div></div></div>' +
                '<div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-prepend">' +
                '<span class="input-group-text"><b>@</b></span></div><input type="number" class="form-control" value="1">' +
                '</div></div></div><div class="col-md-2"><button type="button" class="btn btn-danger" id="deleteRowTindakan"> ' +
                '<i class="fas fa-trash "></i> </button></div></div>';
            $('#newTindakan').append(newRowAdd);
            $(".procedure").select2({
                placeholder: 'Silahkan pilih Tindakan ICD-9',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.eclaim.search_procedures') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            keyword: params.term // search term
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
        $("body").on("click", "#deleteRowTindakan", function() {
            $(this).parents("#row").remove();
        })
    </script>
    {{-- hasil lab --}}
    <script>
        $(function() {
            $('.btnHasilLab').click(function() {
                $('#dataHasilLab').attr('src', $(this).data('fileurl'));
                $('#urlHasilLab').attr('href', $(this).data('fileurl'));
                $('#modalHasilLab').modal('show');
            });
        });
    </script>
    {{-- suratkontrol --}}
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            $('.btnCariPoli').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var sep = $('.nomorsep-id').val();
                var tanggal = $('#tglRencanaKontrol').val();
                var url = "{{ route('suratkontrol_poli') }}?nomor=" + sep + "&tglRencanaKontrol=" +
                    tanggal + "&jenisKontrol=2";
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('#poliKontrol').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaPoli + " (" + value.persentase +
                                    "%)";
                                optValue = value.kodePoli;
                                $('#poliKontrol').append(new Option(optText, optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert(url);
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnCariDokter').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var poli = $('#poliKontrol').find(":selected").val();
                var tanggal = $('#tglRencanaKontrol').val();
                var url = "{{ route('suratkontrol_dokter') }}?kodePoli=" + poli + "&tglRencanaKontrol=" +
                    tanggal + "&jenisKontrol=2";
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('#kodeDokter').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaDokter + " (" + value
                                    .jadwalPraktek +
                                    ")";
                                optValue = value.kodeDokter;
                                $('#kodeDokter').append(new Option(optText, optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert(url);
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnPrintSuratKontrol').click(function(e) {
                $.LoadingOverlay("show");
                var nomorsuratkontrol = $(".nomorsuratkontrol-id").val();
                var url = "{{ route('suratkontrol_print') }}?nomorsuratkontrol=" + nomorsuratkontrol;
                window.open(url, '_blank');
                $.LoadingOverlay("hide");
            });
            $('.btnEditSuratKontrol').click(function(e) {
                $.LoadingOverlay("show");
                var nomorsuratkontrol = $(".nomorsuratkontrol-id").val();
                var url = "{{ route('suratkontrol_edit') }}?nomorsuratkontrol=" + nomorsuratkontrol;
                window.open(url, '_blank');
                $.LoadingOverlay("hide");
            });
        });
    </script>
@endsection
