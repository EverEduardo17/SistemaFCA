<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\ProgramaEducativo;
use App\Models\Cohorte;
use App\Models\Periodo;

class Grupo extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Grupo";
    protected $primaryKey = "IdGrupo";
    protected $fillable = [
        'NombreGrupo', 'DescripcionGrupo', 'IdProgramaEducativo',
        'IdCohorte', 'IdPeriodoInicio', 'IdPeriodoActivo',
        'IdFacultad'
    ];

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    public function programaEducativo()
    {
        return $this->hasOne(ProgramaEducativo::class, 'IdProgramaEducativo', 'IdProgramaEducativo');
    }

    public function cohorte()
    {
        return $this->hasOne(Cohorte::class, 'IdCohorte', 'IdCohorte');
    }

    public function periodoInicio()
    {
        return $this->hasOne(Periodo::class, 'IdPeriodo', 'IdPeriodoInicio');
    }

    public function periodoActivo()
    {
        return $this->hasOne(Periodo::class, 'IdPeriodo', 'IdPeriodoActivo');
    }

    public function facultad()
    {
        return $this->hasOne(Facultad::class, 'IdFacultad', 'IdFacultad');
    }

    // public function trayectorias()
    // {
    //     return $this->hasMany(Trayectoria::class, 'IdGrupo', 'IdGrupo');
    // }
}
