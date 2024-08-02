@extends('adminlte::master')
@section('title', 'Display Antrian Farmasi')
@section('body')
    <div class="wrapper">
        <div class="row p-1">
            <div class="col-md-12">
                <div class="card">
                    <header class="bg-green text-white p-2">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <img src="{{ asset('vendor/adminlte/dist/img/logo rsudwaled bulet.png') }}"
                                            height="80" alt="">
                                        <div class="col">
                                            <h1>RSUD Waled</h1>
                                            <h4>RSUD Waled Kabupaten Cirebon</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h2> Antrian Farmasi Lantai {{ $lantai }} </h2>

                                </div>
                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-blue">
                        <div class="text-center">
                            <h4>ANTRIAN DIPANGGIL FARMASI</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1><span id="nomorpanggil"></span></h1>
                            <h3><span id="namapanggil">-</span></h3>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4>ANTRIAN FARMASI</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table text-nowrap" id="tablefarmasi">
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
            <div class="col-md-8">
                <div class="row">
                    {{-- <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-blue">
                                <div class="text-center">
                                    <h4>TOTAL ANTRIAN RESEP</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <h1>234</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-blue">
                                <div class="text-center">
                                    <h4>TOTAL ANTRIAN RESEP</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <h1>234</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div> --}}
                    <div class="col-md-12">
                        <x-adminlte-card body-class="p-1">
                            <video width="100%" height="500px" controls autoplay muted loop>
                                <source src="{{ asset('bpjs/Video Sosialisasi Program Rehab 30sec.mp4') }}"
                                    type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </x-adminlte-card>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                {{-- <x-adminlte-card body-class="p-1 m-0">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" height="450" width="100%"
                                    src="{{ asset('kitasehat/depan.jpg') }}" alt="First slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>...</h5>
                                    <p>...</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" height="450" width="100%"
                                    src="{{ asset('kitasehat/ranap1.jpg') }}" alt="First slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>...</h5>
                                    <p>...</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" height="450" width="100%"
                                    src="{{ asset('kitasehat/ruangdokter.jpg') }}" alt="First slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>...</h5>
                                    <p>...</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" height="450" width="100%"
                                    src="{{ asset('kitasehat/pendaftaran.jpg') }}" alt="First slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>...</h5>
                                    <p>...</p>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </x-adminlte-card> --}}
            </div>
        </div>
    </div>
    <audio id="suarabel" src="{{ asset('rekaman/Airport_Bell.mp3') }}"></audio>
    <audio id="panggilannomorantrian" src="{{ asset('rekaman/panggilannomorantrian.mp3') }}"></audio>
    <audio id="diloketpendaftaran" src="{{ asset('rekaman/diloketpendaftaran.mp3') }}"></audio>
    <audio id="dipoliklinik" src="{{ asset('rekaman/dipoliklinik.mp3') }}"></audio>
    <audio id="difarmasi" src="{{ asset('rekaman/difarmasi.mp3') }}"></audio>
    <audio id="suarapoli" src=""></audio>
    <audio id="huruf" src=""></audio>
    <audio id="nomor0" src=""></audio>
    <audio id="nomor1" src=""></audio>
    <audio id="belas" src="{{ asset('rekaman/belas.mp3') }}"></audio>
    <audio id="puluh" src="{{ asset('rekaman/puluh.mp3') }}"></audio>
@stop
@section('adminlte_css')
    <style>
        body {
            background-color: green;
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
            var url = "{{ route('displaynomorfarmasi', $lantai) }}";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    $('#nomorpanggil').html(data.response.nomorsudahpanggil);
                    $('#namapanggil').html(data.response.namasudahpanggil);
                    $('#tablefarmasi').empty()
                    $.each(data.response.daftarantrian, function(i, val) {
                        var iStr = String(i);
                        $('#tablefarmasi').append('<tr><th><h4>' + iStr.slice(-3) +
                            '</h4></th><th><h4>' + val +
                            '</h4></th></tr>');
                    });
                    if (data.response.statuspanggil == 1) {
                        var url = "{{ route('panggilnomorfarmasi') }}?kodebooking=" + data.response
                            .kodepanggil;
                        $.ajax({
                            url: url,
                            type: "GET",
                            dataType: 'json',
                            success: function(res) {
                                console.log(data.response.nomorpanggil);
                                panggilfarmasi(data.response.nomorpanggil);
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
        function panggilfarmasi(angkaantrian, hurufantrian) {
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
                $("#nomor0").attr("src",
                    "{{ route('landingpage') }}{{ env('APP_ENV') === 'production' ? '/public' : null }}/rekaman/" +
                    angkaantrian + ".mp3");
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
            } else if (angkaantrian == 10) {
                $("#nomor0").attr("src",
                    "{{ route('landingpage') }}{{ env('APP_ENV') === 'production' ? '/public' : null }}/rekaman/sepuluh.mp3"
                );
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
            } else if (angkaantrian == 11) {
                $("#nomor0").attr("src",
                    "{{ route('landingpage') }}{{ env('APP_ENV') === 'production' ? '/public' : null }}/rekaman/sebelas.mp3"
                );
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
            } else if (angkaantrian < 20) {
                var nomor1 = angkaantrian.charAt(1);
                $("#nomor0").attr("src",
                    "{{ route('landingpage') }}{{ env('APP_ENV') === 'production' ? '/public' : null }}/rekaman/" +
                    nomor1 + ".mp3");
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
                $("#nomor0").attr("src",
                    "{{ route('landingpage') }}{{ env('APP_ENV') === 'production' ? '/public' : null }}/rekaman/" +
                    angka1 + ".mp3");
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
                    $("#nomor1").attr("src",
                        "{{ route('landingpage') }}{{ env('APP_ENV') === 'production' ? '/public' : null }}/rekaman/" +
                        angka2 + ".mp3");
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
