<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Baja extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Baja";
    protected $primaryKey = "IdBaja";
    protected $fillable = [
        'IdGrupo', 'IdTrayectoria', 'IdPeriodoBaja', 'TipoBaja',
        'IdMotivo', 'IdPeriodoTramite'
    ];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Uno
    public function grupo()
    {
        return $this->hasOne(Grupo::class, 'IdGrupo', 'IdGrupo');
    }

    //Relacion Uno a Uno
    public function trayectoria()
    {
        return $this->hasOne(Trayectoria::class, 'IdTrayectoria', 'IdTrayectoria');
    }

    public function periodoBaja()
    {
        return $this->hasOne(Periodo::class, 'IdPeriodo', 'IdPeriodoBaja');
    }
    public function motivo()
    {
        return $this->hasOne(Motivo::class, 'IdMotivo', 'IdMotivo');
    }
    public function periodoTramite()
    {
        return $this->hasOne(Periodo::class, 'IdPeriodo', 'IdPeriodoTramite');
    }
}
