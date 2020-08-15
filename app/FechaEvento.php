<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FechaEvento extends Model
{
    use SoftDeletes;

    protected $table = "FechaEvento";
    protected $primaryKey = "IdFechaEvento";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    protected $dates = ['InicioFechaEvento', 'FinFechaEvento'];

    public function evento_fecha_sede(){
        return $this->belongsTo(Evento_Fecha_Sede::class, 'IdFechaEvento', 'IdFechaEvento');
    }

    public function sedeEvento(){
        return $this->evento_fecha_sede->sedeEvento();
    }

    public function evento(){
        return $this->evento_fecha_sede->evento();
    }
}
