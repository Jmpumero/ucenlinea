<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario_p_empresa extends Model
{
    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }
}
