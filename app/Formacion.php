<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formacion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre', 'status', 'disponibilidad','precio','calificacion','fecha_de_inicio','fecha_de_culminacion'
    ];

    public function inscritos() //one to many esta no se si anula a la otra en fin 
    {
        return $this->hasMany('App\User_ins_formacion');
    }



    public function users() //many to many
    {
        return $this->belongsToMany('App\User');
    }















}
