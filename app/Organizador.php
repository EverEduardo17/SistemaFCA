<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organizador extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "organizador";
    protected $primaryKey = "IdOrganizador";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Mucho
    public function evento(){
        return $this->hasMany(Evento::class, 'IdEvento', 'IdEvento');
    }

    //Relacion Uno a Mucho
    public function academico(){
        return $this->hasOne(Academico::class, 'IdAcademico', 'IdAcademico');
    }

    //Relacion Uno a Mucho
    public function tipo_organizador(){
        return $this->hasOne(TipoOrganizador::class, 'IdTipoOrganizador', 'IdTipoOrganizador');
    }
}
