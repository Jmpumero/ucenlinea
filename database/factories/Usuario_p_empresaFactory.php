<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Usuario_p_empresa;
use Faker\Generator as Faker;

$factory->define(Usuario_p_empresa::class, function (Faker $faker) {
    return [
        'user_id' => $faker->unique()->numberBetween($min = 1, $max = 100),
        'empresa_id' =>$faker->numberBetween($min = 1, $max = 30),

    ];
});
