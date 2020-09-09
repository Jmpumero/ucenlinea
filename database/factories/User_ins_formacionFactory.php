<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User_ins_formacion;
use Faker\Generator as Faker;

$factory->define(User_ins_formacion::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 100),
        'formacion_id' =>$faker->numberBetween($min = 1, $max = 30),
        'supervisor_id' =>$faker->numberBetween($min = 1, $max = 100),

    ];
});
