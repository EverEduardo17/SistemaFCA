<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facultad extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "facultad";
    protected $primaryKey = "IdFacultad";
    protected $fillable = ['IdFacultad', 'NombreFacultad', 'ClaveFacultad'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

}
