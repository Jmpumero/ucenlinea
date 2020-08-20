<?php

use Illuminate\Database\Seeder;
use App\Formacion;
class FormacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Formacion::class,10)->create();
    }
}
