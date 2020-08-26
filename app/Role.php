<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "role";
    protected $primaryKey = "IdRole";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Muchos a Uno
    public function role_permiso(){
        return $this->belongsTo(RolePermiso::class, 'IdRole', 'IdRole');
    }

    //Relacion Muchos a Uno
    public function role_usuario(){
        return $this->belongsTo(RoleUsuario::class, 'IdRole', 'IdRole');
    }
}
