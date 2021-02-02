<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Modalidad extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Modalidad";
    protected $primaryKey = "IdModalidad";
    protected $fillable = ['NombreModalidad', 'DescripcionModalidad','TipoModalidad'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';
}
