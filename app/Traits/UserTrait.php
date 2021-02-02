<?php

namespace App\Traits;


use App\Models\Role;

trait UserTrait {
    public function roles() {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function userRoles() {
        return $this->belongsToMany(Role::class, 'Role_Usuario', 'IdUsuario', 'IdRole')->with('permisos');
    }


    public function havePermission($permiso) {
        foreach ($this->userRoles as $rol) {
            foreach ($rol->permisos as $item) {
                if ($item->ClavePermiso == $permiso) {
                    return true;
                }
            }
        }
        return false;
    }
}
