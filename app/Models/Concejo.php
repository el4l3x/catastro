<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Concejo extends Model
{
    use HasFactory;

    protected function nombre(): Attribute
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

    public function comuna()
    {
        return $this->BelongsTo(Comuna::class);
    }

    public function ciudadanos()
    {
        return $this->hasMany(Ciudadano::class);
    }
}
