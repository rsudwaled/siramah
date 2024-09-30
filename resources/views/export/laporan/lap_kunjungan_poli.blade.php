<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kunjungan Poli</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h5>Laporan Kunjungan Poli</h5>
    <p>Periode: {{ request()->input('startdate') }} sampai {{ request()->input('enddate') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Unit</th>
                @foreach ($dates as $date)
                    <th>{{ $date->format('d') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($formattedData as $unit => $dates)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $unit }}</td>
                    @foreach ($dates as $date)
                        <td>{{ $date }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
