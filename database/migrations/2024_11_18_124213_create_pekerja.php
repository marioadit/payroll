<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePekerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pekerja', function (Blueprint $table) {
            $table->id('id_pekerja');
            $table->foreignId('id_divisi')->constrained('divisi')->onDelete('cascade');
            $table->string('nama_pekerja', 255);
            $table->string('nama_bank', 10);
            $table->string('rekening_pekerja', 50);
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
        Schema::dropIfExists('pekerja');
    }
}
