<?php

use App\User;
use App\Motivo_retiro;
use App\Facilitador_temp;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        App\User::create([ //       1
            'name'      => 'ADMIN',
            'email'     => 'admin@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V1',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);



        App\User::create([//RCE     2
            'name'      => 'Control de Estudio',
            'email'     => 'rce@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V2',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([ // estudiante 3
            'name'      => 'Jose Medina',
            'email'     => 'jmpumero@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V20959966',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([ //estudiante     4
            'name'      => 'Jordan H',
            'email'     => 'jh@gmail.com',
            'prioridad' => 'media',
            'ci'  =>'V1423456',
            'status' => true,
            'sexo' =>'mujer',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([ //Rp 5
            'name'      => 'Responsable de Personal A.',
            'email'     => 'rp1@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V123456789',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);



        App\User::create([ //supervisor 6
            'name'      => 'A. Supervisor 1',
            'email'     => 'sp1@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V125678912',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([ //supervisor 7
            'name'      => 'A. Supervisor 2',
            'email'     => 'sp2@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V12567912',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        /** estudiantes*/


        App\User::create([ //proveedor  8
            'name'      => 'PROVEEDOR Open E.',
            'email'     => 'pro@gmail.com',
            'ci'  =>'V102',
            'status' => true,
            'password'     => bcrypt('123'),

        ]);

            /** facilitadores*/
        App\User::create([//    9
            'name'      => 'Desire Delgado',
            'email'     => 'desire@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V123',
            'status' => true,
            'sexo' =>'mujer',
            'password'     => bcrypt('123'),

        ]);


        App\User::create([  //10
            'name'      => 'Mirella Herrera',
            'email'     => 'mirella@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V1234',
            'status' => true,
            'sexo' =>'mujer',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([//    11
            'name'      => 'Pedro Perez',
            'email'     => 'pedro@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V12345',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([//    12
            'name'      => 'Pedro Perez',
            'email'     => 'pedroperez@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V12325456',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([ // estudiante 13
            'name'      => 'Maura Pumero',
            'email'     => 'mpumero@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V4467336',
            'status' => true,
            'sexo' =>'mujer',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([ // estudiante 14
            'name'      => 'Noel Galindo',
            'email'     => 'ng@gmail.com',
            'prioridad' => 'media',
            'ci'  =>'V5555555',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);


        App\User::create([ // estudiante 15
            'name'      => 'Ismael Salinas',
            'email'     => 'is@gmail.com',
            'prioridad' => 'baja',
            'ci'  =>'V22222222',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);


        /* Motivos*/
        Motivo_retiro::create([
            'motivo'      => 'Medico',
        ]);
        Motivo_retiro::create([
            'motivo'      => 'Permiso',
        ]);
        Motivo_retiro::create([
            'motivo'      => 'Vacaciones',
        ]);

       /* Facilitador_temp::create([
            'facilitador_id'      => 10,
            'resumen'      => 'Especialista en Diseño digital, Ing. del Software,etc',
            'facilitador_empresa_id'=> 1,
        ]);

        Facilitador_temp::create([
            'facilitador_id'      => 11,
            'resumen'      => 'Sistema Operativo,Diseño curricular',
            'facilitador_empresa_id'=> 1,

        ]);

        Facilitador_temp::create([
            'facilitador_id'      => 12,
            'resumen'      => 'Sistema Operativo,Calculo computacional',
            'facilitador_empresa_id'=> 1,

        ]);

        Facilitador_temp::create([
            'facilitador_id'      => 13,
            'resumen'      => 'Algebra lineal,etc',
            'facilitador_empresa_id'=> 1,

        ]);*/


        //factory(User::class,100)->create();
    }
}
