<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Requisicion;
use Faker\Generator as Faker;

$factory->define(Requisicion::class, function (Faker $faker) {
    return [

            'creador'  =>$faker->numberBetween($min = 1, $max = 10), //'user_id' pendiente
            'empresa_id'=>$faker->numberBetween($min = 1, $max = 15),
            'nombre' =>$faker->word,
            //'modalidad'=>$faker->sentence,//definir por gestor de contenido
            'audiencia'=>$faker->randomElement($array = array ('todo publico', 'zoomer','boomer','etc')),
            't_formacion' =>$faker->randomElement($array = array ('interna', 'externa')),
        ];
});
