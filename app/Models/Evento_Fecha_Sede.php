<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Evento_Fecha_Sede extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Evento_Fecha_Sede";
    protected $primaryKey = "Id_Evento_Fecha_Sede";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Uno
    public function evento(){
        return $this->hasOne(Evento::class, 'IdEvento', 'IdEvento');
    }

    //Relacion Uno a Uno
    public function fechaEvento(){
        return $this->hasOne(FechaEvento::class, 'IdFechaEvento', 'IdFechaEvento');
    }

    //Relacion Uno a Uno
    public function sedeEvento(){
        return $this->hasOne(SedeEvento::class, 'IdSedeEvento', 'IdSedeEvento');
    }
}
