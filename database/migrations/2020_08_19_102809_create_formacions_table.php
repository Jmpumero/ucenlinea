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
            $table->unsignedBigInteger('empresa_proveedora_id')->default(1);
            $table->string('nombre',50);
            $table->enum('status', ['matriculada','publicada','con postulados','sin postulados','finalizada','cerrada']);
            $table->boolean('disponibilidad')->default(false);
            $table->boolean('publicar')->default(false);
            $table->boolean('t_facilitador')->default(false);
            $table->enum('tipo',['interna','externa'])->default('interna');
            $table->decimal('precio', 7, 2)->default(000.00);
            $table->float('calificacion')->nullable()->default(0.00);
            $table->string('imagen')->default('adminlte/img/formaciones/default_formation.jpg
'        );

            $table->smallInteger('max_matricula')->default(-1);
            $table->smallInteger('actual_matricula')->default(0);
            $table->boolean('formacion_libre')->default(false);
            $table->text('f_resumen')->nullable();
            //$table->string('categoria',50); //esto deberia ser una id a otra tabla,como no se si otro modulo ltenga esa tabla lo usare asi para efecto de ejemplo
            $table->dateTime('fecha_de_inicio')->default(Carbon::now());
            $table->dateTime('fecha_de_culminacion')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('empresa_proveedora_id')->references('id')->on('empresas');
            $table->unsignedBigInteger('requisicion_id')->unique()->nullable();//quitar nullable luego
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
