<?php

namespace Database\Factories;

use App\Models\Comuna;
use App\Models\Concejo;
use App\Models\Parroquia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ciudadano>
 */
class CiudadanoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cedula = $this->faker->unique()->numberBetween(1000000, 35000000);

        return [
            'nombres' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'nacionalidad' => $this->faker->randomElement(['V', 'E']),
            'cedula' => $cedula,
            'slug' => Str::slug($cedula),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            'nacimiento' => $this->faker->dateTimeBetween('-90 years', '-9 years'),
            'codigo' => $this->faker->randomElement(['0416', '0426', '0414', '0424', '0412']),
            'telefono' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->address(),
            'concejo_id' => Concejo::all()->random()->id,
            'parroquia_id' => Parroquia::all()->random()->id,
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
