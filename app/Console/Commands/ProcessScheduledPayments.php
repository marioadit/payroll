<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jadwal;
use App\Models\Transaksi;
use App\Models\Pekerja;
use Carbon\Carbon;
use DB;
use Log;

class ProcessScheduledPayments extends Command
{
    protected $signature = 'payments:process';
    protected $description = 'Process scheduled payments';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        Log::info("Processing payments for datetime: $now");

        $jadwals = Jadwal::where('selected_date', '<=', $now)
                         ->where('status', 'pending')
                         ->get();
        
        Log::info("Found jadwals for processing: ", $jadwals->toArray());
        
        if ($jadwals->isEmpty()) {
            Log::info("No pending jadwals found for processing.");
            return;
        }

        foreach ($jadwals as $jadwal) {
            Log::info("Processing Jadwal ID: {$jadwal->id}");

            DB::beginTransaction();
            try {
                $pekerjas = Pekerja::whereHas('divisi', function ($query) use ($jadwal) {
                    $query->where('id_perusahaan', $jadwal->id_perusahaan);
                })->with('divisi')->get();

                Log::info("Found pekerjas for Jadwal ID {$jadwal->id}: ", $pekerjas->toArray());

                if ($pekerjas->isEmpty()) {
                    Log::info("No pekerjas found for Jadwal ID: {$jadwal->id}");
                    DB::rollBack();
                    continue;
                }

                foreach ($pekerjas as $pekerja) {
                    $nominal = $pekerja->divisi->gaji_pokok;
                    Log::info("Processing Pekerja ID: {$pekerja->id} with nominal: $nominal");

                    if ($jadwal->sumberDana->saldo >= $nominal) {
                        Log::info("Sufficient balance for Pekerja ID: {$pekerja->id}");
                        $jadwal->sumberDana->saldo -= $nominal;
                        $jadwal->sumberDana->save();

                        Transaksi::create([
                            'id_pekerja' => $pekerja->id,
                            'id_payment_account' => $jadwal->id_payment_account,
                            'tgl_byr' => today(),
                            'wkt_byr' => now()->toTimeString(),
                            'nominal' => $nominal,
                            'status' => 'completed',
                            'id_jadwal' => $jadwal->id,
                        ]);

                        Log::info("Transaction completed for Pekerja ID: {$pekerja->id}");
                    } else {
                        Log::info("Insufficient balance for Pekerja ID: {$pekerja->id}");
                        Transaksi::create([
                            'id_pekerja' => $pekerja->id,
                            'id_payment_account' => $jadwal->id_payment_account,
                            'tgl_byr' => today(),
                            'wkt_byr' => now()->toTimeString(),
                            'nominal' => $nominal,
                            'status' => 'failed',
                            'id_jadwal' => $jadwal->id,
                        ]);

                        Log::info("Transaction failed for Pekerja ID: {$pekerja->id} due to insufficient balance.");
                    }
                }

                $jadwal->status = 'completed';
                $jadwal->save();

                DB::commit();
                Log::info("Jadwal ID: {$jadwal->id} processed successfully.");
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Error processing Jadwal ID: {$jadwal->id} - " . $e->getMessage());
            }
        }

        $this->info('Scheduled payments processed successfully');
    }
}
