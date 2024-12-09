<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function home()
    {
        $transaksi = Transaksi::with('jadwal', 'pekerja', 'sumberDana')->get();

        // Calculate the required values
        $successfulTransactions = $transaksi->where('status', 'completed')->count();
        $failedTransactions = $transaksi->where('status', 'failed')->count();
        $totalPayment = $transaksi->sum('nominal');
        
        $unpaidWorkers = $transaksi->where('status', 'failed')->map(function ($transaksi) {
            return [
                'id' => $transaksi->pekerja->id,
                'name' => $transaksi->pekerja->name,
            ];
        });

        return view('home', [
            'successfulTransactions' => $successfulTransactions,
            'failedTransactions' => $failedTransactions,
            'totalPayment' => $totalPayment,
            'unpaidWorkers' => $unpaidWorkers,
        ]);
    }
}
