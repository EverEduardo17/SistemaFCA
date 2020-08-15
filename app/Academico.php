<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academico extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Academico";
    protected $primaryKey = "IdAcademico";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    public function usuario(){
        return $this->hasOne(User::class, 'IdUsuario', 'IdUsuario');
    }


}
