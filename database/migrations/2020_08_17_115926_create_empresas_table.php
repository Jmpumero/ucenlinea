<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 50)->unique();
            $table->string('rif', 30)->unique();
            $table->string('direccion')->default('Av. Bolívar Norte Sede del Rectorado U.C. Valencia Edo. Carabobo.');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('empresas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        //Schema::dropIfExists('empresas');
    }
}
