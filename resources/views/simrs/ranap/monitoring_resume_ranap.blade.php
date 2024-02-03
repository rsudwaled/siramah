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
    {{-- <x-adminlte-modal  title="Resume Ranap" theme="warning" icon="fas fa-file-medical" size='xl'>
        <div id="formResume"></div>
        <x-slot name="footerSlot">
          <button class="btn btn-success mr-auto" onclick="simpanttd()"><i class="fas fa-save"></i>
                Simpan</button>
            <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal> --}}
    <div class="modal" id="modalResume" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="max-width: none !important;margin: 1rem !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
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
@section('js')
    {{-- pasien rawat inap --}}
    <script>
        $(function() {
            var kodeinit = "{{ $request->kodeunit }}";
            if (kodeinit) {
                getPasienRanap();
            }
        });

        function getPasienRanap() {
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
            });
        }

        function lihatResume(params) {
            $.LoadingOverlay("show");
            var kode = $(params).data('kode');
            var url = "{{ route('form_resume_ranap') }}?kode=" + kode;
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
@endsection
