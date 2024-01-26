<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJasaKeranjangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jasa_keranjang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_keranjang');
            $table->unsignedBigInteger('id_jasa');

            $table->foreign('id_keranjang')->references('id')->on('keranjang')->onDelete('cascade');
            $table->foreign('id_jasa')->references('id')->on('jasa')->onDelete('cascade');

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
        Schema::dropIfExists('jasa_keranjang');
    }
}
