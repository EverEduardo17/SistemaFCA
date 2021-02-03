<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periodo extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Periodo";
    protected $primaryKey = "IdPeriodo";
    protected $fillable = ['NombrePeriodo', 'FechaInicioPeriodo', 'FechaFinPeriodo','ActualPeriodo'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

}
