<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permission list
        Permission::create(['name' => 'formaciones']);
        Permission::create(['name' => 'solicitudes']);
        Permission::create(['name' => 'retiros']);

        Permission::create(['name' => 'inscribir estudiantes en formacion']);
        Permission::create(['name' => 'matricular estudiantes en moodle']);
        Permission::create(['name' => 'Descargar matricula externa']);


        //Roles list
        $admin = Role::create(['name' => 'Admin']);
        $rp=Role::create(['name' => 'Responsable de Personal']);
        $sp=Role::create(['name' => 'Supervisor']);
        $facilitador=Role::create(['name' => 'Facilitador']);
        $estu=Role::create(['name' => 'Estudiante']);
        $rc=Role::create(['name' => 'Responsable de Contenido']);
        $rce=Role::create(['name' => 'Responsable de Control de Estudio']);
        $rad=Role::create(['name' => 'Responsable Administrativo']);
        $rti=Role::create(['name' => 'Responsable de TI']);
        $ra=Role::create(['name' => 'Responsable Academico']);
        $prov=Role::create(['name' => 'Proveedor']);
        $ext=Role::create(['name' => 'Externo']); //no seguro

        $admin->givePermissionTo([
            'inscribir estudiantes en formacion'

        ]);
        $rp->givePermissionTo([
            'inscribir estudiantes en formacion'

        ]);

        $rce->givePermissionTo([
            'matricular estudiantes en moodle'

        ]);

        $prov->givePermissionTo([
            'Descargar matricula externa'

        ]);


        //$admin->givePermissionTo('products.index');
        //$admin->givePermissionTo(Permission::all());

        //Guest/*





        //User Admin
        $user = User::find(1); //yo
        $user->assignRole('Admin','Responsable de Personal','Supervisor','Responsable de Control de Estudio','Facilitador','Proveedor','Estudiante');

        $user = User::find(3);
        $user->assignRole('Facilitador');
        //otro
        $user = User::find(4);
        $user->assignRole('Responsable de Personal');
        $user = User::find(5);
        $user->assignRole('Responsable de Personal');

        $user = User::find(6);
        $user->assignRole('Supervisor');

        $user = User::find(7);
        $user->assignRole('Estudiante');
        $user = User::find(8);
        $user->assignRole('Estudiante');
        $user = User::find(2);
        $user->assignRole('Responsable de Control de Estudio');
        $user = User::find(9);
        $user->assignRole('Proveedor');

        $user = User::find(10);
        $user->assignRole('Facilitador');
        $user = User::find(11);
        $user->assignRole('Facilitador');
        $user = User::find(12);
        $user->assignRole('Facilitador');
        $user = User::find(13);
        $user->assignRole('Facilitador');

    }

}
