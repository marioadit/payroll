<!DOCTYPE html>
<html>
<head>
    <title>Logbook Records - {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</title>
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
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Logbook Records - {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>No Rekening Sumber Dana</th>
                <th>Rekening Pekerja</th>
                <th>Nama Pekerja</th>
                <th>Nominal</th>
                <th>Tanggal Bayar</th>
                <th>Waktu Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logbookRecords as $logbook)
                <tr>
                    <td>{{ $logbook->id }}</td>
                    <td>{{ $logbook->no_rekening }}</td>
                    <td>{{ $logbook->rekening_pekerja }}</td>
                    <td>{{ $logbook->nama_pekerja }}</td>
                    <td>{{ number_format($logbook->nominal, 2) }}</td>
                    <td>{{ $logbook->tgl_byr }}</td>
                    <td>{{ $logbook->wkt_byr }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
