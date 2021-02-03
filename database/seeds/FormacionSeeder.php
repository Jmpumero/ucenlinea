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
            'empresa_proveedora_id' => 1,
            'nombre'    => 'PHP',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            'publicar'    => false,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 0,
            'calificacion' => 10,
            'imagen'    => 'adminlte/img/formaciones/phplogo.png',
            'max_matricula' =>5,
            'actual_matricula' =>0,
            'formacion_libre'    => false,
            'f_resumen'    => 'Resumen de la formacion',
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>4,

        ]);


        Formacion::create([
            'empresa_proveedora_id' => 1,
            'nombre'    => 'Diseño Grafico',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            'publicar'    => false,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 0,
            'calificacion' => 10,
            'imagen'    => 'adminlte/img/formaciones/diseño.jpg',
            'max_matricula' =>5,
            'actual_matricula' =>0,
            'formacion_libre'    => false,
            'f_resumen'    => 'Resumen de la formacion',
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>5,

        ]);

        Formacion::create([
            'empresa_proveedora_id' => 1,
            'nombre'    => 'Gerencia',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            'publicar'    => false,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 0,
            'calificacion' => 10,
            'imagen'    => 'adminlte/img/formaciones/administracion.jpg',
            'max_matricula' =>5,
            'actual_matricula' =>0,
            'formacion_libre'    => false,
            'f_resumen'    => 'Resumen de la formacion',
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>6,

        ]);

        Formacion::create([
            'empresa_proveedora_id' => 1,
            'nombre'    => 'Python Avanzado',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            'publicar'    => false,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 0,
            'calificacion' => 10,
            'imagen'    => 'adminlte/img/formaciones/python.png',
            'max_matricula' =>5,
            'actual_matricula' =>0,
            'formacion_libre'    => false,
            'f_resumen'    => 'Resumen de la formacion',
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>7,

        ]);

        Formacion::create([
            'empresa_proveedora_id' => 1,
            'nombre'    => 'Laravel Medio',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            'publicar'    => false,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 0,
            'calificacion' => 10,
            'imagen'    => 'adminlte/img/formaciones/laravel.png',
            'max_matricula' =>5,
            'actual_matricula' =>0,
            'formacion_libre'    => false,
            'f_resumen'    => 'Resumen de la formacion',
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>8,

        ]);

        Formacion::create([
            'empresa_proveedora_id' => 1,
            'nombre'    => 'Primeros Auxilios',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            'publicar'    => false,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 0,
            'calificacion' => 10,
            'imagen'    => 'adminlte/img/formaciones/pauxilio.jpg',

            'actual_matricula' =>0,
            'formacion_libre'    => true,
            'f_resumen'    => 'Primeros auxilios ymas texto de resumen acerca de la formacion',
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>9,

        ]);

        Formacion::create([
            'empresa_proveedora_id' => 1,
            'nombre'    => 'Medidas de Prevención',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            'publicar'    => false,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 0,
            'calificacion' => 10,
            'imagen'    => 'adminlte/img/formaciones/coronana.jpg',

            'actual_matricula' =>0,
            'formacion_libre'    => true,
            'f_resumen'    => 'Medidas de Prevencion en tiempos de pandemia',
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>10,

        ]);


        Formacion::create([
            'empresa_proveedora_id' => 1,
            'nombre'    => 'Seguridad Industrial',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            'publicar'    => false,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 100,
            'calificacion' => 0,
            'imagen'    => 'adminlte/img/formaciones/si.jpg',
            'max_matricula' =>5,
            'actual_matricula' =>0,
            'formacion_libre'    => false,
            'f_resumen'    => 'Resumen de la formacion',
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>1,

        ]);

        Formacion::create([
            'empresa_proveedora_id' => 1,
            'nombre'    => 'Social Media',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            'publicar'    => false,
            't_facilitador'   => false,
            'tipo'  => 'interna',
            'precio'    => 100,
            'calificacion' => 0,
            'imagen'    => 'adminlte/img/formaciones/socialmedia.png',
            'max_matricula' =>5,
            'actual_matricula' =>0,
            'formacion_libre'    => false,
            'f_resumen'    => 'Resumen de la formacion',
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>2,

        ]);

        Formacion::create([
            'empresa_proveedora_id' => 3,
            'nombre'    => 'Ingles Intermedio',
            'status'    => 'sin postulados',
            'disponibilidad'    => true,
            'publicar'    => false,
            't_facilitador'   => false,
            'tipo'  => 'externa',
            'precio'    => 100,
            'calificacion' => 0,
            'imagen'    => 'adminlte/img/formaciones/banderai.png',
            'max_matricula' =>5,
            'actual_matricula' =>0,
            'formacion_libre'    => false,
            'f_resumen'    => 'Exiiiito, aprende ingles con wachu',
            'fecha_de_inicio'=>$now->addWeek(),
            'requisicion_id'=>3,

        ]);

    }
}
