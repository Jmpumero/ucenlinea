<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInsFormacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ins_formacions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('formacion_id');
            $table->unsignedBigInteger('supervisor_id');
            $table->unsignedBigInteger('rp_id');
            //$table->boolean('retiro')->default(false);

            $table->foreign('user_id')->references('id')->on('users');
                //->onDelete('cascade');

            $table->foreign('formacion_id')->references('id')->on('formacions');
                //->onDelete('cascade');

            $table->foreign('supervisor_id')
                ->references('id')
                ->on('users');

            $table->foreign('rp_id')->references('id')->on('users');


            $table->primary(['user_id', 'formacion_id'], 'user_ins_formacions_user_id_formacion_id_primary');
            $table->timestamps();
            $table->softDeletes();//ojo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('user_ins_formacions');


    }
}
