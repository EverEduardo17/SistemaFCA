<?php

namespace App\Traits;


trait UserTrait {
    public function roles() {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function userRoles() {
        return $this->belongsToMany('App\Role', 'Role_Usuario', 'IdUsuario', 'IdRole')->with('permisos');
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
