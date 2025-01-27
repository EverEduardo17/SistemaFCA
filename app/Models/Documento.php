<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Documento";
    protected $primaryKey = "IdDocumento";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Mucho
    public function evento(){
        return $this->hasMany(Evento::class, 'IdEvento', 'IdEvento');
    }
}
