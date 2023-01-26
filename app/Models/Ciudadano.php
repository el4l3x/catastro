<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudadano extends Model
{
    use HasFactory;

    protected function nombres(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value),
        );
    }

    protected function apellidos(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value),
        );
    }

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function concejo()
    {
        return $this->belongsTo(Concejo::class);
    }

    public function parroquia()
    {
        return $this->belongsTo(Parroquia::class);
    }

    public function infantes()
    {
        return $this->hasMany(Infante::class);
    }

    public function familia()
    {
        return $this->belongsToMany(Jefe::class);
    }

    public function jefe()
    {
        return $this->hasOne(Jefe::class);
    }
}
