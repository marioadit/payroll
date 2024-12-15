<?php
namespace App\Http\Controllers;

use App\Models\SumberDana;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SumberDanaController extends Controller
{
    /**
     * Display the list of Sumber Dana and the form to add new one.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the id_perusahaan of the logged-in admin
        $id_perusahaan = Auth::guard('admin')->user()->id_perusahaan;

        if ($id_perusahaan > 0) {
            // If id_perusahaan > 0, filter the results
            $sumberDanas = SumberDana::with('perusahaan')->where('id_perusahaan', $id_perusahaan)->get();
        } else {
            // If id_perusahaan is 0, select all
            $sumberDanas = SumberDana::with('perusahaan')->get();
        }

        $perusahaanList = Perusahaan::all();

        return view('paymentaccount', compact('sumberDanas', 'perusahaanList'));
    }

    /**
     * Store a new Sumber Dana.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSumberDana(Request $request)
    {
        // Validate input
        $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'no_rekening' => 'required|string|max:50',
            'saldo' => 'required|numeric',
        ]);

        // Create new sumber dana
        SumberDana::create($request->all());

        return redirect()->route('paymentaccount')->with('success', 'Sumber Dana berhasil ditambahkan!');
    }

    /**
     * Edit a Sumber Dana.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function editSumberDana($id)
    {
        $sumberDana = SumberDana::findOrFail($id);
        $perusahaanList = Perusahaan::all();

        return view('editPaymentAccount', compact('sumberDana', 'perusahaanList'));
    }

    /**
     * Update the Sumber Dana.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSumberDana(Request $request, $id)
    {
        $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'no_rekening' => 'required|string|max:50',
            'saldo' => 'required|numeric',
        ]);

        $sumberDana = SumberDana::findOrFail($id);
        $sumberDana->update($request->all());

        return redirect()->route('paymentaccount')->with('success', 'Sumber Dana berhasil diperbarui!');
    }

    /**
     * Delete a Sumber Dana.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSumberDana($id)
    {
        $sumberDana = SumberDana::findOrFail($id);
        $sumberDana->delete();

        return redirect()->route('paymentaccount')->with('success', 'Sumber Dana berhasil dihapus!');
    }
}
