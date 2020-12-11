<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Motivo extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "motivo";
    protected $primaryKey = "IdMotivo";
    protected $fillable = ['NombreMotivo', 'DescripcionMotivo'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';
}
