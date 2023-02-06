<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Empresa extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Empresa";
    protected $primaryKey = "IdEmpresa";
    protected $fillable = [
        'NombreEmpresa', 'DireccionEmpresa', 'LocalidadEmpresa',
        'TelefonoEmpresa', 'EmailEmpresa', 'ResponsableEmpresa',
        'TipoEmpresa', 'ActividadEmpresa', 'ClasificacionEmpresa'
    ];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';
}
