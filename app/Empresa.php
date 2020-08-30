<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nombre', 'rif'
    ];



    public function users() //inverse many to many
    {
        return $this->belongsToMany('App\User','usuario_p_empresas');
    }

    public function requisiciones()//one to many
    {
        return $this->hasMany('App\Requisicion');
    }

}
