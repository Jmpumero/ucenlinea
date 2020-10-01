<?php

use Illuminate\Database\Seeder;
use App\Formacion;
use Carbon\Carbon;
class FormacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now=Carbon::now();

        Formacion::create([
            'nombre'    => 'Cirice',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 3.33,
            'calificacion' => 7,
            'max_matricula' =>5,
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>1,

        ]);

        Formacion::create([
            'nombre'    => 'Oceano',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 3.33,
            'calificacion' => 9,
            'max_matricula' =>15,
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>2,

        ]);

        Formacion::create([
            'nombre'    => 'Amata Inmortale',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 13.33,
            'calificacion' => 9,
            'max_matricula' =>5,
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>3,

        ]);
        factory(Formacion::class,5)->create();
    }
}
