@extends('layouts.main')
@section('title', 'Perusahaan Management')

@section('content')

<!-- Perusahaan Registration Form -->
<div class="perusahaan-form">
    <h4>Register New Perusahaan</h4>
    <form method="POST" action="#">
        <div class="row">
            <!-- Left column: Nama Perusahaan -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="namaPerusahaan">Nama Perusahaan:</label>
                    <input
                        type="text"
                        id="namaPerusahaan"
                        name="nama_perusahaan"
                        class="form-control"
                        placeholder="Nama Perusahaan"
                        required
                    >
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
                        class="form-control"
                        placeholder="Alamat"
                        required
                    >
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Register Perusahaan</button>
    </form>
</div>

<hr />

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
        <!-- Static perusahaan data -->
        <tr>
            <td>PT Maju Bersama</td>
            <td>Jl. Merdeka No. 123</td>
            <td>
                <button class="btn btn-warning btn-sm">Edit</button>
                <button class="btn btn-danger btn-sm">Delete</button>
            </td>
        </tr>
        <tr>
            <td>CV Sejahtera</td>
            <td>Jl. Sudirman No. 456</td>
            <td>
                <button class="btn btn-warning btn-sm">Edit</button>
                <button class="btn btn-danger btn-sm">Delete</button>
            </td>
        </tr>
        <tr>
            <td>PT Amanah</td>
            <td>Jl. Kebon Jeruk No. 789</td>
            <td>
                <button class="btn btn-warning btn-sm">Edit</button>
                <button class="btn btn-danger btn-sm">Delete</button>
            </td>
        </tr>
    </tbody>
</table>

@endsection
