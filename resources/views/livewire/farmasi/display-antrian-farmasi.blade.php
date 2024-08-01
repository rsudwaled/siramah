<div class="row">
    <div class="col-md-12">
        <div class="card">
            <header class="bg-green text-white p-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" width="100"
                                    alt="">
                                <div class="col">
                                    <h1>RSUD Waled</h1>
                                    <h4>Rumah Sakit Umum Daerah Waled</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h4>Informasi Antrian Farmasi</h4>
                            <h6>Depo Farmasi Lantai 2</h6>
                        </div>
                    </div>
                </div>
            </header>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div>
                    <div wire:poll.2s='updateAntrian'>Panggilan {{ $antrianpanggil->nama ?? '-' }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-blue">
                        <div class="text-center">
                            <b>Antrian Farmasi Dipanggil</b>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            @if ($orders)
                                <h1>
                                    {{ $orders->where('panggil', 2)->first() ? substr($orders->where('panggil', 2)->sortByDesc('updated_at')->first()->kode_layanan_header, 12) : '-' }}
                                </h1>
                                <h4>{{ $orders->where('panggil', 2)->first()->pasien->nama_px ?? '-' }}</h4>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-primary">
                        <b class="card-title">Daftar Antrian Farmasi</b>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm" id="tabledokter">
                            <tbody>
                                @if ($orders)
                                    @forelse ($orders->where('panggil','!=',2) as $item)
                                        <tr>
                                            <th>{{ substr($item->kode_layanan_header, 12) }}</th>
                                            <th>{{ $item->pasien->nama_px ?? '-' }}</th>
                                        </tr>
                                    @empty
                                        <tr>
                                            <th>-</th>
                                            <th>-</th>
                                        </tr>
                                        <tr>
                                            <th>-</th>
                                            <th>-</th>
                                        </tr>
                                        <tr>
                                            <th>-</th>
                                            <th>-</th>
                                        </tr>
                                        <tr>
                                            <th>-</th>
                                            <th>-</th>
                                        </tr>
                                        <tr>
                                            <th>-</th>
                                            <th>-</th>
                                        </tr>
                                    @endforelse
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-blue">
                        <div class="text-center">
                            <b>Total Antrian Farmasi</b>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1>{{ count($orders) }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-danger">
                        <div class="text-center">
                            <b>Jumlah Antrian Belum</b>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1>{{ count($orders) }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="text-center">
                            <b>Jumlah Antrian Selesai</b>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1>{{ count($orders) }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <audio id="myAudio" autoplay>
            <source src="{{ asset('rekaman/Airport_Bell.mp3') }}" type="audio/mp3">
            Your browser does not support the audio element.
        </audio> --}}
        <script type="text/javascript">
            // function playVideo() {
            //     $('.ytp-large-play-button').click();
            // }
            setInterval(function() {
                panggilfarmasi("100");
                // location.reload();
            }, 1000 * 3);
        </script>
        {{-- panggilfarmasi("100"); --}}
    </div>
</div>
