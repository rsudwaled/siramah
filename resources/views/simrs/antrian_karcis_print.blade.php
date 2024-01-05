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
            <b style="font-size: 20px"> Karcis Antrian</b>
        </p>
        <p>
            No. Antrian Pendaftaran : {{ $antrian->angkaantrean }} <br>
            No. Antrian Poliklinik : {{ $antrian->nomorantrean }} <br>
            Kodebooking : {{ $antrian->kodebooking }}
            {!! QrCode::size(100)->generate($antrian->kodebooking) !!} <br>
        </p>
        <p>
            {{ $request->jenispasien }}
            @if ($request->method != 'Offline')
                <b>{{ $antrian->nama }}</b> <br>
                No RM {{ $antrian->norm }} <br>
                No BPJS {{ $antrian->nomorkartu }} <br>
            @endif
        </p>
        <p>
            {{ $request->namapoli }} <br>
            {{ $request->namadokter }} <br>
            {{ $request->jampraktek }} <br>
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
