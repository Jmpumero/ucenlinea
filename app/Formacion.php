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





















}
