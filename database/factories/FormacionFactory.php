<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Formacion;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Formacion::class, function (Faker $faker) {
    return [
        'nombre'    => $faker->company,
        'status'    => $faker->randomElement($array = array ('matriculada','publicada','con postulados','sin postulados','finalizada')),
        'disponibilidad'    => $faker->boolean($chanceOfGettingTrue = 50),
        't_facilitador'   => $faker->boolean($chanceOfGettingTrue = 50),
        'tipo'  => $faker->randomElement($array = array ('interna','externa')),
        'precio'    => $faker->randomFloat($nbMaxDecimals = 8, $min = 0, $max = 1000),
        'calificacion' => $faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = 10),
        'imagen' =>$faker->imageUrl($width=200, $height=250, 'cats'),
        'requisicion_id'=>$faker->unique()->numberBetween($min = 4, $max = 15)
        //'fecha_de_inicio' =>$faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});


//$dt = $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now');
//$date = $dt->format("Y-m-d"); // 1994-09-24
