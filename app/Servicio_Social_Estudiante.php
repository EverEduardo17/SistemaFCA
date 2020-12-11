<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Servicio_Social_Estudiante extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Servicio_Social_Estudiante";
    protected $primaryKey = "IdServicioSocial";
    protected $fillable = ['activo', 'IdEmpresa', 'IdTrayectoria'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Uno
    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'IdEmpresa', 'IdEmpresa');
    }
    public function Trayectoria()
    {
        return $this->hasOne(Trayectoria::class, 'IdTrayectoria', 'IdTrayectoria');
    }
}
