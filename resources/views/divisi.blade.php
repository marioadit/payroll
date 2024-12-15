@extends('layouts.main')
@section('title', 'Division Management')

@section('content')

<!-- Button to trigger registration modal -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addDivisiModal">
    Register New Division
</button>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Division Data Table -->
<h4>Division List</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Division Name</th>
            <th>Company</th>
            <th>Base Salary</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($divisi as $data)
            <tr>
                <td>{{ $data->nama_divisi }}</td>
                <td>{{ $data->perusahaan->nama_perusahaan }}</td>
                <td>{{ number_format($data->gaji_pokok, 2) }}</td>
                <td>
                    <!-- Edit Button -->
                    <button
                        type="button"
                        class="btn btn-warning btn-sm"
                        data-toggle="modal"
                        data-target="#editDivisiModal{{ $data->id }}">
                        Edit
                    </button>

                    <!-- Delete Button -->
                    <form action="{{ route('deleteDivisi', $data->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editDivisiModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="editDivisiModalLabel{{ $data->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDivisiModalLabel{{ $data->id }}">Edit Division</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('updateDivisi', $data->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="editNamaDivisi{{ $data->id }}">Division Name:</label>
                                    <input
                                        type="text"
                                        id="editNamaDivisi{{ $data->id }}"
                                        name="nama_divisi"
                                        class="form-control @error('nama_divisi') is-invalid @enderror"
                                        value="{{ old('nama_divisi', $data->nama_divisi) }}"
                                        required
                                    >
                                    @error('nama_divisi')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Company Field -->
                                @if(Auth::user()->id_perusahaan)
                                    <div class="form-group">
                                        <label>Company:</label>
                                        <input type="text" class="form-control" value="{{ Auth::user()->perusahaan->nama_perusahaan }}" readonly>
                                        <input type="hidden" name="id_perusahaan" value="{{ Auth::user()->id_perusahaan }}">
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="editPerusahaanDropdown{{ $data->id }}">Company:</label>
                                        <select
                                            id="editPerusahaanDropdown{{ $data->id }}"
                                            name="id_perusahaan"
                                            class="form-control @error('id_perusahaan') is-invalid @enderror"
                                            required
                                        >
                                            @foreach ($perusahaan as $p)
                                                <option value="{{ $p->id }}" {{ $data->id_perusahaan == $p->id ? 'selected' : '' }}>
                                                    {{ $p->nama_perusahaan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_perusahaan')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="editGajiPokok{{ $data->id }}">Base Salary:</label>
                                    <input
                                        type="number"
                                        id="editGajiPokok{{ $data->id }}"
                                        name="gaji_pokok"
                                        class="form-control @error('gaji_pokok') is-invalid @enderror"
                                        value="{{ old('gaji_pokok', $data->gaji_pokok) }}"
                                        required
                                    >
                                    @error('gaji_pokok')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update Division</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <tr>
                <td colspan="4" class="text-center">No division data available.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Add Modal -->
<div class="modal fade" id="addDivisiModal" tabindex="-1" role="dialog" aria-labelledby="addDivisiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="addDivisiModalLabel">Register New Division</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form method="POST" action="{{ route('addDivisi') }}">
                    @csrf
                    <div class="form-group">
                        <label for="namaDivisi">Division Name:</label>
                        <input
                            type="text"
                            id="namaDivisi"
                            name="nama_divisi"
                            class="form-control @error('nama_divisi') is-invalid @enderror"
                            placeholder="Division Name"
                            value="{{ old('nama_divisi') }}"
                            required
                        >
                        @error('nama_divisi')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Company Field -->
                    @if(Auth::user()->id_perusahaan)
                        <div class="form-group">
                            <label>Company:</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->perusahaan->nama_perusahaan }}" readonly>
                            <input type="hidden" name="id_perusahaan" value="{{ Auth::user()->id_perusahaan }}">
                        </div>
                    @else
                        <div class="form-group">
                            <label for="perusahaanDropdown">Company:</label>
                            <select
                                id="perusahaanDropdown"
                                name="id_perusahaan"
                                class="form-control @error('id_perusahaan') is-invalid @enderror"
                                required
                            >
                                <option value="" selected disabled>Select Company</option>
                                @foreach ($perusahaan as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                            @error('id_perusahaan')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="gajiPokok">Base Salary:</label>
                        <input
                            type="number"
                            id="gajiPokok"
                            name="gaji_pokok"
                            class="form-control @error('gaji_pokok') is-invalid @enderror"
                            placeholder="Base Salary"
                            value="{{ old('gaji_pokok') }}"
                            required
                        >
                        @error('gaji_pokok')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Register Division</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
