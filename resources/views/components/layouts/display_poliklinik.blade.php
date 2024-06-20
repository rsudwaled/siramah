@extends('adminlte::master')
{{-- @inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper') --}}
@section('title', 'Display Antrian')
@section('body')
    <div class="wrapper">
        {{ $slot }}
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
    @livewireStyles
    <style>
        body {
            background-color: yellow;
        }
    </style>
@endsection
@section('adminlte_js')
    @livewireScripts
    <script>
        function panggilpendaftaran(angkaantrian, hurufantrian) {
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
            panggilhuruf(hurufantrian);
            panggilangka(angkaantrian);
            setTimeout(function() {
                document.getElementById('diloketpendaftaran').pause();
                document.getElementById('diloketpendaftaran').currentTime = 0;
                document.getElementById('diloketpendaftaran').play();
            }, totalwaktu);
        }

        function panggilpoliklinik(angkaantrian, hurufantrian, poliklinik) {
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
            // panggilhuruf(hurufantrian);
            panggilangka(angkaantrian);
            panggilklinik(poliklinik);
            // setTimeout(function() {
            //     document.getElementById('dipoliklinik').pause();
            //     document.getElementById('dipoliklinik').currentTime = 0;
            //     document.getElementById('dipoliklinik').play();
            // }, totalwaktu);
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

        function panggilhuruf(hurufantrian) {
            $("#huruf").attr("src",
                "{{ route('landingpage') }}{{ env('APP_ENV') === 'production' ? '/public' : null }}/rekaman/huruf/" +
                hurufantrian + ".mp3");
            setTimeout(function() {
                document.getElementById('huruf').pause();
                document.getElementById('huruf').currentTime = 0;
                document.getElementById('huruf').play();
            }, totalwaktu);
            totalwaktu = totalwaktu + 1000;
        }

        function panggilklinik(poliklinik) {
            $("#suarapoli").attr("src",
                "{{ route('landingpage') }}{{ env('APP_ENV') === 'production' ? '/public' : null }}/rekaman/poliklinik/" +
                poliklinik + ".mp3");
            setTimeout(function() {
                document.getElementById('suarapoli').pause();
                document.getElementById('suarapoli').currentTime = 0;
                document.getElementById('suarapoli').play();
            }, totalwaktu);
            totalwaktu = totalwaktu + 1000;
        }
    </script>
@stop
