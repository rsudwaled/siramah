@extends('adminlte::page')

@section('title', 'Encounter')

@section('content_header')
    <h1>Encounter</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="secondary" icon="fas fa-procedures" title="Kunjungan Pasien Rawat Jalan">
                <div class="row">
                    <div class="col-md-4">
                        <x-adminlte-select2 fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                            igroup-class="col-9" name="kodeunit" label="Poliklinik">
                            <option value="-">SEMUA POLIKLINIK</option>
                            @foreach ($units as $key => $item)
                                <option value="{{ $key }}" {{ $key == $request->kodeunit ? 'selected' : null }}>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="col-md-6">
                        @php
                            $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <x-adminlte-input-date fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                            igroup-class="col-9" igroup-size="sm" name="tanggal" label="Tanggal Periksa" :config="$config"
                            value="{{ $request->tanggal ?? now()->format('Y-m-d') }}">
                            <x-slot name="appendSlot">
                                <x-adminlte-button class="btn-sm btnGetObservasi" onclick="getKunjungan()"
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

@section('plugins.Datatables', true)
@section('plugins.BootstrapSwitch', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        $(function() {
            var kodeinit = "{{ $request->kodeunit }}";
            if (kodeinit) {
                getKunjungan();
            }
        });

        function getKunjungan() {
            $.LoadingOverlay("show");
            var ruangan = $("#kodeunit").val();
            var tanggal = $("#tanggal").val();
            var url = "{{ route('table_kunjungan_encounter') }}?kodeunit=" + ruangan + "&tanggalperiksa=" + tanggal;
            console.log(url);
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                $('#tableRanap').html(data);
                $.LoadingOverlay("hide");
            }).fail(function(data) {
                console.log(data);
                $.LoadingOverlay("hide");
            });
        }
    </script>
@endsection
