<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
    </title>
    <style>
        .unicode {
            font-family: "DejaVu Sans";
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .table {
            margin-bottom: 0px;
            border-collapse: collapse;
            width: 100%;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .table thead th {
            vertical-align: bottom;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid black !important;
            padding: 0;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black !important;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }
    </style>
    @yield('css')
    @push('css')
</head>

<body style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">
    @include('simrs.ranap.pdf_kop_surat')
    @yield('content')
</body>

</html>