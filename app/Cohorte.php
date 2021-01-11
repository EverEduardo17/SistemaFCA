<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Cohorte extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Cohorte";
    protected $primaryKey = "IdCohorte";
    protected $fillable = ['NombreCohorte','DescripcionCohorte'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';
    
}
