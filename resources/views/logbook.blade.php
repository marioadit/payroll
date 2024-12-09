@extends('layouts.main')

@section('title', 'Logbook Records')

@section('content')
    <!-- Month Picker Form -->
    <form method="GET" action="{{ route('logbook') }}" class="form-inline mb-4">
        <label for="month" class="mr-2">Select Month:</label>
        <select name="month" id="month" class="form-control mr-2">
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $m == $month ? 'selected' : '' }}>
                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                </option>
            @endfor
        </select>

        <label for="year" class="mr-2">Select Year:</label>
        <select name="year" id="year" class="form-control mr-2">
            @for ($y = date('Y'); $y >= 2000; $y--) <!-- Adjust year range as needed -->
                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('logbook.export', ['month' => $month, 'year' => $year]) }}" class="btn btn-success ml-2">Export to PDF</a>
    </form>

    <!-- Logbook Records Table -->
    <table class="table table-striped">
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
            @forelse ($logbookRecords as $logbook)
                <tr>
                    <td>{{ $logbook->id }}</td>
                    <td>{{ $logbook->no_rekening }}</td>
                    <td>{{ $logbook->rekening_pekerja }}</td>
                    <td>{{ $logbook->nama_pekerja }}</td>
                    <td>{{ number_format($logbook->nominal, 2) }}</td>
                    <td>{{ $logbook->tgl_byr }}</td>
                    <td>{{ $logbook->wkt_byr }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No records found for the selected month and year.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
