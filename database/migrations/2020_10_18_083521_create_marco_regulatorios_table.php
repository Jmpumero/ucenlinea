<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcoRegulatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marco_regulatorios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mr_usuario_id');
            $table->string('mr_nombre', 255);
            $table->string('mr_nombre_rol', 255);
            $table->string('mr_ruta', 255);
            $table->string('mr_url', 255);
            $table->enum('mr_rol', ['Admin','Responsable de Personal','Supervisor','Responsable de Control de Estudio','Facilitador','Proveedor','Estudiante','Responsable de Contenido','Responsable Administrativo','Responsable Academico']);

            $table->foreign('mr_usuario_id')->references('id')->on('users');

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
        Schema::dropIfExists('marco_regulatorios');
    }
}
