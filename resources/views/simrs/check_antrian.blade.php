@extends('vendor.medilab.master')

@section('title', 'Checkin Antrian')

@section('content')
    <br>
    <br>
    <br>
    <section id="services" class="services">
        <div class="container">
            <div class="section-title">
                <h2>Checkin Antrian</h2>
            </div>
            <div class="row">
                <div class="col-lg-6 ">
                    @if ($errors->any())
                        <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-adminlte-alert>
                    @endif
                    <form action="" id="daftarTamu" method="get">
                        <div class="form-group mt-3">
                            <label for="kodebooking"><b>Kodebooking</b></label>
                            <input type="text" class="form-control" name="kodebooking" id="kodebooking"
                                placeholder="Masukan kodebooking antrian" value="{{ $request->kodebooking }}">
                        </div>
                        <div class="form-group mt-2 mb-5">
                            <div>
                                <button id="save" type="submit" form="daftarTamu"
                                    class="btn btn-success mt-1">Check</button>
                                <span class="btn btn-danger mt-1" id="clear">Clear</span>
                            </div>
                        </div>
                    </form>
                </div>
                @if ($antrian)
                    <div class="col-lg-6 ">
                        {!! QrCode::size(150)->generate($antrian->kodebooking) !!}
                        <br>
                        <br>
                        <dl class="row">
                            <dt class="col-sm-5">Kode Kooking</dt>
                            <dd class="col-sm-7">{{ $antrian->kodebooking }}</dd>
                            <dt class="col-sm-5">Antrian</dt>
                            <dd class="col-sm-7">{{ $antrian->angkaantrean }} / {{ $antrian->nomorantrean }}</dd>
                            <dt class="col-sm-5">Tgl Periksa</dt>
                            <dd class="col-sm-7">{{ $antrian->tanggalperiksa }}</dd>
                            <dt class="col-sm-5">Pasien</dt>
                            <dd class="col-sm-7">{{ $antrian->pasien->nama_px }}</dd>
                            <dt class="col-sm-5">Poliklinik</dt>
                            <dd class="col-sm-7">{{ $antrian->namapoli }}</dd>
                            <dt class="col-sm-5">Dokter</dt>
                            <dd class="col-sm-7">{{ $antrian->namadokter }}</dd>
                            <dt class="col-sm-5">Status</dt>
                            <dd class="col-sm-7">
                                @switch($antrian->taskid)
                                    @case(0)
                                        Belum Checkin
                                    @break

                                    @case(2)
                                    @break

                                    @case(99)
                                        Batal
                                    @break

                                    @default
                                @endswitch
                            </dd>
                            <dt class="col-sm-5">Keterangan</dt>
                            <dd class="col-sm-7">{{ $antrian->keterangan }}</dd>
                        </dl>
                        <x-adminlte-button class="btn-xs mt-1 withLoad" theme="danger" icon="fas fa-times"
                            data-toggle="tooltop" label="Batalkan Antrian" title="Batal Antrian {{ $antrian->kodebooking }}"
                            onclick="window.location='{{ route('batalPendaftaran') }}?kodebooking={{ $antrian->kodebooking }}'" />
                    </div>
                @endif

            </div>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#tanggalperiksa").datepicker({
                dateFormat: "yy-mm-dd"
            });
            $("#jenispasien").on("change", function() {
                var jenispasien = $(this).val();
                if (jenispasien == 'JKN') {
                    $(".jeniskunjunganC").show()
                    $(".nomorkartuC").show()
                } else {
                    $(".jeniskunjunganC").hide()
                    $(".nomorkartuC").hide()
                }
            });
        });
    </script>
@endsection
