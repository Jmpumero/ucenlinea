<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisicionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creador'); //'user_id' pendiente
            $table->unsignedBigInteger('empresa_id');
            $table->string('nombre', 50);
            $table->string('modalida', 50);//definir por gestor de contenido
            $table->enum('audiencia', ['todo publico', 'zoomer','boomer','etc'])->nullable()->default(['todo publico']);//definir por gestor de contenido
            $table->enum('t_formacion', ['interna', 'externa'])->nullable()->default(['interna', 'externa']);//definir por gestor de contenido
            $table->foreign('creador')->references('id')->on('users');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->timestamps();
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisicions');
    }
}
