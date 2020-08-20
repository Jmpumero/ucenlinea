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
            $hoy=new DateTime();
            $hoy=$hoy->format('Y-m-d');
            $table->bigIncrements('id');
            $table->string('nombre',50);
            $table->enum('status', ['matriculada','publicada','con postulados','sin postulados','finalizada']);
            $table->boolean('disponibilidad')->default(false);
            $table->boolean('t_facilitador')->default(false);
            $table->enum('tipo',['interna','externa'])->default('interna');
            $table->decimal('precio', 5, 2)->default(00000.00);
            $table->float('calificacion')->nullable()->default(0.00);
            $table->string('imagen')->nullable();
            $table->date('fecha_de_inicio')->default($hoy);
            //$table->dateTime('fecha_de_inicio')->default(new DateTime());
            $table->date('fecha_de_culminacion')->nullable();
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
