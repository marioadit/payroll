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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_pekerja');
            $table->date('tgl_byr');
            $table->time('wkt_byr');
            $table->decimal('nominal', 15, 2);
            $table->string('status', 50);
            $table->timestamps();
            $table->foreignId('id_jadwal')->references('id')->on('jadwal')->onDelete('cascade');
            $table->foreignId('id_pekerja')->references('id')->on('pekerja')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
