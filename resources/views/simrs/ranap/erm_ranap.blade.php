@extends('adminlte::page')
@section('title', 'ERM RANAP ' . $pasien->nama_px)
@section('content_header')
    <div class="row">
        <div class="col-md-8">
            <h1>ERM RANAP : {{ $pasien->nama_px }}</h1>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('kunjunganranap') }}?kodeunit={{ $kunjungan->kode_unit }}"
                class="btn btn-sm mb-2 btn-danger withLoad"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
@stop
@section('content')
    @php
        $total = 0;
    @endphp
    <div class="row">
        {{-- profil --}}
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
                    <div class="row">
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'radiologi']) }}"
                            class="btn btn-app {{ $activeButton === 'radiologi' ? 'bg-success' : '' }}">
                            <i class="fas fa-x-ray"></i> Radiologi
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'laboratorium']) }}"
                            class="btn btn-app {{ $activeButton === 'laboratorium' ? 'bg-success' : '' }}">
                            <i class="fas fa-vials"></i> Laboratorium
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'lab_patologianatomi']) }}"
                            class="btn btn-app {{ $activeButton === 'lab_patologianatomi' ? 'bg-success' : '' }}">
                            <i class="fas fa-microscope"></i> Lab Patologi Anatomi
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'triase']) }}"
                            class="btn btn-app {{ $activeButton === 'triase' ? 'bg-success' : '' }}">
                            <i class="fas fa-file-invoice"></i> Triase IGD
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'berkas']) }}"
                            class="btn btn-app {{ $activeButton === 'berkas' ? 'bg-success' : '' }}">
                            <i class="fas fa-file-medical"></i> Berkas
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'rencana_asuhan']) }}"
                            class="btn btn-app {{ $activeButton === 'rencana_asuhan' ? 'bg-success' : '' }}">
                            <i class="fas fa-file-contract"></i> Rencana Asuhan
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'assesmen_awal_medis']) }}"
                            class="btn btn-app {{ $activeButton === 'assesmen_awal_medis' ? 'bg-success' : '' }}">
                            <i class="fas fa-file-medical-alt"></i> Assesmen Awal Medis
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'assesmen_keperawatan']) }}"
                            class="btn btn-app {{ $activeButton === 'assesmen_keperawatan' ? 'bg-success' : '' }}">
                            <i class="fas fa-file-signature"></i> Assesmen Keperawatan
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'soap']) }}"
                            class="btn btn-app {{ $activeButton === 'soap' ? 'bg-success' : '' }}">
                            <i class="fas fa-laptop-medical"></i> SOAP
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'implementasi_evaluasi']) }}"
                            class="btn btn-app {{ $activeButton === 'implementasi_evaluasi' ? 'bg-success' : '' }}">
                            <i class="fas fa-user-nurse"></i> Implementasi & Evaluasi
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'observasi_24jam']) }}"
                            class="btn btn-app {{ $activeButton === 'observasi_24jam' ? 'bg-success' : '' }}">
                            <i class="fas fa-user-clock"></i> Observasi 24Jam
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'kpo_elektronik']) }}"
                            class="btn btn-app {{ $activeButton === 'kpo_elektronik' ? 'bg-success' : '' }}">
                            <i class="fas fa-laptop-code"></i> KPO Elektronik
                        </a>
                        <a href="{{ route('pasienranapprofile', ['kode' => $kode, 'active_button' => 'grouping_eklaim']) }}"
                            class="btn btn-app {{ $activeButton === 'grouping_eklaim' ? 'bg-success' : '' }}">
                            <i class="fas fa-laptop-code"></i> Grouping
                        </a>
                    </div>
                    <!-- Tambahkan tombol lainnya dengan logika yang sama -->
                </div>
            </div>
        </div>
        @if ($activeButton)
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ $cardContent['title'] }}
                        </h3>
                    </div>
                    <div class="card-body pad table-responsive">
                        {!! $cardContent['content'] !!}
                    </div>

                </div>
            </div>
        @endif

    </div>
@stop
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Datatables', true)
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
    <script>
        function showHasilLab(button) {
            var kode = $(button).data('kode');
            var url = "http://192.168.2.74/smartlab_waled/his/his_report?hisno=" + kode;
            $('#dataHasilLab').attr('src', url);
            $('#urlHasilLab').attr('href', url);
            $('#modalHasilLab').modal('show');
        }

        function lihatHasilRongsen(button) {
            var norm = $(button).data('norm');
            var url = "http://192.168.10.17/ZFP?mode=proxy&lights=on&titlebar=on#View&ris_pat_id=" + norm +
                "&un=radiologi&pw=YnanEegSoQr0lxvKr59DTyTO44qTbzbn9koNCrajqCRwHCVhfQAddGf%2f4PNjqOaV";
            $('#dataUrlRongsen').attr('src', url);
            $('#modalRongsen').modal('show');
        }

        function lihatExpertiseRad(button) {
            var header = $(button).data('header');
            var detail = $(button).data('detail');
            var url = "http://192.168.2.233/expertise/cetak0.php?IDs=" + header + "&IDd=" + detail +
                "&tgl_cetak={{ now()->format('Y-m-d') }}";
            $('#dataUrlRongsen').attr('src', url);
            $('#modalRongsen').modal('show');
        }

        function showHasilPa(button) {
            var kode = $(button).data('kode');
            var url = "http://192.168.2.212:81/simrswaled/SimrsPrint/printEX/" +
                kode;
            $('#dataHasilLabPa').attr('src', url);
            $('#urlHasilLabPa').attr('href', url);
            $('#modalLabPA').modal('show');
        }
    </script>
@endsection
@push('js')
    @include('simrs.ranap.function_script.soap.soap_function_js')
    @include('simrs.ranap.function_script.implementasi_evaluasi.implementasi_evaluasi_function_js')
    @include('simrs.ranap.function_script.rencana_asuhan.rencana_asuh_function_js')
@endpush
