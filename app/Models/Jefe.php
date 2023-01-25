<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jefe extends Model
{
    protected $table = 'jefes';

    use HasFactory;

    public function familia()
    {
        return $this->belongsToMany(Ciudadano::class);
    }

    public function datos()
    {
        return $this->hasOne(Ciudadano::class);
    }
}
