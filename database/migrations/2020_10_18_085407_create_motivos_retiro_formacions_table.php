<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotivosRetiroFormacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motivos_retiro_formacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mrf_postulado_id');
            $table->unsignedBigInteger('mrf_formacion_id');
            $table->unsignedBigInteger('mrf_motivo_id');
            $table->timestamps();
            $table->foreign('mrf_postulado_id')->references('id')->on('users');
            $table->foreign('mrf_formacion_id')->references('id')->on('formacions');
            $table->foreign('mrf_motivo_id')->references('id')->on('motivo_retiros');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('motivos_retiro_formacions');
    }
}
