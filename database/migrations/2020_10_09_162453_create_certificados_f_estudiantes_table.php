<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificadosFEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificados_f_estudiantes', function (Blueprint $table) {
            $table->string('codigo_certificado',250)->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('formacion_id');
            $table->unsignedBigInteger('empresa_res_id');//esta en verem0s
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('formacion_id')->references('id')->on('formacions');
            $table->foreign('empresa_res_id')->references('id')->on('empresas');
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
        Schema::dropIfExists('certificados_f_estudiantes');
    }
}
