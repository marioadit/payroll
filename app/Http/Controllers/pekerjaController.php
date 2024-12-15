<?php
namespace App\Http\Controllers;

use App\Models\Pekerja;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PekerjaController extends Controller
{
    /**
     * Menampilkan daftar pekerja
     */
    public function index()
    {
        // Get the id_perusahaan of the logged-in admin
        $id_perusahaan = Auth::guard('admin')->user()->id_perusahaan;

        if ($id_perusahaan > 0) {
            // If id_perusahaan > 0, filter the results by divisi associated with the id_perusahaan
            $pekerja = Pekerja::with('divisi')->whereHas('divisi', function ($query) use ($id_perusahaan) {
                $query->where('id_perusahaan', $id_perusahaan);
            })->get();

            // Get only the divisi associated with the id_perusahaan
            $divisi = Divisi::where('id_perusahaan', $id_perusahaan)->get();
        } else {
            // If id_perusahaan is 0, select all
            $pekerja = Pekerja::with('divisi')->get();
            $divisi = Divisi::all();
        }

        return view('workerdata', compact('pekerja', 'divisi'));
    }

    /**
     * Menambah pekerja baru
     */
    public function addPekerja(Request $request)
    {
        $validatedData = $request->validate([
            'id_divisi' => 'required|exists:divisi,id',
            'nama_pekerja' => 'required|string|max:255',
            'nama_bank' => 'required|string|max:10',
            'rekening_pekerja' => 'required|string|max:50',
        ]);

        Pekerja::create($validatedData);

        return redirect()->route('workerdata')->with('success', 'Pekerja berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit pekerja
     */
    public function editPekerja($id)
    {
        $pekerja = Pekerja::findOrFail($id);

        // Get the id_perusahaan of the logged-in admin
        $id_perusahaan = Auth::guard('admin')->user()->id_perusahaan;

        if ($id_perusahaan > 0) {
            // Get only the divisi associated with the id_perusahaan
            $divisi = Divisi::where('id_perusahaan', $id_perusahaan)->get();
        } else {
            $divisi = Divisi::all();
        }

        return view('editWorker', compact('pekerja', 'divisi'));
    }

    /**
     * Memperbarui data pekerja
     */
    public function updatePekerja(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_divisi' => 'required|exists:divisi,id',
            'nama_pekerja' => 'required|string|max:255',
            'nama_bank' => 'required|string|max:10',
            'rekening_pekerja' => 'required|string|max:50',
        ]);

        $pekerja = Pekerja::findOrFail($id);
        $pekerja->update($validatedData);

        return redirect()->route('workerdata')->with('success', 'Pekerja berhasil diperbarui!');
    }

    /**
     * Menghapus data pekerja
     */
    public function deletePekerja($id)
    {
        $pekerja = Pekerja::findOrFail($id);
        $pekerja->delete();

        return redirect()->route('workerdata')->with('success', 'Pekerja berhasil dihapus!');
    }
}
