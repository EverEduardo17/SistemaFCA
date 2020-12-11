<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
Use App\Facultad;

class ProgramaEducativo extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "Programa_Educativo";
    protected $primaryKey = "IdProgramaEducativo";
    protected $fillable = ['IdFacultad', 'NombreProgramaEducativo','AcronimoProgramaEducativo'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Uno
    public function facultad(){
        return $this->hasOne(Facultad::class, 'IdFacultad', 'IdFacultad');
    }
}
