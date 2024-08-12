@extends('adminlte::page')
@section('title', 'ERM RANAP ' . $pasien->nama_px)
@section('content_header')
    <h1>ERM RANAP : {{ $pasien->nama_px }}</h1>
@stop
@section('content')
    @php
        $total = 0;
    @endphp
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" theme-mode="outline">
                <div class="row">
                    @include('simrs.ranap.erm_ranap_profil')
                </div>
            </x-adminlte-card>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p>Silahkan Klik Tombol dibawah ini untuk memunculkan tampilan :</p>
                    <a class="btn btn-app bg-success">
                        <i class="fas fa-edit"></i> Triase IGD
                    </a>
                    <a class="btn btn-app">
                        <i class="fas fa-play"></i> Radiologi
                    </a>
                    <a class="btn btn-app">
                        <i class="fas fa-pause"></i> Laboratorium
                    </a>
                    <a class="btn btn-app">
                        <i class="fas fa-save"></i> Berkas
                    </a>
                    <a class="btn btn-app">
                        <span class="badge bg-warning">3</span>
                        <i class="fas fa-bullhorn"></i> Assesmen Awal
                    </a>
                    <a class="btn btn-app">
                        <span class="badge bg-success">300</span>
                        <i class="fas fa-barcode"></i> Assesmen Keperawatan
                    </a>
                    <a class="btn btn-app">
                        <span class="badge bg-purple">891</span>
                        <i class="fas fa-users"></i> SOAP & Perkembangan
                    </a>
                    <a class="btn btn-app">
                        <span class="badge bg-teal">67</span>
                        <i class="fas fa-inbox"></i> Implementasi - Evaluasi
                    </a>
                    <a class="btn btn-app">
                        <span class="badge bg-info">12</span>
                        <i class="fas fa-envelope"></i> Observasi 24Jam
                    </a>
                    <a class="btn btn-app">
                        <i class="fas fa-heart"></i> Rencana Asuhan
                    </a>
                    <a class="btn btn-app">
                        <i class="fas fa-heart"></i> Grouping E-Klaim
                    </a>
                    <a class="btn btn-app">
                        <i class="fas fa-heart"></i> KPO Elektronik
                    </a>
                    <a class="btn btn-app">
                        <i class="fas fa-heart"></i> Evaluasi Awal MPP(A)
                    </a>
                    <a class="btn btn-app">
                        <i class="fas fa-heart"></i> Catatan Implementasi MPP(B)
                    </a>

                </div>
            </div>
        </div>
        <div class="col-12">
            {{-- <div class="info-box">
                <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Bagian card Pertama</span>
                    <span class="info-box-number">selesai bagian view</span>
                </div>
            </div> --}}
            @include('simrs.ranap.card-tab.tab_first')
        </div>
        <div class="col-12">
            @include('simrs.ranap.card-tab.tab_second')
        </div>
        <div class="col-12">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-grouping-eklaim-tab" data-toggle="pill"
                                href="#tab-grouping-eklaim" role="tab" aria-controls="tab-grouping-eklaim"
                                aria-selected="false">Grouping E-Klaim</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="tabs-kpo-tab" data-toggle="pill" href="#tab-kpo" role="tab"
                                aria-controls="tab-kpo" aria-selected="true">KPO Elektronik</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        @include('simrs.ranap.component-tab.tab_grouping_eklaim')
                        @include('simrs.ranap.component-tab.tab_kpo')
                    </div>
                </div>
            </div>
        </div>

        {{-- view lama --}}
        <div class="col-md-3">
            @include('simrs.ranap.sidebar-menu.navbar')
        </div>
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 600px ;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        {{-- @include('simrs.ranap.card-content.triase_igd') --}}
                        {{-- @include('simrs.ranap.card-content.laboratorium') --}}
                        {{-- rincian --}}
                        {{-- <div id="rincian_biaya"></div> --}}
                        {{-- asesmen awal --}}
                        {{-- @include('simrs.ranap.modal.modal_asesmen_awal') --}}
                        {{-- asuhan terpadu --}}
                        @include('simrs.ranap.modal.modal_asuhan_terpadu')
                        {{-- asesmen perawat --}}
                        @include('simrs.ranap.modal.modal_asesmen_keperawatan')
                        {{-- groupping --}}
                        @include('simrs.ranap.modal.modal_groupping')
                        {{-- perkembangan --}}
                        {{-- @include('simrs.ranap.erm_ranap_catatan_pekembangan_pasien') --}}
                        {{-- keperawatan --}}
                        {{-- @include('simrs.ranap.erm_ranap_keperawatan') --}}
                        {{-- observasi --}}
                        {{-- @include('simrs.ranap.erm_ranap_observasi') --}}
                        {{-- KPO --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cKPO">
                                <h3 class="card-title">
                                    KPO Elektronik
                                </h3>
                            </a>
                            {{-- <div id="cKPO" class="collapse" role="tabpanel">
                                <div class="card-body p-0">
                                    <iframe id="kpoFrame" src="" height="780" width="100%"
                                        frameborder="0"></iframe>
                                </div>
                            </div> --}}
                        </div>
                        {{-- mpp form a --}}
                        @include('simrs.ranap.modal.modal_mpp_a')
                        {{-- mpp form b --}}
                        @include('simrs.ranap.erm_ranap_mppb')
                        {{-- rencana pemulangan --}}
                        @include('simrs.ranap.modal.modal_rencana_pulang')
                        {{-- resume --}}
                        @include('simrs.ranap.modal.modal_resume_ranap')
                        {{-- tindakan --}}

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
                        @include('simrs.ranap.modal.modal_suratkontrol')
                        {{-- @include('simrs.ranap.modal.modal_laboratorium') --}}
                        @include('simrs.ranap.modal.modal_radiologi')
                        @include('simrs.ranap.modal.modal_patologi')
                        @include('simrs.ranap.modal.modal_file_rm')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('js')
    {{-- toast --}}
    <script>
        var Toast = Swal.mixin({
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
    </script>
    {{-- gorupping --}}
    <script>
        $(function() {
            $('#kpoFrame').attr('src', 'http://192.168.2.125/kpoelektronik/');
            $(".masuk_icu").hide();
            $(".naik_kelas").hide();
            $(".pake_ventilator").hide();
            $(".checkVentilator").hide();
            $(".checkTB").hide();
            $(".checkCovid").hide();
            $(".formbb").hide();
            $(".diagnosaID").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('get_diagnosis_eclaim') }}",
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
            $(".diagSekunderResume").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('get_diagnosis_eclaim') }}",
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
                    url: "{{ route('get_procedure_eclaim') }}",
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
            $(".icd9operasi").select2({
                placeholder: 'Silahkan pilih Tindakan ICD-9',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('get_procedure_eclaim') }}",
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

        function checkBayi() {
            if ($('#bayi').is(":checked"))
                $(".formbb").show();
            else
                $(".formbb").hide();
        }

        function checkCovid() {
            if ($('#covid').is(":checked"))
                $(".checkCovid").show();
            else
                $(".checkCovid").hide();
        }

        function checkTB() {
            if ($('#tb').is(":checked"))
                $(".checkTB").show();
            else
                $(".checkTB").hide();
        }

        function checkIcu() {
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

        function checkVenti() {
            if ($('#ventilator').is(":checked"))
                $(".pake_ventilator").show();
            else
                $(".pake_ventilator").hide();
        }
        // row select diagnosa
        $("#rowAdder").click(function() {
            newRowAdd =
                '<div id="row"><div class="form-group"><div class="input-group">' +
                '<div class="input-group-prepend"><span class="input-group-text">' +
                '<i class="fas fa-diagnoses "></i></span></div>' +
                '<select name="diagnosa[]" class="form-control diagnosaID"></select>' +
                '<div class="input-group-append"><button type="button" class="btn btn-xs btn-danger" id="DeleteRow">' +
                '<i class="fas fa-trash "></i> Hapus</button></div>' +
                '</div></div></div>';
            $('#newinput').append(newRowAdd);
            $(".diagnosaID").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('get_diagnosis_eclaim') }}",
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
                '<i class="fas fa-procedures "></i></span></div>' +
                '<select name="procedure[]" class="form-control procedure "></select></div></div></div>' +
                '<div class="col-md-3"><div class="form-group"><div class="input-group input-group-sm"><div class="input-group-prepend">' +
                '<span class="input-group-text"><b>@</b></span></div><input type="number" class="form-control" value="1">' +
                '</div></div></div><div class="col-md-2"><button type="button" class="btn btn-sm btn-danger" id="deleteRowTindakan"> ' +
                '<i class="fas fa-trash "></i> Hapus</button></div></div>';
            $('#newTindakan').append(newRowAdd);
            $(".procedure").select2({
                placeholder: 'Silahkan pilih Tindakan ICD-9',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('get_procedure_eclaim') }}",
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
        });
    </script>
    {{-- rincian biaya --}}
    <script>
        $(function() {
            getRincianBiaya();
        });

        function getRincianBiaya() {
            var url =
                "{{ route('get_rincian_biaya') }}?norm={{ $kunjungan->no_rm }}&counter={{ $kunjungan->counter }}";
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                $('#rincian_biaya').html(data);
                $('#tableRincianBiaya').DataTable({
                    "paging": false,
                    "info": false,
                    "scrollCollapse": true,
                    "scrollY": '300px'
                });
            });
        }
    </script>
@endsection
