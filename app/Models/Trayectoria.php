<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Trayectoria extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "trayectoria";
    protected $primaryKey = "IdTrayectoria";
    protected $fillable = [
        'EstudianteRegular', 'EstudianteActivo', 'TotalPeriodos',
        'IdGrupo', 'IdEstudiante', 'IdProgramaEducativo', 'IdModalidad', 'IdCohorte', 'IdDatosPersonales'
    ];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    public function grupo()
    {
        return $this->hasOne(Grupo::class, 'IdGrupo', 'IdGrupo');
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'IdEstudiante', 'IdEstudiante');
    }

    public function programaEducativo()
    {
        return $this->hasOne(ProgramaEducativo::class, 'IdProgramaEducativo', 'IdProgramaEducativo');
    }

    public function modalidad()
    {
        return $this->hasOne(Modalidad::class, 'IdModalidad', 'IdModalidad');
    }

    public function cohorte()
    {
        return $this->hasOne(Cohorte::class, 'IdCohorte', 'IdCohorte');
    }

    public function datosPersonales()
    {
        return $this->hasOne(DatosPersonales::class, 'IdDatosPersonales', 'IdDatosPersonales');
    }
}
