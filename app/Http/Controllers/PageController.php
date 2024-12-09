<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\admin;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function showLoginForm()
    {
        return view('login'); // Ensure the view exists in resources/views/admin/login.blade.php
    }

    public function login(Request $request)
    {
        // Validate the login data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to log the admin in
        if (Auth::guard('admin')->attempt($request->only('username', 'password'))) {
            // Redirect to admin dashboard after successful login
            return redirect()->route('home');
        }

        // Return with an error message if login fails
        return back()->withErrors(['username' => 'Invalid username or password']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }

    // public function pa()
    // {
    //     return view('paymentaccount');
    // }

    // public function worker()
    // {
    //     return view('workerdata');
    // }

    public function transaction()
    {
        return view('transaction');
    }

    public function logbook()
    {
        return view('logbook');
    }

    // public function admin()
    // {
    //     return view('admin');
    // }

    // public function crudper()
    // {
    //     return view('crudperusahaan');
    // }

    public function divisi()
    {
        return view('divisi');
    }
}
