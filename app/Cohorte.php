<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Cohorte extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "cohorte";
    protected $primaryKey = "IdCohorte";
    protected $fillable = ['NombreCohorte','DescripcionCohorte'];
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    //Relacion Uno a Uno
    // public function programaEducativo()
    // {
    //     return $this->hasOne(ProgramaEducativo::class, 'IdProgramaEducativo', 'IdProgramaEducativo');
    // }
    // public function cohorte()
    // {
    //     return $this->hasOne(Cohorte::class, 'IdCohorte', 'IdCohorte');
    // }
    // public function periodo()
    // {
    //     return $this->hasOne(Periodo::class, 'IdPeriodo', 'IdPeriodoActivo');
    // }
}
