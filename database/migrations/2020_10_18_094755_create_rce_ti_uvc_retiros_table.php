<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRceTiUvcRetirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rce_ti_uvc_retiros', function (Blueprint $table) {
            $table->unsignedBigInteger('rce_id');
            $table->unsignedBigInteger('retirado_id');
            $table->unsignedBigInteger('empresa_retirado_id');
            $table->foreign('rce_id')->references('id')->on('users');
            $table->foreign('retirado_id')->references('id')->on('users');
            $table->foreign('empresa_retirado_id')->references('id')->on('empresas');
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
        Schema::dropIfExists('rce_ti_uvc_retiros');
    }
}
