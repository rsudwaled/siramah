<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=80mm, initial-scale=1.0">
    <title>Karcis Antrian</title>
</head>

<body>
    <div class="ticket">
        <img src="{{ asset('vendor/adminlte/dist/img/rswaled.png') }}" width="50px" alt="">
        <hr>
        <p>
            <b style="font-size: 25px"> Karcis Antrian</b>
        </p>
        <p>
            Nomor Antrian <br>
            {!! QrCode::size(100)->generate('asdasd') !!} <br>
            Kodebooking
        </p>
        <p>
        </p>
        <p>

        </p>
        <hr>
        <p style="line-height:12px;font-size: 10px;">
            Simpan lembar karcis antrian ini sampai pelayanan berakhir. Terimakasih. <br>
            Semoga selalu diberikan kesembuhan dan kesehatan.
        </p>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        $(document).ready(function() {
            window.print();
        });
        setTimeout(function() {
            var url = "{{ route('mesinantrian') }}";
            window.location.href = url;
        }, 3000);
    </script>
</body>

</html>
