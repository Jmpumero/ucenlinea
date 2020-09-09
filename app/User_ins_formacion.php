<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_ins_formacion extends Model
{


    protected $guarded = [];


    public function formacion() //relacion
    {
        return $this->belongsTo('App\Formacion');
    }
}
