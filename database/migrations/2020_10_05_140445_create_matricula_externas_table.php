<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculaExternasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matricula_externas', function (Blueprint $table) {

            $table->bigIncrements('id');
            //$table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('formacion_id');

            //$table->boolean('retiro')->default(false);
            //$table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('formacion_id')->references('id')->on('formacions');
            $table->string('ci',25);
            $table->string('nombre',50);
            $table->string('email',50);
            $table->string('rol_shortname', 200)->nullable()->default('Estudiante');


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
        Schema::dropIfExists('matricula_externas');
    }
}
