@extends('layouts.main')
@section('title', 'Perusahaan Management')

@section('content')

<!-- Perusahaan Registration Form -->
<div class="perusahaan-form">
    <h4>Register New Perusahaan</h4>
    <form method="POST" action="{{ route('addPerusahaan') }}">
        @csrf
        <div class="row">
            <!-- Left column: Nama Perusahaan -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="namaPerusahaan">Nama Perusahaan:</label>
                    <input
                        type="text"
                        id="namaPerusahaan"
                        name="nama_perusahaan"
                        class="form-control @error('nama_perusahaan') is-invalid @enderror"
                        placeholder="Nama Perusahaan"
                        value="{{ old('nama_perusahaan') }}"
                        required
                    >
                    @error('nama_perusahaan')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Right column: Alamat -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="alamatPerusahaan">Alamat:</label>
                    <input
                        type="text"
                        id="alamatPerusahaan"
                        name="alamat"
                        class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Alamat"
                        value="{{ old('alamat') }}"
                        required
                    >
                    @error('alamat')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Register Perusahaan</button>
    </form>
</div>

<hr />

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Perusahaan Data Table -->
<h4>Perusahaan List</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nama Perusahaan</th>
            <th>Alamat</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Dynamic perusahaan data -->
        @forelse ($perusahaan as $perusahaan)
            <tr>
                <td>{{ $perusahaan->nama_perusahaan }}</td>
                <td>{{ $perusahaan->alamat }}</td>
                <td>
                    <!-- Edit Button -->
                    {{-- <a
                    href="{{ route('editPerusahaan', $perusahaan->id_perusahaan) }}"
                         class="btn btn-warning btn-sm">Edit</a> --}}

                    <!-- Delete Button -->
                    <form action="{{ route('deletePerusahaan', $perusahaan->id_perusahaan) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">No perusahaan data available.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
