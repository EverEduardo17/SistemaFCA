<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Role";
    protected $primaryKey = "IdRole";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    public function permisos() {
        return $this->belongsToMany(Permiso::class, 'Role_Permiso', 'IdRole', 'IdPermiso');
    }

    public function usuarios() {
        return $this->belongsToMany(Usuario::class, 'Role_Usuario', 'IdRole', 'IdUsuario');
    }

    //Relacion Muchos a Uno
    public function role_usuario(){
        return $this->belongsTo(RoleUsuario::class, 'IdRole', 'IdRole');
    }
}
