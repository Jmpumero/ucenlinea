<?php

use Illuminate\Database\Seeder;

use App\User_ins_formacion;
class User_ins_formacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User_ins_formacion::create([
            'user_id'      => 1,
            'formacion_id'     => 1,
            'supervisor_id'     => 2,

        ]);

        factory(User_ins_formacion::class,30)->create();
    }
}
