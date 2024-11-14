@extends('layouts.main')

@section('title', 'Initiate Payment')

@section('content')
<!-- Initiate Payment Form -->
<div class="form-container">
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="sourceAccount">Payment Source Account</label>
            <div class="btn-group w-100">
                <select id="sourceAccount" class="form-select btn btn-primary dropdown-toggle">
                    <option value="">Select an account</option>
                    <option value="123456789">123456789</option>
                    <option value="987654321">987654321</option>
                    <option value="112233445">112233445</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <label for="paymentDate">Payment Date</label>
            <input type="date" id="paymentDate" class="form-control" />
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-primary">Start Payment</button>
        </div>
    </div>
</div>

<hr />

<!-- Transaction History Table -->
<h3>Transaction History</h3>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Target Account</th>
                <th>Name</th>
                <th>Source Account</th>
                <th>Date</th>
                <th>Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>987654321</td>
                <td>Jean Paul</td>
                <td>123456789</td>
                <td>{{ now()->subDays(2)->format('d-m-Y') }}</td>
                <td>Rp {{ number_format(1500000, 2) }}</td>
                <td><span class="badge bg-success">Success</span></td>
            </tr>
            <tr>
                <td>2</td>
                <td>876543210</td>
                <td>Gaultier</td>
                <td>123456789</td>
                <td>{{ now()->subDay()->format('d-m-Y') }}</td>
                <td>Rp {{ number_format(1200000, 2) }}</td>
                <td><span class="badge bg-danger">Failed</span></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
