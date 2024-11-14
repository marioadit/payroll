@extends('layouts.main')
@section('title', 'Admin Management')

@section('content')

<!-- Admin Registration Form -->
<div class="admin-form">
    <h4>Register New Admin</h4>
    <form method="POST" action="#">
        <div class="row">
            <!-- Left column: Name and Email -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="adminName">Name:</label>
                    <input 
                        type="text" 
                        id="adminName" 
                        name="name" 
                        class="form-control" 
                        placeholder="Name" 
                        value="John Doe" 
                        required
                    >
                </div>
                <div class="form-group mt-3">
                    <label for="adminEmail">Email:</label>
                    <input 
                        type="email" 
                        id="adminEmail" 
                        name="email" 
                        class="form-control" 
                        placeholder="Email" 
                        value="john.doe@example.com" 
                        required
                    >
                </div>
            </div>
        
            <!-- Right column: Password and Role -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="adminPassword">Password:</label>
                    <input 
                        type="password" 
                        id="adminPassword" 
                        name="password" 
                        class="form-control" 
                        placeholder="Password" 
                        required
                    >
                </div>
                <div class="form-group mt-3">
                    <label for="adminRole">Role:</label>
                    <div class="btn-group w-100">
                        <select 
                            id="adminRole" 
                            name="role" 
                            class="form-select btn btn-primary dropdown-toggle" 
                            required
                        >
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin Bank">Admin Bank</option>
                            <option value="Admin Payroll">Admin Payroll</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        

        <button type="submit" class="btn btn-primary mt-3">Register Admin</button>
    </form>
</div>

<hr />

<!-- Admin Data Table -->
<h4>Admin List</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Static admin data -->
        <tr>
            <td>Jean Paul</td>
            <td>jean.paul@example.com</td>
            <td>Admin Bank</td>
            <td>
                <button class="btn btn-warning btn-sm">Edit</button>
                <button class="btn btn-danger btn-sm">Delete</button>
            </td>
        </tr>
        <tr>
            <td>Afnan</td>
            <td>afnan@example.com</td>
            <td>Super Admin</td>
            <td>
                <button class="btn btn-warning btn-sm">Edit</button>
                <button class="btn btn-danger btn-sm">Delete</button>
            </td>
        </tr>
        <tr>
            <td>Azzaro</td>
            <td>azzaro@example.com</td>
            <td>Admin Payroll</td>
            <td>
                <button class="btn btn-warning btn-sm">Edit</button>
                <button class="btn btn-danger btn-sm">Delete</button>
            </td>
        </tr>
    </tbody>
</table>

@endsection
