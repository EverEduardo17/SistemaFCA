<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ConstanciaEvento extends Model
{
    use Notifiable;

    protected $table = "ConstanciaEvento";
    protected $primaryKey = "IdConstancia";
    protected $fillable = ['IdConstancia', 'IdEvento'];
    
    public $timestamps = false;

    public function constancia() {
        return $this->belongsTo(Constancia::class, 'IdConstancia', 'IdConstancia');
    }

    public function evento() {
        return $this->belongsTo(Evento::class, 'IdEvento', 'IdEvento');
    }
}
