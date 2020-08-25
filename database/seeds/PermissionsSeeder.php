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
        Permission::create(['name' => 'inscribir estudiantes']);


        //Admin
        $admin = Role::create(['name' => 'Admin']);

        $admin->givePermissionTo([
            'inscribir estudiantes'

        ]);
        //$admin->givePermissionTo('products.index');
        //$admin->givePermissionTo(Permission::all());

        //Guest/*


        $prueba= Role::create(['name' => 'prueba']);

        $prueba->givePermissionTo([
            'inscribir estudiantes'
        ]);


        //User Admin
        $user = User::find(1); //yo
        $user->assignRole('Admin');

        //otro
        /*$user = User::find(2);
        $user->assignRole('prueba');*/
    }

}
