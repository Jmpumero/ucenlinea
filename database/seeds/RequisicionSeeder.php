<?php

use Illuminate\Database\Seeder;

use App\Requisicion;
class RequisicionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Requisicion::create([
            'creador'      => 1,
            'empresa_id'     => 3,
            'nombre'  =>'Tascla',
            'modalidad' =>'extrema',
            'audiencia' =>'todo publico',
            't_formacion'     => 'interna',

        ]);

        Requisicion::create([
            'creador'      => 2,
            'empresa_id'     => 1,
            'nombre'  =>'Cheese Pizza',
            'modalidad' =>'all',
            'audiencia' =>'todo publico',
            't_formacion'     => 'interna',

        ]);

        Requisicion::create([
            'creador'      => 1,
            'empresa_id'     => 3,
            'nombre'  =>'Il Cigno Nero',
            'modalidad' =>'imposible',
            'audiencia' =>'todo publico',
            't_formacion'     => 'externa',

        ]);
        factory(Requisicion::class,15)->create();
    }
}
