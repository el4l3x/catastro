<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infante extends Model
{
    use HasFactory;

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value),
        );
    }

    protected function apellido(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value),
        );
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function ciudadano()
    {
        return $this->belongsTo(Ciudadano::class);
    }

    public function familia()
    {
        return $this->morphToMany(Jefe::class, 'jefeable');
    }
}
