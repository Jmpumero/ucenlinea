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
            $table->integer('num_retiro')->unsigned()->default(0);
            $table->integer('num_abandono')->unsigned()->default(0);

            $table->foreign('user_id')
                ->references('id')
                ->on('users');


            $table->foreign('formacion_id')
                ->references('id')
                ->on('formacions');
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
