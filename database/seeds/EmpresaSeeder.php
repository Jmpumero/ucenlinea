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
        Empresa::create([
            'nombre'      => 'Universidad de Carabobo',
            'rif'     => 'G-20000041-4',

        ]);
        factory(Empresa::class,10)->create();
    }
}
