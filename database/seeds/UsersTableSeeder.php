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
            'name'      => 'Jose Medina',
            'email'     => 'jmpumero@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V20959966',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([//RCE
            'name'      => 'Control de Estudio',
            'email'     => 'rce@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V2',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([ //estudiante
            'name'      => 'Prueba',
            'email'     => 'prueba@algo.com',
            'prioridad' => 'baja',
            'ci'  =>'V123456',
            'status' => true,
            'sexo' =>'mujer',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([ //Rp
            'name'      => 'RP1 Prueba',
            'email'     => 'rp1@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V123456789',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([ //Rp
            'name'      => 'RP2 Prueba',
            'email'     => 'rp2@gmail.com',
            'ci'  =>'V1256789',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([ //supervisor
            'name'      => 'SP1 Prueba',
            'email'     => 'sp1@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V125678912',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        /** estudiantes*/

        App\User::create([ //estudiante
            'name'      => 'estudiante1',
            'email'     => 'estudiante1@algo.com',
            'ci'  =>'V1234568901',
            'status' => true,
            'password'     => bcrypt('123'),

        ]);

        App\User::create([ //estudiante
            'name'      => 'estudiante2',
            'email'     => 'estudiante2@algo.com',
            'ci'  =>'V1234568902',
            'status' => true,
            'password'     => bcrypt('123'),

        ]);







        //factory(User::class,100)->create();
    }
}
