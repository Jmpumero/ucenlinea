<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
class CreateFormacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        //Schema::drop('formacions');
        //DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        Schema::create('formacions', function (Blueprint $table) {
            //$hoy=new DateTime();
            //$hoy=$hoy->format('Y-m-d');
            $table->bigIncrements('id');
            $table->string('nombre',50);
            $table->enum('status', ['matriculada','publicada','con postulados','sin postulados','finalizada']);
            $table->boolean('disponibilidad')->default(false);
            $table->boolean('t_facilitador')->default(false);
            $table->enum('tipo',['interna','externa'])->default('interna');
            $table->decimal('precio', 5, 2)->default(00000.00);
            $table->float('calificacion')->nullable()->default(0.00);
            $table->string('imagen')->nullable();

            //$table->date('fecha_de_inicio')->default($hoy);
            $table->dateTime('fecha_de_inicio')->default(Carbon::now());
            $table->dateTime('fecha_de_culminacion')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('requisicion_id')->nullable();//quitar nullable luego
            $table->foreign('requisicion_id')->references('id')->on('requisicions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('formacions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('formacions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
