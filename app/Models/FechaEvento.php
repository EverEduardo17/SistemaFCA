<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class FechaEvento extends Model
{
    use Notifiable, SoftDeletes;

    protected $table        = "FechaEvento";
    protected $primaryKey   = "IdFechaEvento";
    protected $fillable     =  ['IdFechaEvento','InicioFechaEvento','FinFechaEvento'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    protected $dates = ['InicioFechaEvento', 'FinFechaEvento'];

    //Relacion Muchos a Uno
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
