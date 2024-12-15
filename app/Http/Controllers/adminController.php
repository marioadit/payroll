<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Get the id_perusahaan of the logged-in admin
        $id_perusahaan = Auth::guard('admin')->user()->id_perusahaan;

        if ($id_perusahaan > 0) {
            // If id_perusahaan > 0, filter the results
            $admins = Admin::with('perusahaan')->where('id_perusahaan', $id_perusahaan)->get();
        } else {
            // If id_perusahaan is 0, select all
            $admins = Admin::with('perusahaan')->get();
        }

        $perusahaan = Perusahaan::all();

        return view('admin', compact('admins', 'perusahaan'));
    }

    public function addAdmin(Request $request)
    {
        $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'username' => 'required|string|max:30|unique:admin,username',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|max:20',
        ]);

        Admin::create([
            'id_perusahaan' => $request->id_perusahaan,
            'username' => $request->username,
            'password' => $request->password, // Password not hashed
            'role' => $request->role,
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin created successfully!');
    }

    public function editAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $perusahaan = Perusahaan::all();

        return view('admin.edit', compact('admin', 'perusahaan'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'username' => 'required|string|max:30|unique:admin,username,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|string|max:20',
        ]);

        $admin->update([
            'id_perusahaan' => $request->id_perusahaan,
            'username' => $request->username,
            'role' => $request->role,
            'password' => $request->password ? $request->password : $admin->password, // Password not hashed
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin updated successfully!');
    }

    public function deleteAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Admin deleted successfully!');
    }
}
