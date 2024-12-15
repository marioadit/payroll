<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\admin;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');
        \Log::info('Login attempt with credentials:', $credentials);

        $admin = Admin::where('username', $request->username)->first();
        if ($admin) {
            \Log::info('User found: ' . $admin->username);
            \Log::info('Hashed password in DB: ' . $admin->password); // Log the hashed password

            if (Hash::check($request->password, $admin->password)) {
                \Log::info('Password matches for user: ' . $request->username);
                Auth::guard('admin')->login($admin);
                return redirect()->route('home');
            } else {
                \Log::warning('Password mismatch for user: ' . $request->username);
                \Log::warning('Entered password: ' . $request->password); // Log the entered password
                \Log::warning('Hashed password in DB: ' . $admin->password); // Log the hashed password again for reference
            }
        } else {
            \Log::warning('No user found with username: ' . $request->username);
        }

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
