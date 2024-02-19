@extends('adminlte::page')
@section('title', 'Monitoring Resume Ranap')
@section('content_header')
    <h1>Monitoring Resume Ranap</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="secondary" icon="fas fa-info-circle" title="Total Pasien">
                <div class="row">
                    <div class="col-md-4">
                        <x-adminlte-select2 fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                            igroup-class="col-9" name="kodeunit" label="Ruangan">
                            @foreach ($units as $key => $item)
                                <option value="{{ $key }}" {{ $key == $request->kodeunit ? 'selected' : null }}>
                                    {{ $item }} ({{ $key }})
                                </option>
                            @endforeach
                            <option value="-">SEMUA RUANGAN (-)
                            </option>
                        </x-adminlte-select2>
                    </div>
                    <div class="col-md-6">
                        @php
                            $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <x-adminlte-input-date fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                            igroup-class="col-9" igroup-size="sm" name="tanggal" label="Tanggal Rawat Inap"
                            :config="$config" value="{{ now()->format('Y-m-d') }}">
                            <x-slot name="appendSlot">
                                <x-adminlte-button class="btn-sm btnGetObservasi" onclick="getPasienRanap()"
                                    icon="fas fa-search" theme="primary" label="Submit Pencarian" />
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>
                </div>
                <div id="tableRanap"></div>
            </x-adminlte-card>
        </div>
    </div>
    <div class="modal" id="modalResume" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="max-width: none !important;margin: 2rem !important;">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Resume Rawat Inap</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="formResume"></div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" type="submit" form="formResume" class="btn btn-success"><i
                            class="fas fa-edit"></i> Simpan /
                        Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div> --}}
            </div>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@push('css')
    <link rel="stylesheet" href="{{ asset('signature/dist/signature-style.css') }}">
@endpush
@push('js')
    <script>
        $(function() {
            var kodeinit = "{{ $request->kodeunit }}";
            if (kodeinit) {
                getPasienRanap();
            }
        });

        function getPasienRanap() {
            $.LoadingOverlay("show");
            var ruangan = $("#kodeunit").val();
            var tanggal = $("#tanggal").val();
            var url = "{{ route('table_resume_ranap') }}?ruangan=" + ruangan + "&tanggal=" + tanggal;
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                $('#tableRanap').html(data);
                var table = $('#table1').DataTable({
                    "paging": false,
                    "info": false,
                });
                $.LoadingOverlay("hide");
            });
        }

        function lihatResume(params) {
            $.LoadingOverlay("show");
            var kode = $(params).data('kode');
            var url = "{{ route('form_resume_ranap') }}?kode=" + kode;
            alert(url);
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                console.log(data);
                $('#formResume').html(data);
                $('#modalResume').modal('show');
                $.LoadingOverlay("hide");
            });
            // alert(url);
        }
    </script>
    <script src="{{ asset('signature/dist/underscore-min.js') }}"></script>
    <script src="{{ asset('signature/dist/signature-script.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#formResume").submit(function(event) {
                var diagSekunderKosong = $(".diagSekunderResume[name='icd10_sekunder[]']");
                diagSekunderKosong.each(function() {
                    if ($(this).val().length === 0) {
                        $(this).append(
                            '<option value="-|Belum Diisi" selected>Belum Diisi</option>');
                        $(this).trigger('change.select2');
                    }
                });
                var icd9operasiKosong = $(".icd9operasi[name='icd9_operasi[]']");
                icd9operasiKosong.each(function() {
                    if ($(this).val().length === 0) {
                        $(this).append(
                            '<option value="-|Belum Diisi" selected>Belum Diisi</option>');
                        $(this).trigger('change.select2');
                    }
                });
                var icd9prosedurKosong = $(".icd9operasi[name='icd9_prosedur[]']");
                icd9prosedurKosong.each(function() {
                    if ($(this).val().length === 0) {
                        $(this).append(
                            '<option value="-|Belum Diisi" selected>Belum Diisi</option>');
                        $(this).trigger('change.select2');
                    }
                });

            });
        });

        function simpanResume() {
            var unfilledSelects = $(".diagSekunderResume[name='icd10_sekunder[]']");
            unfilledSelects.each(function() {
                if ($(this).val().length === 0) {
                    $(this).append('<option value="-" selected>Belum Diisi</option>');
                    $(this).trigger('change.select2');
                }
            });
            $("#formResume").submit();
        }
    </script>
    <script>
        function btnttdDokter() {
            $.LoadingOverlay("show");
            $('#formttd').attr('action', "{{ route('ttd_dokter_resume_ranap') }}");
            $('#modalttd').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnttdPasien() {
            $.LoadingOverlay("show");
            $('#formttd').attr('action', "{{ route('ttd_pasien_resume_ranap') }}");
            $('#modalttd').modal('show');
            $.LoadingOverlay("hide");
        }

        function simpanttd() {
            var canvas = document.getElementById("signature-pad");
            var baseimage = canvas.toDataURL();
            $('#ttd_image64').val(baseimage);
            $("#formttd").submit();
        }
    </script>
    <script>
        function addDiagSekunderResume() {
            newRowAdd = '<div id="row"><div class="form-group"><div class="row">' +
                '<div class="input-group col-md-6">' +
                '<input type="text" class="form-control form-control-sm" name="diagnosa_sekunder[]" placeholder="Diagnosa Sekunder" required></div>' +
                '<div class="input-group col-md-6"><select name="icd10_sekunder[]" class="form-control diagSekunderResume"></select>' +
                '<div class="input-group-append">' +
                '<button type="button" class="btn btn-xs btn-danger" onclick="hapusDiagSekunderResume(this)">' +
                '<i class="fas fa-trash"></i>' +
                "</button></div></div></div></div> </div>";
            $('#diagSekunderBaru').append(newRowAdd);
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
        }

        function hapusDiagSekunderResume(button) {
            $(button).parents("#row").remove();
        }

        function addIcdOperasi() {
            newRowAdd = '<div id="row"><div class="form-group"><div class="row">' +
                '<div class="input-group col-md-6">' +
                '<input type="text" class="form-control form-control-sm" name="tindakan_operasi[]" placeholder="Tindakan Operasi" required></div>' +
                '<div class="input-group col-md-6"><select name="icd9_operasi[]" class="form-control icd9operasi"></select>' +
                '<div class="input-group-append">' +
                '<button type="button" class="btn btn-xs btn-danger" onclick="hapusIcdOperasi(this)">' +
                '<i class="fas fa-trash"></i>' +
                "</button></div></div></div></div></div>";
            $('#inputIcdOperasi').append(newRowAdd);
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

        }

        function hapusIcdOperasi(button) {
            $(button).parents("#row").remove();
        }

        function addIcdTindakan() {
            newRowAdd = '<div id="row"><div class="form-group"><div class="row">' +
                '<div class="input-group col-md-6">' +
                '<input type="text" class="form-control form-control-sm" name="tindakan_prosedur[]" placeholder="Tindakan Prosedur" required></div>' +
                '<div class="input-group col-md-6"><select name="icd9_prosedur[]" class="form-control icd9operasi"></select>' +
                '<div class="input-group-append">' +
                '<button type="button" class="btn btn-xs btn-danger" onclick="hapusIcdOperasi(this)">' +
                '<i class="fas fa-trash"></i>' +
                "</button></div></div></div></div></div>";
            $('#inputIcdTindakan').append(newRowAdd);
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
        }
    </script>
@endpush
