@extends('adminlte::master')
{{-- @inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper') --}}
@section('title', 'Display Antrian')
@section('body')
    <link rel="shortcut icon" href="{{ asset('medicio/assets/img/lmc.png') }}" />
    <div class="wrapper">
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
                                    <h6>Lokasi Lantai 3 Gedung Rawat Jalan RSUD Waled</h6>
                                </div>
                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <div class="col-md-12">
                <div id="cardCarousel" class="carousel slide p-2" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($polis->chunk(4) as $index => $chunk)
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
                                                                {{ $antrians->where('method', '!=', 'Offline')->where('taskid', 4)->where('kodepoli', $item->kodesubspesialis)->first()->nomorantrean ?? '-' }}
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
                                                            @forelse ($antrians->where('method', '!=', 'Offline')->where('taskid', 3)->where('kodepoli', $item->kodesubspesialis) as $item)
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
            {{-- @foreach ($polis as $item)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bg-blue">
                            <div class="text-center">
                                <h4>{{ $item->namasubspesialis }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <h1><span id="poliklinik">-</span></h1>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Antrian Pendaftaran</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table" id="tabledokter">
                                <tbody>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach --}}
        </div>
    </div>
    <audio id="suarabel" src="{{ asset('rekaman/Airport_Bell.mp3') }}"></audio>
    <audio id="panggilannomorantrian" src="{{ asset('rekaman/panggilannomorantrian.mp3') }}"></audio>
    <audio id="diloketpendaftaran" src="{{ asset('rekaman/diloketpendaftaran.mp3') }}"></audio>
    <audio id="dipoliklinik" src="{{ asset('rekaman/dipoliklinik.mp3') }}"></audio>
    <audio id="poliklinik" src="{{ asset('rekaman/poliklinik/008.mp3') }}"></audio>
    <audio id="difarmasi" src="{{ asset('rekaman/difarmasi.mp3') }}"></audio>
    <audio id="nomor0" src=""></audio>
    <audio id="nomor1" src=""></audio>
    <audio id="belas" src="{{ asset('rekaman/belas.mp3') }}"></audio>
    <audio id="puluh" src="{{ asset('rekaman/puluh.mp3') }}"></audio>
@stop
@section('adminlte_css')
    <style>
        body {
            background-color: yellow;
        }
    </style>
@endsection
@section('adminlte_js')
    <script type="text/javascript">
        function playVideo() {
            $('.ytp-large-play-button').click();
        }
        setInterval(function() {
            location.reload();
        }, 1000 * 60 * 3);
        setInterval(function() {
            var url = "{{ route('getdisplayAntrianPoliklinik') }}";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    $('#pendaftaran').html(data.response.pendaftaran);
                    $('#tablependaftaran').empty()
                    var x = 0;
                    $.each(data.response.pendaftaranselanjutnya, function(i, val) {
                        if (x < 5) {
                            $('#tablependaftaran').append('<tr><th>' + i + '</th><th>  ' + val +
                                ' </th></tr>');
                            x++;
                        }
                    });
                    for (let index = x; index < 5; index++) {
                        $('#tablependaftaran').append('<tr><th>-</th><th>-</th></tr>');
                    }
                    if (data.response.pendaftaranstatus == 0) {
                        var url = "{{ route('updatePanggilanDisplayAntrian') }}?kodebooking=" + data
                            .response
                            .pendaftarankodebooking;
                        $.ajax({
                            url: url,
                            type: "GET",
                            dataType: 'json',
                            success: function(res) {
                                panggilpendaftaran(data.response.pendaftaran);
                            },
                        });
                    }
                    $('#poliklinik').html(data.response.poliklinik);
                    $('#tabledokter').empty()
                    var x = 0;
                    $.each(data.response.poliklinikselanjutnya, function(i, val) {
                        if (x < 5) {
                            $('#tabledokter').append('<tr><th>' + i + '</th><th>  ' + val +
                                ' </th></tr>');
                            x++;
                        }
                    });
                    for (let index = x; index < 5; index++) {
                        $('#tabledokter').append('<tr><th>-</th><th>-</th></tr>');
                    }
                    if (data.response.poliklinikstatus == 0) {
                        var url = "{{ route('updatePanggilanDisplayAntrian') }}?kodebooking=" + data
                            .response
                            .poliklinikkodebooking;
                        $.ajax({
                            url: url,
                            type: "GET",
                            dataType: 'json',
                            success: function(res) {
                                panggilpoliklinik(data.response.poliklinik);
                            },
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }, 3000);
    </script>

    <script>
        function panggilpendaftaran(angkaantrian) {
            document.getElementById('suarabel').pause();
            document.getElementById('suarabel').currentTime = 0;
            document.getElementById('suarabel').play();
            totalwaktu = document.getElementById('suarabel').duration * 1000;
            setTimeout(function() {
                document.getElementById('panggilannomorantrian').pause();
                document.getElementById('panggilannomorantrian').currentTime = 0;
                document.getElementById('panggilannomorantrian').play();
            }, totalwaktu);
            totalwaktu = totalwaktu + 2500;
            panggilangka(angkaantrian);
            setTimeout(function() {
                document.getElementById('diloketpendaftaran').pause();
                document.getElementById('diloketpendaftaran').currentTime = 0;
                document.getElementById('diloketpendaftaran').play();
            }, totalwaktu);
        }

        function panggilpoliklinik(angkaantrian) {
            document.getElementById('suarabel').pause();
            document.getElementById('suarabel').currentTime = 0;
            document.getElementById('suarabel').play();
            totalwaktu = document.getElementById('suarabel').duration * 1000;
            setTimeout(function() {
                document.getElementById('panggilannomorantrian').pause();
                document.getElementById('panggilannomorantrian').currentTime = 0;
                document.getElementById('panggilannomorantrian').play();
            }, totalwaktu);
            totalwaktu = totalwaktu + 2500;
            panggilangka(angkaantrian);
            setTimeout(function() {
                document.getElementById('dipoliklinik').pause();
                document.getElementById('dipoliklinik').currentTime = 0;
                document.getElementById('dipoliklinik').play();
            }, totalwaktu);
        }

        function panggilfarmasi(angkaantrian) {
            document.getElementById('suarabel').pause();
            document.getElementById('suarabel').currentTime = 0;
            document.getElementById('suarabel').play();
            totalwaktu = document.getElementById('suarabel').duration * 1000;
            setTimeout(function() {
                document.getElementById('panggilannomorantrian').pause();
                document.getElementById('panggilannomorantrian').currentTime = 0;
                document.getElementById('panggilannomorantrian').play();
            }, totalwaktu);
            totalwaktu = totalwaktu + 2500;
            panggilangka(angkaantrian);
            setTimeout(function() {
                document.getElementById('difarmasi').pause();
                document.getElementById('difarmasi').currentTime = 0;
                document.getElementById('difarmasi').play();
            }, totalwaktu);
        }

        function panggilangka(angkaantrian) {
            if (angkaantrian < 10) {
                $("#nomor0").attr("src", "{{ route('landingpage') }}/rekaman/" + angkaantrian + ".mp3");
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
            } else if (angkaantrian == 10) {
                $("#nomor0").attr("src", "{{ route('landingpage') }}/rekaman/sepuluh.mp3");
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
            } else if (angkaantrian == 11) {
                $("#nomor0").attr("src", "{{ route('landingpage') }}/rekaman/sebelas.mp3");
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
            } else if (angkaantrian < 20) {
                var nomor1 = angkaantrian.charAt(1);
                $("#nomor0").attr("src", "{{ route('landingpage') }}/rekaman/" + nomor1 + ".mp3");
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
                setTimeout(function() {
                    document.getElementById('belas').pause();
                    document.getElementById('belas').currentTime = 0;
                    document.getElementById('belas').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
            } else if (angkaantrian < 100) {
                var angka = angkaantrian;
                var angka1 = angka.charAt(0);
                $("#nomor0").attr("src", "{{ route('landingpage') }}/rekaman/" + angka1 + ".mp3");
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
                setTimeout(function() {
                    document.getElementById('puluh').pause();
                    document.getElementById('puluh').currentTime = 0;
                    document.getElementById('puluh').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
                var angka2 = angka.charAt(1);
                if (angka2 != 0) {
                    $("#nomor1").attr("src", "{{ route('landingpage') }}/rekaman/" + angka2 + ".mp3");
                    setTimeout(function() {
                        document.getElementById('nomor1').pause();
                        document.getElementById('nomor1').currentTime = 0;
                        document.getElementById('nomor1').play();
                    }, totalwaktu);
                    totalwaktu = totalwaktu + 1000;
                }
            }
        }
    </script>
@stop
