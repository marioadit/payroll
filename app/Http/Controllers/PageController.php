<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if ($admin && $request->password === $admin->password) { // Plain text comparison
            Auth::guard('admin')->login($admin);
            \Log::info('Login successful for user: ' . $request->username);
            return redirect()->route('home');
        } else {
            \Log::warning('Login failed for user: ' . $request->username);
        }

        return back()->withErrors(['username' => 'Invalid username or password']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }

    public function transaction()
    {
        return view('transaction');
    }

    public function logbook()
    {
        return view('logbook');
    }

    public function divisi()
    {
        return view('divisi');
    }
}
