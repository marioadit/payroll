<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogbook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
            $table->string('no_rekening', 50);
            $table->string('rekening_pekerja', 50);
            $table->string('nama_pekerja', 255);
            $table->decimal('nominal', 15, 2);
            $table->date('tgl_byr');
            $table->time('wkt_byr');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logbook');
    }
}
