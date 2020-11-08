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

    //Relacion Uno a Uno
    public function usuario(){
        return $this->hasOne(User::class, 'IdUsuario', 'IdUsuario');
    }

    //Relacion Muchos a Uno
    public function organizador(){
        return $this->belongsTo(Organizador::class, 'IdAcademico', 'IdAcademico');
    }

    //Relacion Muchos a Uno
    public function academico_academia(){
        return $this->belongsTo(AcademicoAcademia::class, 'IdAcademico', 'IdAcademico');
        //return $this->belongsToMany(Academia::class, 'academico_academia', 'IdAcademico', 'IdAcademia');
    }

    //Relacion Muchos a Uno
    public function mico_mia(){
        //return $this->belongsTo(AcademicoAcademia::class, 'IdAcademico', 'IdAcademico');
        return $this->belongsToMany(Academia::class, 'academico_academia', 'IdAcademico', 'IdAcademia');
    }

    //Relacion Muchos a Uno
    public function academia(){
        return $this->belongsTo(Academia::class, 'IdAcademico', 'IdAcademico');
    }

    //Relacion Muchos a Uno
    public function academico_evento(){
        return $this->belongsTo(AcademicoEvento::class, 'IdAcademico', 'IdAcademico');
    }
}
