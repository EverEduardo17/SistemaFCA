<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Evento";
    protected $primaryKey = "IdEvento";
    protected $fillable = ['NombreEvento', 'DescripcionEvento','EstadoEvento'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Muchos
    public function FechaEvento_s(){
        return $this->belongsToMany(FechaEvento::class, 'Evento_Fecha_Sede', 'IdEvento', 'IdEvento');
    }

    //Relacion Muchos a Uno
    public function organizador(){
        return $this->hasMany(Organizador::class, 'IdEvento', 'IdEvento');
    }

    //Relacion Muchos a Uno
    public function documento(){
        return $this->hasMany(Documento::class, 'IdEvento', 'IdEvento');
    }

    //Relacion Muchos a Uno
    public function academico_evento(){
        return $this->hasMany(AcademicoEvento::class, 'IdEvento', 'IdEvento');
    }

    //Relacion Uno a Uno
    public function eventoFechaSede(){
        return $this->hasMany(Evento_Fecha_Sede::class, 'IdEvento', 'IdEvento');
    }

}
