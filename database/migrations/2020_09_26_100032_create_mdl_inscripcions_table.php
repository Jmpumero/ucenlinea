<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdlInscripcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdl_inscripcions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('formacion_id');

            //$table->boolean('retiro')->default(false);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('formacion_id')->references('id')->on('formacions');
            $table->string('rol_shortname', 200)->nullable()->default('student');







            //$table->primary(['user_id', 'formacion_id'], 'mdl_inscripcions_user_id_formacion_id_primary');
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
        Schema::dropIfExists('mdl_inscripcions');
    }
}
