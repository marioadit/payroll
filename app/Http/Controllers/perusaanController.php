<?php

namespace App\Http\Controllers;

use App\Models\perusahaan;
use Illuminate\Http\Request;

class perusaanController extends Controller
{
    public function index()
    {
        $perusahaan = perusahaan::all();
        return view('crudperusahaan', ['perusahaan' => $perusahaan]);
    }

    public function addPerusahaan(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        // Tambah data ke database
        perusahaan::create($validatedData);

        // Redirect atau kirim response
        return redirect()->route('crudperusahaan')->with('success', 'Perusahaan berhasil ditambahkan!');
    }

    public function editPerusahaan(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        // Cari perusahaan berdasarkan id dan update
        $perusahaan = perusahaan::findOrFail($id);
        $perusahaan->update($validatedData);

        return redirect()->route('crudperusahaan')->with('success', 'Perusahaan berhasil diupdate!');
    }


    public function deletePerusahaan($id)
    {
        // Cari perusahaan berdasarkan id dan hapus
        $perusahaan = perusahaan::findOrFail($id);
        $perusahaan->delete();

        return redirect()->route('crudperusahaan')->with('success', 'Perusahaan berhasil dihapus!');
    }
}
