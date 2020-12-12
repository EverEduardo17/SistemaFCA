<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class TipoOrganizador extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "TipoOrganizador";
    protected $primaryKey = "IdTipoOrganizador";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Muchos a Uno
    public function organizador(){
        return $this->belongsTo(Organizador::class, 'IdTipoOrganizador', 'IdTipoOrganizador');
    }
}
