<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=80mm, initial-scale=1.0">
    <title>Karcis Antrian</title>
</head>

<body>
    <div class="ticket" style="text-align: center; font-family: sans-serif">
        <img src="{{ asset('rswaled.png') }}" height="40px" alt="">
        <hr style="margin: 0">
        <b>Antrian Pendafataran</b><br>
        <b style="font-size: 50px">{{ $antrian->angkaantrean }}</b><br>
        <p style="line-height:13px;font-size: 11px;">
            <b>Lokasi Pendaftaran Lantai {{ $antrian->lantaipendaftaran }}</b> <br>
            <b>Loket {{ $antrian->jenispasien == 'JKN' ? ' BPJS' : 'UMUM' }}</b><br>
            <b>Antrian {{ $antrian->method }} {{ $antrian->jenispasien }}</b><br>
        </p>
        <p style="line-height:13px;font-size: 9px;">
            {{ \Carbon\Carbon::parse($antrian->tanggalperiksa)->format('d F Y') }} <br>
            {{ strtoupper($antrian->namapoli) }} <br>
            {{ $antrian->namadokter }} <br>
            {{ $antrian->jampraktek }} <br>
        </p>
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
