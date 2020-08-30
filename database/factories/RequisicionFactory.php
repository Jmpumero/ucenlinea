<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Requisicion;
use Faker\Generator as Faker;

$factory->define(Requisicion::class, function (Faker $faker) {
    return [

          /*'creador'  =>1, //'user_id' pendiente
            =>$faker->unsignedBigInteger('empresa_id'),
            =>$faker->string('nombre', 50),
            =>$faker->string('modalida', 50),//definir por gestor de contenido
            =>$faker->enum('audiencia', ['todo publico', 'zoomer','boomer','etc'])->nullable()->default('todo publico'),//definir por gestor de contenido
            =>$faker->enum('t_formacion', ['interna', 'externa'])->nullable()->default('interna'),//definir por gestor de contenido*/
    ];
});
