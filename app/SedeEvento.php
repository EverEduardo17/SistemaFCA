<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class SedeEvento extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "SedeEvento";
    protected $primaryKey = "IdSedeEvento";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    public function evento_fecha_sede(){
        return $this->belongsTo(Evento_Fecha_Sede::class, 'IdFechaEvento', 'IdFechaEvento');
    }

}
