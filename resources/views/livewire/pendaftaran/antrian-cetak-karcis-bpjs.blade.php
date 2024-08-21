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
        <b>Antrian & E-SEP BPJS</b><br>
        <b style="font-size: 40px">{{ $antrian->nomorantrean }}</b><br>
        <p style="line-height:13px;font-size: 11px;">
            @switch($antrian->jeniskunjungan)
                @case(1)
                    RUJUKAN FKTP
                @break

                @case(2)
                    RUJUKAN INTERNAL
                @break

                @case(3)
                    SURAT KONTROL
                @break

                @case(4)
                    RUJUKAN ANTAR RS
                @break

                @default
            @endswitch
            <br>
            <b>{{ $antrian->nomorreferensi ?? '-' }}</b><br>
            NOMOR SEP <br>
            <b>{{ $antrian->nomorsep ?? '-' }}</b><br>

        </p>
        <p style="line-height:13px;font-size: 9px;">
            {{ $antrian->nama }} <br>
            {{ $antrian->nomorkartu }} <br>
            {{ \Carbon\Carbon::parse($antrian->tanggalperiksa)->format('d F Y') }} <br>
            POLIKLINIK {{ strtoupper($antrian->namapoli) }} <br>
            {{ $antrian->namadokter }} <br>
            {{ $antrian->jampraktek }} <br>
        </p>
        <p style="line-height:13px;font-size: 11px;">
            <b>Lokasi Poliklinik Lantai {{ $antrian->lokasi }}</b><br>
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
