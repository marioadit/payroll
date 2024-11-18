@extends('layouts.main')

@section('title', 'Divisi Management')

@section('content')
<!-- Divisi Registration Form -->
<div class="form-container">
    <div class="row mb-2">
        <div class="col-md-6">
            <label for="divisiName">Nama Divisi</label>
            <input
                type="text"
                id="divisiName"
                name="nama_divisi"
                class="form-control"
                placeholder="Enter Divisi Name"
                required
            >
        </div>
        <div class="col-md-6">
            <label for="perusahaanDropdown">Perusahaan</label>
            <div class="btn-group w-100">
                <select id="perusahaanDropdown" name="perusahaan_id" class="form-select btn btn-primary dropdown-toggle" required>
                    <option value="" selected disabled>Pilih Perusahaan</option>
                    <!-- Example dynamic data -->
                    <option value="1">PT Maju Bersama</option>
                    <option value="2">CV Sejahtera</option>
                    <option value="3">PT Amanah</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12 d-flex">
            <button class="btn btn-primary">Register Divisi</button>
        </div>
    </div>
</div>

<hr />

<!-- Divisi Data Table -->
<h3>Divisi List</h3>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Divisi Name</th>
                <th>Perusahaan</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example static data -->
            <tr>
                <td>Finance</td>
                <td>PT Maju Bersama</td>
                <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            <tr>
                <td>HR</td>
                <td>CV Sejahtera</td>
                <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            <tr>
                <td>IT</td>
                <td>PT Amanah</td>
                <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
