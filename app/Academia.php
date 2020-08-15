<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academia extends Model
{
    protected $table = "Academia";
    protected $primaryKey = "idAcademia";
    public const CREATED_AT = "CreatedAt";
    public const UPDATED_AT = "UpdatedAt";
}
