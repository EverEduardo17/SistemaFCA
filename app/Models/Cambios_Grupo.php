<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Cambios_Grupo extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Cambio_Grupo";
    protected $primaryKey = "IdCambioGrupo";
    protected $fillable = ['IdGrupoOrigen', 'IdGrupoDestino', 'IdTrayectoria', 'IdPeriodoCambioGrupo'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Uno
    public function grupoOrigen()
    {
        return $this->hasOne(Grupo::class, 'IdGrupo', 'IdGrupoOrigen');
    }

    public function grupoDestino()
    {
        return $this->hasOne(Grupo::class, 'IdGrupo', 'IdGrupoDestino');
    }

    public function trayectoria()
    {
        return $this->hasOne(Trayectoria::class, 'IdTrayectoria', 'IdTrayectoria');
    }

    public function periodo()
    {
        return $this->hasOne(Periodo::class, 'IdPeriodo', 'IdPeriodoCambioGrupo');
    }
}
