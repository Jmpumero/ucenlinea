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

        Empresa::create([
            'nombre'      => 'Amazon',
            'rif'     => 'G-211111111-4',

        ]);

        /*Empresa::create([
            'nombre'      => 'Polar',
            'rif'     => 'J-00006372-9',

        ]);*/

        Empresa::create([
            'nombre'      => 'Open English',
            'rif'     => 'K-5555555-4',

        ]);
        //factory(Empresa::class,15)->create();
    }
}
