<?php
namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisiController extends Controller
{
    // Menampilkan halaman daftar divisi
    public function index()
    {
        // Get the id_perusahaan of the logged-in admin
        $id_perusahaan = Auth::guard('admin')->user()->id_perusahaan;

        if ($id_perusahaan > 0) {
            // If id_perusahaan > 0, filter the results
            $divisi = Divisi::with('perusahaan')->where('id_perusahaan', $id_perusahaan)->get();
        } else {
            // If id_perusahaan is 0, select all
            $divisi = Divisi::with('perusahaan')->get();
        }

        $perusahaan = Perusahaan::all();

        return view('divisi', compact('perusahaan', 'divisi'));
    }

    // Menambah data divisi baru
    public function addDivisi(Request $request)
    {
        $validatedData = $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'nama_divisi' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        Divisi::create($validatedData);

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil ditambahkan!');
    }

    // Menampilkan form edit divisi
    public function editDivisi($id)
    {
        $divisi = Divisi::findOrFail($id);
        $perusahaan = Perusahaan::all();

        return view('editDivisi', compact('divisi', 'perusahaan'));
    }

    // Memperbarui data divisi
    public function updateDivisi(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'nama_divisi' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        $divisi = Divisi::findOrFail($id);
        $divisi->update($validatedData);

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil diperbarui!');
    }

    // Menghapus data divisi
    public function deleteDivisi($id)
    {
        $divisi = Divisi::findOrFail($id);
        $divisi->delete();

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil dihapus!');
    }
}
