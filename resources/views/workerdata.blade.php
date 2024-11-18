@extends('layouts.main')

@section('title', 'Manage Worker Data')

@section('content')
<!-- Form to Add New Worker Data -->
<div class="form-container">
    <h4>Add New Worker</h4>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="workerName">Name</label>
            <input type="text" id="workerName" class="form-control" value="John Doe" />
        </div>
        <div class="col-md-3">
            <label for="workerEmail">Email</label>
            <input type="email" id="workerEmail" class="form-control" value="johndoe@example.com" />
        </div>
        <div class="col-md-3">
            <label for="workerAddress">Address</label>
            <input type="text" id="workerAddress" class="form-control" value="123 Street, City" />
        </div>
        <div class="col-md-3">
            <label for="perusahaanDropdown">Perusahaan</label>
            <div class="btn-group w-100">
                <select
                    id="perusahaanDropdown"
                    name="perusahaan_id"
                    class="form-select btn dropdown-toggle"
                    required
                >
                    <option value="" selected disabled>Pilih Perusahaan</option>
                    <!-- Example dynamic data -->
                    <option value="1">PT Maju Bersama</option>
                    <option value="2">CV Sejahtera</option>
                    <option value="3">PT Amanah</option>
                </select>
            </div>
        </div>

    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="workerPhone">Phone Number</label>
            <input type="text" id="workerPhone" class="form-control" value="123-456-7890" />
        </div>
        <div class="col-md-3">
            <label for="workerSalary">Salary</label>
            <input type="text" id="workerSalary" class="form-control" value="55000" readonly />
        </div>
        <div class="col-md-3">
            <label for="workerBankName">Bank Name</label>
            <div class="btn-group w-100">
                <select id="workerBankName" class="form-select btn dropdown-toggle">
                    <option value="Bank A" selected>Bank A</option>
                    <option value="Bank B">Bank B</option>
                    <option value="Bank C">Bank C</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <label for="workerBankAccount">Bank Account</label>
            <input type="text" id="workerBankAccount" class="form-control" value="123456789" />
        </div>
    </div>
    <button class="btn btn-primary">Add Worker</button>
</div>

<hr />

<!-- Table for Worker Data -->
<h4>Worker Data</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Position</th>
                <th>Phone Number</th>
                <th>Bank Name</th>
                <th>Bank Account</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>johndoe@example.com</td>
                <td>123 Street, City</td>
                <td>Manager</td>
                <td>123-456-7890</td>
                <td>Bank A</td>
                <td>123456789</td>
                <td>
                    <button class="btn btn-sm btn-warning me-2">Edit</button>
                    <button class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jane Smith</td>
                <td>janesmith@example.com</td>
                <td>456 Avenue, City</td>
                <td>Developer</td>
                <td>987-654-3210</td>
                <td>Bank A</td>
                <td>987654321</td>
                <td>
                    <button class="btn btn-sm btn-warning me-2">Edit</button>
                    <button class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Bob Johnson</td>
                <td>bob@example.com</td>
                <td>789 Boulevard, City</td>
                <td>Designer</td>
                <td>111-223-3445</td>
                <td>Bank A</td>
                <td>112233445</td>
                <td>
                    <button class="btn btn-sm btn-warning me-2">Edit</button>
                    <button class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
