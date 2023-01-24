<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jefe extends Model
{
    protected $table = 'jefes';

    use HasFactory;

    public function ciudadanos()
    {
        return $this->morphedByMany(Ciudadano::class, 'jefeable');
    }

    public function infantes()
    {
        return $this->morphedByMany(Infante::class, 'jefeable');
    }
}
