<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create 'transaksi' table
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_pekerja');
            $table->unsignedBigInteger('id_payment_account');
            $table->date('tgl_byr');
            $table->time('wkt_byr');
            $table->decimal('nominal', 15, 2);
            $table->string('status', 50)->default('pending');
            $table->timestamps();

            $table->foreign('id_jadwal')->references('id')->on('jadwal')->onDelete('cascade');
            $table->foreign('id_pekerja')->references('id')->on('pekerja')->onDelete('cascade');
            $table->foreign('id_payment_account')->references('id')->on('sumber_dana')->onDelete('cascade');
        });

        // Add trigger to automatically insert into logbook when status is 'completed'
        DB::unprepared('
        CREATE TRIGGER after_transaksi_update
        AFTER UPDATE ON transaksi
        FOR EACH ROW
        BEGIN
            IF NEW.status = \'Completed\' AND OLD.status != \'Completed\' THEN
                INSERT INTO logbook (
                    id_transaksi,
                    no_rekening,
                    rekening_pekerja,
                    nama_pekerja,
                    nominal,
                    tgl_byr,
                    wkt_byr,
                    created_at,
                    updated_at
                )
                VALUES (
                    NEW.id,
                    (SELECT no_rekening FROM sumber_dana WHERE id = NEW.id_payment_account),
                    (SELECT rekening_pekerja FROM pekerja WHERE id = NEW.id_pekerja),
                    (SELECT nama_pekerja FROM pekerja WHERE id = NEW.id_pekerja),
                    NEW.nominal,
                    NEW.tgl_byr,
                    NEW.wkt_byr,
                    NOW(),
                    NOW()
                );
            END IF;
        END;
    ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop trigger
        DB::unprepared('DROP TRIGGER IF EXISTS after_transaksi_update');

        // Drop table
        Schema::dropIfExists('transaksi');
    }
}
