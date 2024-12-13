<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BED MONITORING</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('style-erm/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style-erm/dist/css/adminlte.min.css') }}">
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.14.4/dist/sweetalert2.min.css
" rel="stylesheet">
</head>

<body>
    <div class="content">
        <div class="col-12 m-4">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('style-erm/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('style-erm/dist/js/adminlte.min.js') }}"></script>
    {{-- <script src="{{ asset('style-erm/dist/js/demo.js') }}"></script> --}}
    @stack('scripts')
    <script src="
            https://cdn.jsdelivr.net/npm/sweetalert2@11.14.4/dist/sweetalert2.all.min.js
            "></script>
</body>

</html>
