<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        {{-- <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}"> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

        @if (config('adminlte.google_fonts.allowed', true))
            <link rel="stylesheet"
                href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        @endif
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

    {{-- Extra Configured Plugins Stylesheets --}}
    @include('adminlte::plugins', ['type' => 'css'])

    {{-- Livewire Styles --}}
    @if (config('adminlte.livewire'))
        @if (intval(app()->version()) >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- Favicon --}}
    @if (config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('rswaled.png') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    {{-- Extra Configured Plugins Scripts --}}
    @include('adminlte::plugins', ['type' => 'js'])

    {{-- Livewire Script --}}
    @if (config('adminlte.livewire'))
        @if (intval(app()->version()) >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

    @include('vendor.adminlte.modal.modal_header')

</body>

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('.btn-cek-bpjs-tanpa-daftar').on('click', function() {
        var cek_nik = document.getElementById('cek_nik').value;
        var cek_nomorkartu = document.getElementById('cek_nomorkartu').value;
        var cekStatusBPJS = "{{ route('cek-status-bpjs.tanpa-daftar') }}";
        var urlDaftarPasienBaru = "{{ route('pasien-baru.create') }}";
        Swal.fire({
            title: "CEK STATUS BPJS?",
            text: "silahkan pilih tombol cek status!",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Cek Status!",
            cancelButtonText: "Batal!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.LoadingOverlay("show");
                $.ajax({
                    type: 'GET',
                    url: cekStatusBPJS,
                    dataType: 'json',
                    data: {
                        cek_nomorkartu: cek_nomorkartu,
                        cek_nik: cek_nik,
                    },
                    success: function(data) {
                        console.log(data)
                        $.LoadingOverlay("hide");
                        if (data.code == 200) {
                            const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: "btn btn-success m-2",
                                    cancelButton: "btn btn-danger m-2"
                                },
                                buttonsStyling: false
                            });
                            swalWithBootstrapButtons.fire({
                                title: "Success!",
                                text: data.pasien + '\n ( NIK: ' + data.nik +
                                    ' ) \n' + data.keterangan + ' ' + '( JENIS : ' +
                                    data
                                    .jenisPeserta + ' - KELAS: ' + data.kelas + ')',
                                icon: "success",
                                padding: "3em",
                                showCancelButton: true,
                                confirmButtonText: "Daftar Pasien Baru!",
                                cancelButtonText: "Tutup!",
                                reverseButtons: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        type: 'GET',
                                        url: urlDaftarPasienBaru,
                                        dataType: 'json',
                                        data: {
                                            NoKartu: data.nomorkartu,
                                            Nik: data.nik,
                                            Nama: data.pasien,
                                        },
                                        success: function(data) {
                                            console.info(data.code);
                                            var redirectUrl =
                                                '/new_page'; // Ganti dengan URL tujuan Anda
                                            redirectUrl += '?NoKartu=' +
                                                requestData
                                                .NoKartu; // Tambahkan parameter pertama
                                            redirectUrl += '&Nik=' +
                                                requestData
                                                .Nik; // Tambahkan parameter kedua

                                            // Redirect dengan parameter
                                            window.location.href =
                                                redirectUrl;
                                        },
                                    });

                                } else if (
                                    /* Read more about handling dismissals below */
                                    result.dismiss === Swal.DismissReason.cancel

                                ) {
                                    location.reload();
                                    document.getElementById('nomorkartu').value =
                                        '';
                                    document.getElementById('nik').value = '';
                                    $('#modalCekBpjs').modal('hide');
                                }
                            });
                            // alert lama
                            // Swal.fire({
                            //     title: "Success!",
                            //     text: data.pasien + '\n ( NIK: ' + data.nik +
                            //         ' ) \n' + data.keterangan + ' ' + '( JENIS : ' +
                            //         data
                            //         .jenisPeserta + ' - KELAS: ' + data.kelas + ')',
                            //     icon: "success",
                            //     // confirmButtonText: "oke!",
                            //     showCancelButton: true,
                            //     confirmButtonText: "Daftar Pasien Baru!",
                            //     cancelButtonText: "Tutup!",
                            // }).then((result) => {
                            //     if (result.isConfirmed) {
                            //         location.reload();
                            //         document.getElementById('nomorkartu').value =
                            //             '';
                            //         document.getElementById('nik').value = '';
                            //         $('#modalCekBpjs').modal('hide');
                            //     }
                            // });

                        } else {
                            Swal.fire({
                                title: "INFO!",
                                text: data.keterangan + ' ' + '( KODE : ' + data
                                    .jenisPeserta + ')',
                                icon: "info",
                                confirmButtonText: "oke!",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                            $.LoadingOverlay("hide");
                        }
                    },
                });
            }
        });
    });

    function batalPilih() {
        $(".riwayat-kunjungan").remove();
        $('#modalCekKunjungan').modal('hide');
        location.reload();
    }

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.cekKunjunganPoli').click(function(e) {
            $('#modalCekKunjunganPoli').modal('toggle');
        });

        $('.btn-cekKunjungan').click(function(e) {
            $('#modalCekKunjunganPoli').modal('hide');
            $('#modalCekKunjungan').modal('toggle');
            var rm = $('#no_rm').val();
            if (rm) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('kunjungan-pasien.get') }}?rm=" + rm,
                    dataType: 'JSON',
                    success: function(data) {
                        $.each(data.semua_kunjungan, function(index, riwayat) {
                            var row = "<tr class='riwayat-kunjungan'><td>" + riwayat
                                .kode_kunjungan + "</td><td>" + riwayat.no_rm +
                                "</td><td>" + riwayat.pasien
                                .nama_px + "</td><td>" + riwayat.unit.nama_unit +
                                "</td><td>" + riwayat.status.status_kunjungan +
                                "</td><td>" +
                                riwayat.tgl_masuk + "</td><td>" + (riwayat
                                    .tgl_keluar == null ? 'Belum Pulang' : riwayat
                                    .tgl_keluar) +
                                "</td><td> <a href='{{ route('kunjungan-poli.ppri') }}?kode=" +
                                riwayat.kode_kunjungan +
                                "' class='btn btn-sm btn-primary' style='text-decoration: none;'>Daftar</a>"
                            "</td></tr>";
                            $('.semuaKunjungan tbody').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error appropriately
                    }
                });
            }

        });
    });
</script>

</html>
