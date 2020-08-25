<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name'      => 'Jose',
            'apellido' => 'Medina',
            'email'     => 'jmpumero@gmail.com',
            'ci'  =>'V20959966',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);


        App\User::create([
            'name'      => 'Prueba',
            'apellido' => 'Algo',
            'email'     => 'prueba@algo.com',
            'ci'  =>'V123456',
            'status' => true,
            'sexo' =>'mujer',
            'password'     => bcrypt('123'),

        ]);



        factory(User::class,8)->create();
    }
}
