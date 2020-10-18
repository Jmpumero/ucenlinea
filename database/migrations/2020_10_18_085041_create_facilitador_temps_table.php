<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitadorTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilitador_temps', function (Blueprint $table) {
            //$table->bigIncrements('id');
            $table->unsignedBigInteger('facilitador_id');
            $table->string('resumen', 255);
            $table->unsignedBigInteger('facilitador_empresa_id');
            $table->foreign('facilitador_id')->references('id')->on('users');
            $table->foreign('facilitador_empresa_id')->references('id')->on('empresas');
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
        Schema::dropIfExists('facilitador_temps');
    }
}
