@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('title', 'Checkin Antrian')
@section('body')
    <div class="wrapper">
        <div class="row p-1">
            {{-- checkin --}}
            <div class="col-md-12">
                <x-adminlte-card title="Anjungan Checkin Antrian RSUD Waled" theme="primary" icon="fas fa-qrcode">
                    <div class="text-center">
                        <form action="" method="GET">
                            <x-adminlte-input name="kodebooking"
                                label="Silahkan scan QR Code Antrian atau masukan Kode Antrian"
                                placeholder="Masukan Kode Antrian untuk Checkin" value="{{ $request->kodebooking }}" igroup-size="lg">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="success"
                                        label="Checkin!" />
                                </x-slot>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text text-success">
                                        <i class="fas fa-qrcode"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </form>

                        <i class="fas fa-qrcode fa-3x"></i>
                        <br>
                        <label>Status = <span id="status">-</span></label>
                    </div>
                    <x-slot name="footerSlot">
                        <a href="{{ route('antrianConsole') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                            Mesin
                            Antrian</a>
                        <a href="{{ route('checkinAntrian') }}" class="btn btn-warning"><i class="fas fa-sync"></i> Reset
                            Antrian</a>
                    </x-slot>
                </x-adminlte-card>
                {{-- <div class="col-md-12">
                    <x-adminlte-button icon="fas fa-sync" class="withLoad reload" theme="warning" label="Reload" />
                    <a href="{{ route('cekPrinter') }}" class="btn btn-warning"><i class="fas fa-print"></i> Test
                        Printer</a>
                    <a href="{{ route('jadwalDokterAntrian') }}" target="_blank" class="btn btn-warning"><i
                            class="fas fa-calendar-alt"></i> Jadwal
                        Dokter</a>
                </div> --}}
            </div>
            @if ($antrian)

            <div class="col-md-12">
                <x-adminlte-card title="Detail Antrian" theme="primary" icon="fas fa-qrcode">
                    {{ $antrian->kodebooking }}
                    {{ $antrian->taskid }}
                    {{ $antrian->kunjungan }}
                </x-adminlte-card>
            </div>
            @endif
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)*


@include('sweetalert::alert')
@section('adminlte_css')
    {{-- <script src="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"></script> --}}
@endsection
@section('adminlte_js')
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/loading-overlay/loadingoverlay.min.js') }}"></script>
    <script src="{{ asset('vendor/onscan.js/onscan.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- withLoad --}}
    <script>
        $(function() {
            $(".withLoad").click(function() {
                $.LoadingOverlay("show");
            });
        })
        $('.reload').click(function() {
            location.reload();
        });
    </script>
@stop
