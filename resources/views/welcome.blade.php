@extends('layouts/main')

@section('content')

<h2>Monthly Payment Status</h2>

<div class="row">
    <div class="col-md-6">
        <p>Transaction Summary</p>
        <ul>
            <li>Successful: 8</li>
            <li>Failed: 3</li>
        </ul>
    </div>
    <div class="col-md-6">
        <h3>Total Payment Sum</h3>
        <form>
            <label for="month">Select Month:</label>
            <input type="text" id="month" class="form-control" placeholder="November 2024">
            <p>Total Payment for November 2024: Rp0,00</p>
        </form>
    </div>
</div>

<div class="mt-4">
    <h3>Unpaid Workers</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Worker ID</th>
                <th>Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>101</td>
                <td>John Doe</td>
                <td><span class="status-badge status-failed">Failed</span></td>
            </tr>
            <tr>
                <td>102</td>
                <td>Jane Smith</td>
                <td><span class="status-badge status-failed">Failed</span></td>
            </tr>
            <tr>
                <td>103</td>
                <td>Bob Johnson</td>
                <td><span class="status-badge status-failed">Failed</span></td>
            </tr>
        </tbody>
    </table>
</div>
    @endsection
