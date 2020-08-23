<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Formacion;
class Requisicion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre', 'modalida', 'audiencia','t_formacion',
    ];

    public function formaciones()//one to many
    {
        return $this->hasMany('App\Formacion');
    }

    public function user() //inverse one to many
    {
        return $this->belongsTo('App\User');
    }

}
