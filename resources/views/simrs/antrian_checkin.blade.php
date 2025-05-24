@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('title', 'Checkin Antrian')
@section('body')
    <div class="wrapper">
        <div class="row p-1">
            <div class="col-md-4">
                <x-adminlte-card title="Anjungan Checkin Antrian RSUD Waled" theme="primary" icon="fas fa-qrcode">
                    <div class="text-center">
                        <form action="" method="GET">
                            <x-adminlte-input name="kodebooking"
                                label="Silahkan scan QR Code Antrian atau masukan Kode Antrian"
                                placeholder="Masukan Kode Antrian untuk Checkin" value="{{ $request->kodebooking }}"
                                igroup-size="lg">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="success" label="Checkin!" />
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
                        <a href="{{ route('anjungan.mandiri') }}" class="btn btn-danger withLoad"><i
                                class="fas fa-arrow-left"></i>
                            Mesin
                            Antrian</a>
                        <a href="{{ route('checkinAntrian') }}" class="btn btn-warning withLoad"><i class="fas fa-sync"></i>
                            Reset
                            Antrian</a>
                    </x-slot>
                </x-adminlte-card>
            </div>
            @if ($antrian)
                <div class="col-md-8">
                    <x-adminlte-card title="Detail Antrian" theme="primary" icon="fas fa-qrcode">
                        <div class="row">
                            <div class="col-md-5">
                                <dl class="row">
                                    <dt class="col-sm-4">Booking</dt>
                                    <dd class="col-sm-8">: {{ $antrian->kodebooking }}</dd>
                                    <dt class="col-sm-4">Pasien</dt>
                                    <dd class="col-sm-8">: {{ $antrian->nama }}</dd>
                                    <dt class="col-sm-4">RM </dt>
                                    <dd class="col-sm-8">: {{ $antrian->norm }} </dd>
                                    <dt class="col-sm-4">No BPJS</dt>
                                    <dd class="col-sm-8">: {{ $antrian->nomorkartu }}</dd>
                                    <dt class="col-sm-4">No HP</dt>
                                    <dd class="col-sm-8">: {{ $antrian->nohp }}</dd>
                                    <dt class="col-sm-4">Jenis</dt>
                                    <dd class="col-sm-8">: {{ $antrian->jenispasien }} / {{ $antrian->jeniskunjungan }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-7">
                                <dl class="row">
                                    <dt class="col-sm-4">Tanggal Periksa</dt>
                                    <dd class="col-sm-8">: {{ $antrian->tanggalperiksa }}</dd>
                                    <dt class="col-sm-4">Poliklinik</dt>
                                    <dd class="col-sm-8">: {{ $antrian->namapoli }}</dd>
                                    <dt class="col-sm-4">Dokter</dt>
                                    <dd class="col-sm-8">: {{ $antrian->namadokter }}</dd>
                                    <dt class="col-sm-4">Jadwal</dt>
                                    <dd class="col-sm-8">: {{ $antrian->jampraktek }}</dd>
                                    <dt class="col-sm-4">Taskid</dt>
                                    <dd class="col-sm-8">: {{ $antrian->taskid }}</dd>
                                    <dt class="col-sm-4">No SEP</dt>
                                    <dd class="col-sm-8">: {{ $antrian->nomorsep ?? '-' }}</dd>
                                </dl>
                            </div>
                        </div>
                        @if ($antrian->nomorsep)
                            <x-adminlte-alert theme="warning" title="Informasi SEP">
                                SEP sudah dicetak dengan Nomor <b>{{ $antrian->nomorsep }}</b>
                            </x-adminlte-alert>
                        @endif
                        @isset($kunjungan->layanan)
                            <div class="row">
                                <div class="col-md-5">
                                    <dl class="row">
                                        <dt class="col-sm-4">Kunjungan</dt>
                                        <dd class="col-sm-8">: {{ $kunjungan->kode_kunjungan ?? '-' }}</dd>
                                        <dt class="col-sm-4">Layanan</dt>
                                        <dd class="col-sm-8">: {{ $kunjungan->layanan->kode_layanan_header }}</dd>
                                        <dt class="col-sm-4">Penjamin</dt>
                                        <dd class="col-sm-8">:
                                            {{ $kunjungan->penjamin_simrs ? $kunjungan->penjamin_simrs->nama_penjamin : '-' }}
                                        </dd>

                                    </dl>
                                </div>
                                <div class="col-md-7">
                                    <dl class="row">
                                        <dt class="col-sm-4">No SEP</dt>
                                        <dd class="col-sm-8">: {{ $kunjungan->no_sep ?? '-' }}</dd>
                                        <dt class="col-sm-4">Status</dt>
                                        <dd class="col-sm-8">:
                                            {{ $kunjungan->status ? $kunjungan->status->status_kunjungan : '-' }}</dd>
                                        <dt class="col-sm-4">Tracer</dt>
                                        <dd class="col-sm-8">:
                                            @if ($kunjungan->tracer)
                                                {{ $kunjungan->tracer->id_tracer_header }} /
                                                {{ $kunjungan->tracer->cek_tracer }}
                                            @endif
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <table class="table-bordered col-md-12">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Tarif</th>
                                        <th>Jumlah Tarif</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($kunjungan->layanan->layanan_details as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->id_layanan_detail }}</td>
                                            <td>{{ $item->tarif_detail->tarif->NAMA_TARIF }}</td>
                                            <td class="text-right"> {{ money($item->total_layanan, 'IDR') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-right" colspan="2">Total</th>
                                        <th class="text-right">
                                            {{ money($kunjungan->layanan->layanan_details->sum('total_layanan'), 'IDR') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        @else
                            <x-adminlte-alert theme="danger" title="Belum Cetak Karcis Antrian">
                                Silahkan lakukan cetak karcis
                            </x-adminlte-alert>
                        @endisset
                        <x-slot name="footerSlot">
                            @if ($antrian->jenispasien == 'JKN')
                                <a href="{{ route('checkinCetakSEP') }}?kodebooking={{ $request->kodebooking }}"
                                    class="btn btn-warning withLoad"><i class="fas fa-print"></i> Cetak SEP BPJS</a>

                                @if ($antrian->nomorsep)
                                    <a href="{{ route('checkinKarcisAntrian') }}?kodebooking={{ $request->kodebooking }}"
                                        class="btn btn-success withLoad"><i class="fas fa-print"></i>
                                        Cetak Karcis</a>
                                @endif
                                <a href="{{ route('checkinPendaftaran') }}?kodebooking={{ $request->kodebooking }}"
                                    class="btn btn-secondary withLoad"><i class="fas fa-print"></i> Checkin
                                    Pendaftaran</a>
                                @if (!$antrian->nomorsep)
                                @else
                                    <x-adminlte-button
                                        onclick="window.open('{{ route('cetakSEPAntrian') }}?kodebooking={{ $request->kodebooking }}', 'window name', 'window settings');"
                                        theme="warning" icon="fas fa-print" label="Cetak SEP Antrian"
                                        data-kodebooking="{{ $request->kodebooking }}" />
                                    <x-adminlte-button
                                        onclick="window.open('{{ route('cetakAntrianOnline') }}?kodebooking={{ $request->kodebooking }}', 'window name', 'window settings');"
                                        theme="warning" icon="fas fa-print"
                                        data-kodebooking="{{ $request->kodebooking }}" />
                                @endif
                            @else
                                <a href="{{ route('checkinKarcisAntrian') }}?kodebooking={{ $request->kodebooking }}"
                                    class="btn btn-success withLoad"><i class="fas fa-print"></i>
                                    Cetak Karcis</a>
                            @endif
                            <a target="_blank" href="http://192.168.2.45/simrs/cetaklabel/{{ $antrian->norm }}"
                                class="btn btn-primary"><i class="fas fa-print"></i>
                                Cetak Label</a>
                            {{-- <a href="{{ route('batalAntrian') }}?kodebooking={{ $request->kodebooking }}"
                                class="btn btn-danger"><i class="fas fa-times withLoad"></i> Batal Antrian</a> --}}
                        </x-slot>
                    </x-adminlte-card>
                </div>
            @endif
        </div>
    </div>
@stop
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
    {{-- scan --}}
    <script>
        $(function() {
            onScan.attachTo(document, {
                onScan: function(sCode, iQty) {
                    $.LoadingOverlay("show", {
                        text: "Mencari kodebooking " + sCode + "..."
                    });
                    var url = "{{ route('checkinAntrian') }}?kodebooking=" + sCode;
                    window.location.href = url;
                    // var formData = {
                    //     kodebooking: sCode,
                    //     waktu: "{{ \Carbon\Carbon::now()->timestamp * 1000 }}",
                    // };
                    // $('#kodebooking').val(sCode);
                    // $.get(url, formData, function(data) {
                    //     console.log(data);
                    //     $.LoadingOverlay("hide");
                    //     if (data.metadata.code == 200) {
                    //         $('#status').html(data.metadata.message);
                    //         swal.fire(
                    //             'Sukses...',
                    //             data.metadata.message,
                    //             'success'
                    //         ).then(okay => {
                    //             if (okay) {
                    //                 $.LoadingOverlay("show", {
                    //                     text: "Reload..."
                    //                 });
                    //                 $('#status').html('-');
                    //                 location.reload();
                    //             }
                    //         });
                    //     } else {
                    //         $('#status').html(data.metadata.message);
                    //         swal.fire(
                    //             'Opss Error...',
                    //             data.metadata.message,
                    //             'error'
                    //         ).then(okay => {
                    //             if (okay) {
                    //                 $.LoadingOverlay("show", {
                    //                     text: "Reload..."
                    //                 });
                    //                 $('#status').html('-');
                    //                 location.reload();
                    //             }
                    //         });
                    //     }
                    // });
                },
            });
        });
    </script>
    {{-- withLoad --}}
    <script>
        $('.cetakSEP').click(function() {
            var kodebooking = $(this).data('kodebooking');
            var url = "{{ route('cetakSEPAntrian') }}?kodebooking=" + kodebooking;
            window.open(url, 'window name', 'window settings');
            return false;
        });
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
