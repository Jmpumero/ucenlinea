<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',50);
            $table->boolean('status')->default(false);
            $table->boolean('disponibilidad')->default(false);
            $table->string('tipo');
            $table->numeric('precio', 6, 2)->default(000000.00);
            $table->float('calificacion')->nullable()->default(0.00);
            $table->string('imagen')->nullable();
            $table->date('fecha_de_inicio')->nullable()->default(new DateTime());
            $table->date('fecha_de_culminacion')->nullable()->default(new DateTime());
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
        Schema::dropIfExists('formacions');
    }
}
