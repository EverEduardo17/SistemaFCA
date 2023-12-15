<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ConstanciaEstudiante extends Model
{
    use Notifiable;

    protected $table = "constancia_estudiante";
    protected $primaryKey = ['IdConstancia', 'IdEstudiante'];
}
