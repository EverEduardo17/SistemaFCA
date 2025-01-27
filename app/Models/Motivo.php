<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Motivo extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Motivo";
    protected $primaryKey = "IdMotivo";
    protected $fillable = ['NombreMotivo', 'DescripcionMotivo', 'TipoBaja'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';
}
