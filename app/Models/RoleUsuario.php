<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUsuario extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "role_permiso";
    protected $primaryKey = "Id_Role_Permiso";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Mucho
    public function role(){
        return $this->hasMany(Role::class, 'IdRole', 'IdRole');
    }

    //Relacion Uno a Mucho
    public function usuario(){
        return $this->hasMany(User::class, 'IdUsuario', 'IdUsuario');
    }
}
