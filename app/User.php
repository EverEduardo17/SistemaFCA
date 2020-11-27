<?php

namespace App;

use App\Traits\UserTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, UserTrait;

    protected $table = "usuario";
    protected $primaryKey = "IdUsuario";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

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

    public function academico(){
        return $this->belongsTo(Academico::class, 'IdUsuario', 'IdUsuario');
    }

    public function datosPersonales(){
        return $this->belongsTo(DatosPersonales::class, 'IdUsuario', 'IdUsuario');
    }
}
