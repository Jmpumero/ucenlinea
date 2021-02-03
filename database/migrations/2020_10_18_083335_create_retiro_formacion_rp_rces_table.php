<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetiroFormacionRpRcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retiro_formacion_rp_rces', function (Blueprint $table) {
            $table->unsignedBigInteger('rp_id');
            $table->unsignedBigInteger('postulado_id');
            $table->unsignedBigInteger('formacion_retira_id');
            $table->enum('status_solicitud', ['PROCESADA', 'NO PROCESADA'])->default('NO PROCESADA');
            $table->foreign('rp_id')->references('id')->on('users');
            $table->foreign('postulado_id')->references('id')->on('users');
            $table->foreign('formacion_retira_id')->references('id')->on('formacions');

            $table->timestamps();

            $table->primary(['postulado_id', 'formacion_retira_id'], 'retiro_rp_rces_formacion_retira_id_postulado_id_primary');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retiro_formacion_rp_rces');
    }
}
