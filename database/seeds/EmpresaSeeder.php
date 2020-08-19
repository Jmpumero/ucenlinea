<?php

use Illuminate\Database\Seeder;
use App\Empresa;
class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Empresa::class,10)->create();
    }
}
