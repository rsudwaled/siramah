<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=80mm, initial-scale=1.0">
    <title>Karcis Antrian</title>
</head>

<body>
    <!-- Halaman Pertama -->
    <div class="ticket" style="text-align: center; font-family: sans-serif; page-break-after: always;">
        <img src="{{ asset('rswaled.png') }}" height="40px" alt="">
        <hr style="margin: 0">
        <b>Nomor Karcis Antrian</b><br>
        <b style="font-size: 50px">TEST</b><br>
        <hr style="margin: 0">
        <p style="line-height:13px;font-size: 8px;">
            {{ \Carbon\Carbon::now() }} <br>
            Semoga selalu diberikan kesembuhan dan kesehatan. Terimakasih.
        </p>
    </div>
    <!-- Halaman Kedua -->
    <div class="ticket" style="text-align: center; font-family: sans-serif;">
        <img src="{{ asset('rswaled.png') }}" height="40px" alt="">
        <hr style="margin: 0">
        <b>Nomor Karcis Antrian</b><br>
        <b style="font-size: 50px">TEST</b><br>
        <hr style="margin: 0">
        <p style="line-height:13px;font-size: 8px;">
            {{ \Carbon\Carbon::now() }} <br>
            Semoga selalu diberikan kesembuhan dan kesehatan. Terimakasih.
        </p>
    </div>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            window.print();
        });
        setTimeout(function() {
            var url = "{{ route('anjungan.mandiri') }}";
            window.location.href = url;
        }, 3000);
    </script>
</body>

</html>
