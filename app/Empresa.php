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



    public function users() //many to many
    {
        return $this->belongsToMany('App\User');
    }
}
