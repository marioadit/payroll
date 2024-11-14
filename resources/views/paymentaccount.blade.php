@extends('layouts.main')
@section('title', 'Manage Payment Accounts')

@section('content')
<!-- Form to Add New Payment Account -->
<div class="form-container">
    <h4>Add Payment Account</h4>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="accountName">Account Name</label>
            <input type="text" id="accountName" class="form-control" value="John Doe" />
        </div>
        <div class="col-md-3">
            <label for="accountNumber">Account Number</label>
            <input type="text" id="accountNumber" class="form-control" value="123456789" />
        </div>
        <div class="col-md-3">
            <label for="bankName">Bank Name</label>
            <div class="btn-group w-100">
                <select id="bankName" class="form-select btn btn-primary dropdown-toggle">
                    <option value="Bank A" selected>Bank A</option>
                    <option value="Bank B">Bank B</option>
                    <option value="Bank C">Bank C</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <label for="accountType">Account Type</label>
            <!-- Account Type dropdown now has button style -->
            <div class="btn-group w-100">
                <select id="accountType" class="form-select btn btn-primary dropdown-toggle">
                    <option value="">Select Type</option>
                    <option value="Checking" selected>Checking</option>
                    <option value="Savings">Savings</option>
                    <option value="Credit">Credit</option>
                </select>
            </div>
        </div>
        
        
        
    </div>
    <button class="btn btn-primary">Add Account</button>
</div>

<hr />

<!-- Table for Payment Accounts -->
<h4>Payment Accounts</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Account ID</th>
                <th>Account Name</th>
                <th>Account Number</th>
                <th>Bank Name</th>
                <th>Account Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Jean Paul</td>
                <td>123456789</td>
                <td>Bank A</td>
                <td>Checking</td>
                <td>
                    <button class="btn btn-sm btn-warning me-2">Edit</button>
                    <button class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Afnan</td>
                <td>987654321</td>
                <td>Bank B</td>
                <td>Savings</td>
                <td>
                    <button class="btn btn-sm btn-warning me-2">Edit</button>
                    <button class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Azzaro</td>
                <td>111223344</td>
                <td>Bank C</td>
                <td>Credit</td>
                <td>
                    <button class="btn btn-sm btn-warning me-2">Edit</button>
                    <button class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
