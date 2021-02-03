<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Traslado extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Traslado";
    protected $primaryKey = "IdTraslado";
    protected $fillable = [
        'FacultadDestino', 'CampusDestino', 'IdGrupo',
        'IdTrayectoria',  'IdPeriodo'
    ];
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
