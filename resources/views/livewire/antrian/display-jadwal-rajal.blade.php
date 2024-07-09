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
    <div class="col-md-8">
        <div class="row">
            <div id="jadwalCarousel" class="carousel slide mx-3" data-ride="carousel" data-interval="4000" style="width: 100%">
                <div class="carousel-inner">
                    @foreach ($jadwals->chunk(15) as $chunkKey => $chunk)
                        <div class="carousel-item {{ $chunkKey == 0 ? 'active' : '' }}">
                            <x-adminlte-card title="Jadwal Dokter Hari Ini" class="m-2" theme="primary">
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
