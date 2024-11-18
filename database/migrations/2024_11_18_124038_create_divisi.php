<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisi', function (Blueprint $table) {
            $table->id('id_divisi');
            $table->foreignId('id_perusahaan')->constrained('perusahaan')->onDelete('cascade');
            $table->string('nama_divisi', 255);
            $table->decimal('gaji_pokok', 15, 2);
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
        Schema::dropIfExists('divisi');
    }
}
