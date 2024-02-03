@extends('adminlte::page')
@section('title', 'Pasien Rawat Inap')
@section('content_header')
    <h1>Pasien Rawat Inap</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="secondary" icon="fas fa-info-circle" title="Data Pasien Rawat Inap">
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
            var url = "{{ route('get_pasien_ranap') }}?ruangan=" + ruangan + "&tanggal=" + tanggal;
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                $('#tableRanap').html(data);
                var table = $('#table1').DataTable({
                    "paging": false,
                    "info": false,
                    "scrollCollapse": true,
                    "scrollY": '300px'
                });
                $(".withLoad").click(function() {
                    $.LoadingOverlay("show");
                });
            });
        }
    </script>
@endsection
