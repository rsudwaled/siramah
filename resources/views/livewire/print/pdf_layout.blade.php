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

        .center {
            margin-left: auto;
            margin-right: auto;
            margin-top: auto;
            margin-bottom: auto;
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

        .table-xs th,
        .table-xs td {
            padding: 1px;
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

        .table-borderless {
            border: 0px solid black !important;
            padding: 0;
        }

        .table-borderless th,
        .table-borderless td {
            border: 0px solid black !important;
            padding: 0;
        }

        pre {
            margin: 0;
            font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif;
        }

        @page {
            margin: 20px;
        }

        /* body {
            margin: 20px;
        } */
        .page-break {
            page-break-after: always;
        }
    </style>
    @yield('css')
    @push('css')
    </head>

    <body style="font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif">
        @yield('content')
    </body>

    </html>
