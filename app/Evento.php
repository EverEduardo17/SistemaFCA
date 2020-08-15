<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Evento";
    protected $primaryKey = "IdEvento";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    public function FechaEvento_s(){
        return $this->belongsToMany(FechaEvento::class, 'Evento_Fecha_Sede', 'IdEvento', 'IdEvento');
    }
}
