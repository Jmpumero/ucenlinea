<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetiroUvcRpRcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retiro_uvc_rp_rces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rp_id');
            $table->unsignedBigInteger('postulado_id');
            $table->enum('status_solicitud', ['PROCESADA', 'NO PROCESADA'])->default('NO PROCESADA');
            $table->foreign('rp_id')->references('id')->on('users');
            $table->foreign('postulado_id')->references('id')->on('users');

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
        Schema::dropIfExists('retiro_uvc_rp_rces');
    }
}
