<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicoEvento extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Academico_Evento";
    protected $primaryKey = "Id_Academico_Evento";
    protected $fillable = ['IdAcademico', 'IdEvento'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Mucho
    public function academico(){
        return $this->hasOne(Academico::class, 'IdAcademico', 'IdAcademico');
    }

    //Relacion Uno a Mucho
    public function evento(){
        return $this->hasOne(Evento::class, 'IdEvento', 'IdEvento');
    }
}
