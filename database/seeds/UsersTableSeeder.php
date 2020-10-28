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
            'name'      => 'Responsable de Personal ',
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

        App\User::create([ //estudiante 7
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

        App\User::create([ //proveedor
            'name'      => 'PROVEEDOR',
            'email'     => 'proveedor@algo.com',
            'ci'  =>'V102',
            'status' => true,
            'password'     => bcrypt('123'),

        ]);


        App\User::create([
            'name'      => 'Desire Delgado',
            'email'     => 'desire@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V123',
            'status' => true,
            'sexo' =>'mujer',
            'password'     => bcrypt('123'),

        ]);


        App\User::create([
            'name'      => 'Mirella Herrera',
            'email'     => 'mirella@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V1234',
            'status' => true,
            'sexo' =>'mujer',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([
            'name'      => 'Pedro Perez',
            'email'     => 'pedrop@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V12345',
            'status' => true,
            'sexo' =>'hombre',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([
            'name'      => 'Pedro Perez',
            'email'     => 'pedrope@gmail.com',
            'prioridad' => 'alta',
            'ci'  =>'V12325456',
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
