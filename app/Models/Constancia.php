<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Constancia extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = "Constancia";

    protected $primaryKey = "IdConstancia";

    const CREATED_AT = 'CreatedAt';

    const UPDATED_AT = 'UpdatedAt';

    const DELETED_AT = 'DeletedAt';


    //Relacion Uno a Uno
    public function usuario(){
        return $this->hasOne(User::class, 'IdUsuario', 'CreatedBy');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'constancia_estudiante', 'IdConstancia', 'IdEstudiante')
                    ->withPivot('created_at', 'updated_at');
    }

    public function evento() {
        return $this->hasOne(ConstanciaEvento::class, 'IdConstancia', 'IdConstancia');
    }
}
