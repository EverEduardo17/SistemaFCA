<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicoAcademia extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "academico_academia";
    protected $primaryKey = "Id_Academico_Academia";
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Mucho
    public function academico(){
        return $this->hasOne(Academico::class, 'IdAcademico', 'IdAcademico');
    }

    //Relacion Uno a Mucho
    public function academia(){
        return $this->hasMany(Academia::class, 'IdAcademia', 'IdAcademia');
    }
}
