<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_ins_formacion extends Model
{


protected $fillable = [
        'user_id', 'formacion_id', 'supervisor_id',
    ];


    public function formacion() //relacion
    {
        return $this->belongsTo('App\Formacion');
    }
}
