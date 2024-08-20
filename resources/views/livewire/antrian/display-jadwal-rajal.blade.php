<div class="row">
    <div class="col-md-12">
        <div class="card">
            <header class="bg-green text-white p-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <img src="{{ asset('vendor/adminlte/dist/img/logo rsudwaled bulet.png') }}" height="90"
                                    alt="">
                                <div class="col">
                                    <h1>RSUD Waled</h1>
                                    <h4>Rumah Sakit Umum Daerah Waled</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end text-right">
                            <h1>Jadwal Dokter Rawat Jalan</h1>
                            <h4>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</h4>
                        </div>
                    </div>
                </div>
            </header>
        </div>
    </div>
    <div class="col-md-5">
        <x-adminlte-card title="Antrian Hari Ini" class="mr-2" theme="primary">
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center">
                        <h6>
                            Antrian Lt 1
                        </h6>
                        <h4>
                            {{ $antrians->where('method', '!=', 'Bridging')->where('method', 'Offline')->where('lantaipendaftaran', 1)->count() ?? '0' }}
                        </h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h6>
                            Antrian Lt 2
                        </h6>
                        <h4>
                            {{ $antrians->where('method', '!=', 'Bridging')->where('method', 'Offline')->where('lantaipendaftaran', 2)->count() ?? '0' }}
                        </h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h6>
                            Antrian Online
                        </h6>
                        <h4>
                            {{ $antrians->where('method', '!=', 'Bridging')->where('method', '!=', 'Offline')->count() ?? '0' }}
                        </h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h6>
                            Antrian Total
                        </h6>
                        <h4>
                            {{ $antrians->where('method', '!=', 'Bridging')->count() ?? '0' }}
                        </h4>
                    </div>
                </div>
            </div>
            <x-slot name="footerSlot">
                <a href="{{ route('anjungan.mandiri') }}">
                    <x-adminlte-button icon="fas fa-arrow-left" class="withLoad" theme="danger" label="Kembali" />
                </a>
            </x-slot>
        </x-adminlte-card>
        <x-adminlte-card body-class="p-1" class="mr-2">
            <video width="100%" height="100%" controls autoplay muted loop>
                <source src="{{ asset('bpjs/Video Sosialisasi Program Rehab 30sec.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </x-adminlte-card>
    </div>
    <div class="col-md-7">
        <div class="row">
            <div id="jadwalCarousel" class="carousel slide ml-2" data-ride="carousel" data-interval="4000"
                style="width: 100%">
                <div class="carousel-inner">
                    @foreach ($jadwals->chunk(15) as $chunkKey => $chunk)
                        <div class="carousel-item {{ $chunkKey == 0 ? 'active' : '' }}">
                            <x-adminlte-card title="Jadwal Dokter Hari Ini" theme="primary">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Poliklinik</th>
                                            <th>Dokter</th>
                                            <th>Jam Praktek</th>
                                            <th>Kuota</th>
                                            <th>Antrian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($chunk as $item)
                                            <tr class="{{ $item->libur ? 'table-danger' : null }}">
                                                <td>{{ strtoupper($item->namasubspesialis) }}</td>
                                                <td>{{ $item->namadokter }}</td>
                                                <td>{{ $item->jadwal }}</td>
                                                <td>{{ $item->kapasitaspasien }}</td>
                                                <td></td> <!-- Tempat untuk data antrian jika ada -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                * Jadwal Dokter berwarna merah menandakan jadwal libur / kuota sudah penuh
                            </x-adminlte-card>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#jadwalCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#jadwalCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>
