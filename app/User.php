<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles; //roles y permisos spatie


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function formaciones() //prueba relacion con tabla pivote many to many
    {
        return $this->belongsToMany('App\Formacion')->as('inscripcion')
        ->withTimestamps()->withPivot('retiro');
    }


    public function empresa() //prueba relacion con tabla pivote many to many
    {
        return $this->belongsToMany('App\Empresa','usuario_p_empresa')->withTimestamps(); //(modelo con el que se relaciona,nombre de la tabla en la que se relacionan) Nota:la tabla que las relaciona debe existir
    }


    public function requisiciones()//one to many
    {
        return $this->hasMany('App\Requisicion','creador');
    }
}
