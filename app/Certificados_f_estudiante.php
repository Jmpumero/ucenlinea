<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificados_f_estudiante extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'codigo_certificado';


    //prueba
    public function getFechaDeInicioAttribute($value){
        return Carbon::parse($value)->format('d-m-Y ');
    }
}
