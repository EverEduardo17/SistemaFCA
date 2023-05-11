<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class Usuario extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Usuario";
    protected $primaryKey = "IdUsuario";
    protected $fillable = ['name', 'email','email_verfied_at','password','remember_token'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';
}
