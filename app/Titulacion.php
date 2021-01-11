<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Titulacion extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Titulacion";
    protected $primaryKey = "IdTitulacion";
    protected $fillable = [
        'PromedioEgreso', 'FechaInicioTramite', 'FechaFinTramite',
        'EstadoTitulacion', 'ResultadoTitulacion', 'IdModalidad',
        'IdGrupo', 'IdTrayectoria', 'IdPeriodoTitulacion', 'MencionHonorifica'
    ];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    public function modalidad()
    {
        return $this->hasOne(Modalidad::class, 'IdModalidad', 'IdModalidad');
    }

    public function grupo()
    {
        return $this->hasOne(Grupo::class, 'IdGrupo', 'IdGrupo');
    }

    public function trayectoria()
    {
        return $this->hasOne(Trayectoria::class, 'IdTrayectoria', 'IdTrayectoria');
    }

    public function periodo()
    {
        return $this->hasOne(Periodo::class, 'IdPeriodo', 'IdPeriodoTitulacion');
    }
}