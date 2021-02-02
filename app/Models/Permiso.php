<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permiso extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Permiso";
    protected $primaryKey = "IdPermiso";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Muchos a Uno
    public function role_permiso(){
        return $this->belongsTo(RolePermiso::class, 'IdPermiso', 'IdPermiso');
    }
}
