<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSumberDana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sumber_dana', function (Blueprint $table) {
            $table->id('id_rekening');
            $table->foreignId('id_perusahaan')->constrained('perusahaan')->onDelete('cascade');
            $table->string('no_rekening', 50);
            $table->decimal('saldo', 15, 2);
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
        Schema::dropIfExists('sumber_dana');
    }
}
