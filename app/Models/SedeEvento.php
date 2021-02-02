<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class SedeEvento extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "SedeEvento";
    protected $primaryKey = "IdSedeEvento";
    protected $fillable = ['NombreSedeEvento', 'DescripcionSedeEvento'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Muchos a Uno
    public function evento_fecha_sede(){
        return $this->belongsTo(Evento_Fecha_Sede::class, 'IdFechaEvento', 'IdFechaEvento');
    }

}
