<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    public function up()
    {
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id('id_perusahaan');
            $table->string('nama_perusahaan', 255);
            $table->timestamps();
        });

        Schema::create('divisi', function (Blueprint $table) {
            $table->id('id_divisi');
            $table->string('nama_divisi', 255);
            $table->decimal('gaji_pokok', 15, 2);
            $table->timestamps();
        });

        Schema::create('pekerja', function (Blueprint $table) {
            $table->id('id_pekerja');
            $table->foreignId('id_perusahaan')->constrained('perusahaan')->onDelete('cascade');
            $table->foreignId('id_divisi')->constrained('divisi')->onDelete('cascade');
            $table->string('nama', 255);
            $table->string('nama_bank', 255);
            $table->string('no_rekening', 50);
            $table->timestamps();
        });

        Schema::create('sumber_dana', function (Blueprint $table) {
            $table->id('id_rekening');
            $table->foreignId('id_perusahaan')->constrained('perusahaan')->onDelete('cascade');
            $table->string('no_rekening', 50);
            $table->decimal('saldo', 15, 2);
            $table->timestamps();
        });

        Schema::create('jadwal', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_rekening')->constrained('sumber_dana')->onDelete('cascade');
            $table->date('tanggal_pembayaran');
            $table->time('waktu_pembayaran');
            $table->timestamps();
        });

        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_jadwal')->constrained('jadwal')->onDelete('cascade');
            $table->foreignId('id_pekerja')->constrained('pekerja')->onDelete('cascade');
            $table->date('tgl_byr');
            $table->time('wkt_byr');
            $table->decimal('nominal', 15, 2);
            $table->string('status', 50);
            $table->timestamps();
        });

        Schema::create('logbook', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->string('bulan', 20);
            $table->string('rekening', 50);
            $table->string('rekening_pekerja', 50);
            $table->string('nama_pekerja', 255);
            $table->decimal('nominal', 15, 2);
            $table->date('tanggal_bayar');
            $table->time('waktu_pembayaran');
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->foreignId('id_perusahaan')->nullable()->constrained('perusahaan')->onDelete('set null');
            $table->string('username', 30)->unique();
            $table->string('password', 255);
            $table->string('role', 20);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin');
        Schema::dropIfExists('logbook');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('jadwal');
        Schema::dropIfExists('sumber_dana');
        Schema::dropIfExists('pekerja');
        Schema::dropIfExists('divisi');
        Schema::dropIfExists('perusahaan');
    }
}
