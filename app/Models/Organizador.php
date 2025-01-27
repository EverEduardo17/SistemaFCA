<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organizador extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Organizador";
    protected $primaryKey = "IdOrganizador";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Mucho
    public function evento(){
        return $this->hasMany(Evento::class, 'IdEvento', 'IdEvento');
    }

    //Relacion Uno a Mucho
    public function usuario(){
        return $this->hasOne(Usuario::class, 'IdUsuario', 'IdAcademico');
    }

    //Relacion Uno a Mucho
    public function tipo_organizador(){
        return $this->hasOne(TipoOrganizador::class, 'IdTipoOrganizador', 'IdTipoOrganizador');
    }
}
