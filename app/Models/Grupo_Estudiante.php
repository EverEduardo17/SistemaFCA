<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Grupo_Estudiante extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Grupo_Estudiante";
    protected $primaryKey = "IdGrupoEstudiante";
    protected $fillable = ['Estado', 'TipoTraslado', 'IdGrupo', 'IdTrayectoria'];

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    public function grupo()
    {
        return $this->hasOne(Grupo::class, 'IdGrupo', 'IdGrupo');
    }

    public function trayectoria()
    {
        return $this->hasOne(Trayectoria::class, 'IdTrayectoria', 'IdTrayectoria');
    }
}
