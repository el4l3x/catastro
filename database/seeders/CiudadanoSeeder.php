<?php

namespace Database\Seeders;

use App\Models\Ciudadano;
use App\Models\Concejo;
use App\Models\Jefe;
use App\Models\Parroquia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CiudadanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        /* $ciudadanos = Ciudadano::factory(150000)->create()->each(function ($ciudadano)
        {
            if (Jefe::all()->count() === 0 || $ciudadano->jefe == null && rand(1, 10) < 3) {
                $jefe = new Jefe();
                $jefe->ciudadano_id = $ciudadano->id;
                $jefe->save();

                $jefe->familia()->attach($ciudadano);

            } else {
                $ciudadano->familia()->attach(Jefe::all()->random()->id);
            }
        }); */

        $faker = \Faker\Factory::create();
        $data = [];

        for ($i = 0; $i < 150000; $i++) {
            $cedula = $faker->unique()->numberBetween(1000000, 35000000);

            $data[] = [
                /* 'name'              => $faker->name(),
                'email'             => $faker->unique()->safeEmail(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password */
                'nombres' => $faker->firstName(),
                'apellidos' => $faker->lastName(),
                'nacionalidad' => $faker->randomElement(['V', 'E']),
                'cedula' => $cedula,
                'slug' => Str::slug($cedula),
                'sexo' => $faker->randomElement(['M', 'F']),
                'nacimiento' => $faker->dateTimeBetween('-90 years', '-9 years'),
                'codigo' => $faker->randomElement(['0416', '0426', '0414', '0424', '0412']),
                'telefono' => $faker->randomNumber(7, true),
                'direccion' => $faker->address(),
                'concejo_id' => Concejo::all()->random()->id,
                'parroquia_id' => Parroquia::all()->random()->id,
                'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
            ];
        }

        $chunks = array_chunk($data, 5000);

        foreach ($chunks as $chunk) {
            /* User::insert($chunk); */

            Ciudadano::insert($chunk);

            foreach ($chunk as $value) {
                $ciudadano = Ciudadano::where('cedula', $value['cedula'])->first();
                /* var_dump($ciudadano); */
                if (Jefe::all()->count() === 0 || $ciudadano->jefe == null && rand(1, 10) < 3) {
                    $jefe = new Jefe();
                    $jefe->ciudadano_id = $ciudadano->id;
                    $jefe->save();
    
                    $jefe->familia()->attach($ciudadano->id);
    
                } else {                    
                    $ciudadano->familia()->attach(Jefe::all()->random()->id);
                }
            }
        }

    }
}
