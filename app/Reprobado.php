<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Reprobado extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Reprobado";
    protected $primaryKey = "IdReprobado";
    protected $fillable = ['IdGrupo', 'IdTrayectoria', 'IdPeriodo'];
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

    public function periodo()
    {
        return $this->hasOne(Periodo::class, 'IdPeriodo', 'IdPeriodo');
    }
}
