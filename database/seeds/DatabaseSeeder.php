<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(EmpresaSeeder::class);
         $this->call(UsersTableSeeder::class);

         $this->call(RequisicionSeeder::class);
         $this->call(PermissionsSeeder::class);
         //$this->call(FormacionSeeder::class);
         //$this->call(Usuario_p_empresaSeeder::class);
        // $this->call(User_ins_formacionSeeder::class);

    }
}
