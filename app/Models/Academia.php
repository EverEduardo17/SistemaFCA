<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academia extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Academia";
    protected $primaryKey = "IdAcademia";
    protected $fillable = ['IdAcademia', 'NombreAcademia', 'DescripcionAcademia', 'Coordinador'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Muchos a Uno
    public function academico_academia(){
        return $this->hasMany(AcademicoAcademia::class, 'IdAcademia', 'IdAcademia')->with('academico');
        //return $this->belongsToMany(Academico::class, 'academico_academia', 'IdAcademia', 'IdAcademia');
    }
    //Relacion Uno a Mucho
    public function coordinador(){
        return $this->hasOne(Academico::class, 'IdAcademico', 'Coordinador')->with('usuario');
    }


}
