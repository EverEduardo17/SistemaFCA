<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Grupo_Estudiante extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "grupo_estudiante";
    protected $primaryKey = "IdGrupoEstudiante";
    protected $fillable = ['activo', 'IdGrupo', 'IdEstudiante'];

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Uno
    public function grupo()
    {
        return $this->hasOne(Grupo::class, 'IdGrupo', 'IdGrupo');
    }
    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'IdEstudiante', 'IdEstudiante');
    }
}
