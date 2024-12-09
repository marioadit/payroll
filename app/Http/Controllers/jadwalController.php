<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Transaksi;
use App\Models\Pekerja;
use App\Models\SumberDana;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use DB;

class JadwalController extends Controller
{
    // Display the transaction page and handle payment processing
    public function index()
    {
        // Fetch the schedule and transaction data
        $sumberdana = SumberDana::all();
        $transactions = Transaksi::with(['pekerja', 'sumberdana', 'jadwal'])->get();
        $pendingJadwal = Jadwal::where('status', 'pending')->first();
        Log::info("Transaction page loaded");

        return view('transaction', compact('transactions', 'sumberdana', 'pendingJadwal'));  // Pass pendingJadwal to the view
    }

    public function cancel($id)
    {
        Log::info("Cancel method called for Jadwal ID: $id");
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();
        Log::info("Cancelled Jadwal ID: $id");

        return redirect()->route('transaction')->with('success', 'Pending payment schedule cancelled successfully.');
    }

    public function store(Request $request)
    {
        Log::info("Store method called with request data: ", $request->all());
    
        // Validate the incoming request
        $request->validate([
            'payment_account' => 'required|exists:sumber_dana,id',  // Ensure the payment account exists
            'payment_date' => 'required|date',  // Ensure the payment date is provided
        ]);
    
        // Check if a schedule already exists for the month
        $monthYear = Carbon::parse($request->input('payment_date'))->format('Y-m');
        $existingJadwal = Jadwal::where('selected_date', 'LIKE', "$monthYear%")->where('status', 'completed')->first();
    
        if ($existingJadwal) {
            return redirect()->route('transaction')->with('error', 'A payment schedule for this month already exists.');
        }
    
        // Create a new Jadwal entry based on the request data
        $jadwal = new Jadwal();
        $jadwal->payment_account = $request->input('payment_account');  // Foreign key to sumberdana table
        $jadwal->selected_date = $request->input('payment_date');  // Payment date
        $jadwal->status = 'pending';  // Default status is 'pending'
        $jadwal->save();  // Save the jadwal entry
    
        Log::info("Created new Jadwal: ", $jadwal->toArray());
    
        // Redirect back or to a success page
        return redirect()->route('transaction')->with('success', 'Payment schedule created successfully.');
    }
    
    // Process payments based on the schedule ID
    public function processPayments($jadwalId)
    {
        Log::info("processPayments method called for Jadwal ID: $jadwalId");

        $jadwal = Jadwal::findOrFail($jadwalId);

        if (Carbon::parse($jadwal->selected_date)->isToday() || Carbon::parse($jadwal->selected_date)->isPast()) {
            Artisan::call('payments:process');

            Log::info("Artisan command payments:process called for Jadwal ID: $jadwalId");
            return response()->json(['success' => true, 'message' => 'Scheduled payments are being processed.']);
        }

        Log::info("No payments scheduled for today or already processed for Jadwal ID: $jadwalId");
        return response()->json(['success' => false, 'message' => 'No payments scheduled for today or already processed.']);
    }

    public function processPaymentsForCompany(Request $request)
    {
        $companyId = $request->input('company_id');
        Log::info("Processing payments for company ID: {$companyId}");
    
        try {
            // Adjusted query to join divisi and fetch pekerja based on id_perusahaan
            $pekerjas = Pekerja::whereHas('divisi', function ($query) use ($companyId) {
                $query->where('id_perusahaan', $companyId);
            })->with('divisi')->get();
            Log::info("Fetched pekerjas: ", $pekerjas->toArray());
    
            $sumberDana = SumberDana::where('id_perusahaan', $companyId)->first();
            Log::info("Fetched sumberDana: ", $sumberDana ? $sumberDana->toArray() : []);
    
            if ($pekerjas->isEmpty() || !$sumberDana) {
                Log::info('No pekerja or sumberdana found for this company.');
                return back()->with('error', 'No pekerja or sumberdana found for this company.');
            }
    
            // Ensure no payments have been processed for this month
            $monthYear = Carbon::now()->format('Y-m');
            $existingPayments = Transaksi::where('tgl_byr', 'LIKE', "$monthYear%")->where('status', 'completed')->exists();
    
            if ($existingPayments) {
                return back()->with('error', 'Payments have already been processed for this month.');
            }
    
            // Explicitly fetch the first jadwal and log it
            $jadwal = Jadwal::first();
            if (!$jadwal) {
                Log::error('No jadwal found in the database.');
                return back()->with('error', 'No jadwal found in the database.');
            }
    
            // Log the payment_account
            Log::info("Fetched jadwal with payment_account: {$jadwal->payment_account}");
            
            if (is_null($jadwal->payment_account)) {
                Log::error('payment_account in jadwal is null.');
                return back()->with('error', 'payment_account in jadwal is null.');
            }
    
            DB::beginTransaction(); // Start transaction for atomicity
    
            foreach ($pekerjas as $pekerja) {
                // Get the pekerja's salary (gaji_pokok)
                $nominal = $pekerja->divisi->gaji_pokok;
                Log::info("Processing payment for pekerja ID: {$pekerja->id}, nominal: {$nominal}");
    
                if ($sumberDana->saldo >= $nominal) {
                    $sumberDana->saldo -= $nominal;
                    $sumberDana->save();
    
                    Transaksi::create([
                        'id_pekerja' => $pekerja->id,
                        'id_payment_account' => $jadwal->payment_account, // Use payment_account from jadwal
                        'tgl_byr' => today(),
                        'wkt_byr' => now()->toTimeString(),
                        'nominal' => $nominal,
                        'status' => 'completed',
                        'id_jadwal' => $jadwal->id, // Use the jadwal's ID
                    ]);
    
                    Log::info("Transaction completed for pekerja ID: {$pekerja->id}");
                } else {
                    // Mark as failed if insufficient balance
                    Transaksi::create([
                        'id_pekerja' => $pekerja->id,
                        'id_payment_account' => $jadwal->payment_account, // Use payment_account from jadwal
                        'tgl_byr' => today(),
                        'wkt_byr' => now()->toTimeString(),
                        'nominal' => $nominal,
                        'status' => 'failed',
                        'id_jadwal' => $jadwal->id, // Use the jadwal's ID
                    ]);
    
                    Log::info("Transaction failed for pekerja ID: {$pekerja->id} due to insufficient balance.");
                }
            }
    
            DB::commit(); // Commit the transaction if all payments are successful
            Log::info('All payments processed successfully for the company.');
            return redirect()->route('transaction')->with('success', 'All payments processed successfully for the company.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback if any error occurs
            Log::error('An error occurred while processing payments: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while processing payments: ' . $e->getMessage());
        }
    }
}
