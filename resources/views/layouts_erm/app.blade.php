<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERM-RANAP</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('style-erm/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('style-erm/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/dist/css/adminlte.min.css') }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> --}}
</head>

{{-- <body class="hold-transition sidebar-mini"> --}}

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="col-12">

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="#" class="nav-link">DASHBOARD ERM RAWAT INAP</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">PENGGUNA : {{ strtoupper(Auth::user()->username) }}</a>
                        </li>
                        <li class="nav-item">
                            {{-- <a href="{{route('kunjunganranap')}}" class="nav-link">KEMBALI</a> --}}
                            <a href="{{route('resume-pemulangan.vbeta.list-pasien-ranap')}}" class="nav-link">KEMBALI</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <div class="content-wrapper">
            <div class="content-header"></div>
            <!-- Main content -->
            <div class="content">
                <div class="col-12">
                    @yield('content')
                </div>
            </div>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <script src="{{ asset('style-erm/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
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
    <script src="{{ asset('style-erm/dist/js/adminlte.min.js') }}"></script>
       <!-- Select2 JS -->
       {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> --}}

    @yield('scripts')
    <script>
        $(function() {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
        
    </script>
    
</body>

</html>
