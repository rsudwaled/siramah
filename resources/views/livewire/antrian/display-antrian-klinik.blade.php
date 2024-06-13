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
                            <h4>Informasi Antrian Poliklinik</h4>
                            <h6>Gedung Rawat Jalan RSUD Waled</h6>
                        </div>
                    </div>
                </div>
            </header>
        </div>
    </div>
    <div class="col-md-12">
        <div wire:poll.2s='updateAntrian'>Panggilan {{ $antrianpanggil->nama ?? '-' }}</div>
        <div wire:ignore id="cardCarousel" class="carousel slide p-2" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($polikliniks->chunk(4) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($chunk as $item)
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-header bg-blue">
                                            <div class="text-center">
                                                <b>Antrian Dipanggil</b>
                                                <h5>{{ $item->namasubspesialis }}</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="text-center">
                                                <h1>
                                                    <span id="poliklinik">
                                                        {{ $antrians->where('method', '!=', 'Offline')->where('taskid', 4)->sortByDesc('updated_at')->where('kodepoli', $item->kodesubspesialis)->first()->nomorantrean ?? '-' }}
                                                    </span>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header bg-primary">
                                            <b class="card-title">Antrian {{ $item->namasubspesialis }}</b>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-sm" id="tabledokter">
                                                <tbody>
                                                    @forelse ($antrians->where('method', '!=', 'Offline')->where('kodepoli', $item->kodesubspesialis) as $item)
                                                        <tr>
                                                            <th>{{ $item->nomorantrean }}</th>
                                                            <th>{{ $item->nama }}</th>
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#cardCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#cardCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <audio id="myAudio" autoplay>
        <source src="{{ asset('rekaman/Airport_Bell.mp3') }}" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('panggil-antrian', (event) => {
                console.log("{{ $antrianpanggil->angkaantrean ?? '1' }}");
                panggilpoliklinik("{{ $antrianpanggil->angkaantrean ?? 1 }}", "A",
                    "{{ $antrianpanggil->angkaantrean ?? 'ANA' }}");
            });
        });
    </script>
    <script>
        setInterval(function() {
            $('#myAudio').trigger('play');
        }, 1000 * 3);
    </script>
</div>
