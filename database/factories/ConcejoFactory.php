<?php

namespace Database\Factories;

use App\Models\Comuna;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Concejo>
 */
class ConcejoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $nombre = $this->faker->unique()->city();

        return [
            'nombre' => $nombre,
            'slug' => Str::slug($nombre),
            'comuna_id' => Comuna::all()->random()->id,
        ];
    }
}
