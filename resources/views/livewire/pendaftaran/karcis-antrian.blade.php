<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=80mm, initial-scale=1.0">
    <title>Karcis Antrian</title>
</head>

<body>
    <div class="ticket" style="font-family: sans-serif; text-align: center; font-size: 13px;">
        <img src="{{ asset('rswaled.png') }}" height="50px" alt="">
        <hr style="margin: 0">
        <b>Nomor Karcis Antrian</b> <br><br>
        <b style="font-size: 30px">{{ $antrian->nomorantrean }}</b> <br>
        {!! QrCode::size(50)->generate($antrian->kodebooking) !!} <br>
        {{ $antrian->kodebooking }} / {{ $antrian->angkaantrean }}
        @if ($antrian->method != 'Offline')
            <p style="line-height:13px;font-size: 13px;">
                <b>{{ $antrian->jenispasien === 'JKN' ? 'PASIEN BPJS' : 'PASIEN UMUM' }}</b><br>
                {{ $antrian->nama }} <br>
                No RM {{ $antrian->norm }} <br>
                No BPJS {{ $antrian->nomorkartu }} <br>
            </p>
            <p style="line-height:13px;font-size: 13px;">
                <b>NOMOR SEP</b><br>
                {{ $antrian->sep ?? 'Belum Cetak SEP' }}
            </p>
        @endif
        <p style="line-height:13px;font-size: 13px;">
            POLIKLINIK {{ $antrian->namapoli }} <br>
            {{ $antrian->namadokter }} <br>
            {{ $antrian->jampraktek }} <br>
        </p>
        <hr style="margin: 0">
        <p style="line-height:13px;font-size: 8px; margin: 0px;">
            Simpan lembar karcis antrian ini sampai pelayanan berakhir.<br>
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
