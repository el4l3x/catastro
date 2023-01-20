<?php

namespace Database\Factories;

use App\Models\Ciudadano;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Infante>
 */
class InfanteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $nombre = $this->faker->firstName();
        $apellido = $this->faker->lastName();

        return [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'slug' => Str::slug($nombre.' '.$apellido),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            'nacimiento' => $this->faker->dateTimeBetween('-90 years', '-9 years'),
            'ciudadano_id' => Ciudadano::all()->random()->id,
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
