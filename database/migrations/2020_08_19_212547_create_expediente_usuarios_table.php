<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpedienteUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expediente_usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('formacion_id');
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->enum('status',['Finalizada','Cursando','Retirada','Abandonada'])->default('Cursando');
            $table->decimal('calificacion_obtenida', 5, 3)->default(00.00);
            $table->decimal('califico_formacion', 4,2)->default(-1);
            $table->decimal('califico_facilitador', 4,2)->default(-1);
            $table->decimal('calificacion_supervisor', 4,2)->default(-1);
            $table->boolean('solicitud_retiro')->nullable()->default(false);


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('formacion_id')->references('id')->on('formacions');
            $table->foreign('supervisor_id')->references('id')->on('users');
                //->onDelete('cascade');

            $table->primary(['user_id', 'formacion_id'], 'expedientes_usuarios_formacion_id_user_id_primary');
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
        Schema::dropIfExists('expediente_usuarios');
    }
}
