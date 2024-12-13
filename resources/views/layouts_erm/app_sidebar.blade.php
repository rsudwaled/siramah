<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PASIEN-A || ERM-RANAP </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/daterangepicker/daterangepicker.css') }}">
    @stack('style')
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('style-erm/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('style-erm/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('style-erm/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/dist/css/adminlte.min.css') }}">
</head>

<body
    class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('style-erm/dist/img/AdminLTELogo.png') }}" alt="ERM-RANAP"
                height="60" width="60">
        </div>

        <nav class="main-header navbar navbar-expand navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">DASHBOARD ERM RANAP || USER:
                        {{ strtoupper(Auth::user()->username) }}</a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index3.html" class="brand-link">
                <span class="brand-text font-weight-light">DASHBOARD ERM RANAP</span>
            </a>

            <div class="sidebar">
                <div class="form-inline mt-3">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                @include('layouts_erm.partials.navbar')
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                @yield('content_header')

            </div>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>

        </div>

        <aside class="control-sidebar control-sidebar-light">
        </aside>

    </div>

    <script src="{{ asset('style-erm/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('style-erm/dist/js/adminlte.js') }}"></script>

    <script src="{{ asset('style-erm/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <script src="{{ asset('style-erm/dist/js/pages/dashboard2.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('style-erm/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/dropzone/min/dropzone.min.js') }}"></script>
</body>
</html>
