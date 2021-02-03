<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetiroFormacionEstRpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retiro_formacion_est_rps', function (Blueprint $table) {
            $table->unsignedBigInteger('postulado_id');
            $table->unsignedBigInteger('formacion_retira_id');
            $table->string('descripcion', 255)->nullable()->default('');
            $table->enum('status_solicitud', ['PROCESADA', 'NO PROCESADA'])->default('NO PROCESADA');
            $table->unsignedBigInteger('empresa_del_postulado_id');
            $table->foreign('postulado_id')->references('id')->on('users');
            $table->foreign('formacion_retira_id')->references('id')->on('formacions');
            $table->foreign('empresa_del_postulado_id')->references('id')->on('empresas');
            $table->timestamps();

            $table->primary(['postulado_id', 'formacion_retira_id'], 'retiro_est_rps_formacion_retira_id_postulado_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retiro_formacion_est_rps');
    }
}
