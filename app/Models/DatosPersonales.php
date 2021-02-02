<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatosPersonales extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "DatosPersonales";
    protected $primaryKey = "IdDatosPersonales";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Uno
    public function usuario(){
        return $this->hasOne(User::class, 'IdUsuario', 'IdUsuario');
    }
}
