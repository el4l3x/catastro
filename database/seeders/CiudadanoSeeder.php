<?php

namespace Database\Seeders;

use App\Models\Ciudadano;
use App\Models\Infante;
use App\Models\Jefe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class CiudadanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $ciudadanos = Ciudadano::factory(5000)->create();
        Infante::factory(1750)->create();

        $familia = array();
        $hijos = array();

        foreach ($ciudadanos as $ciudadano) {
            if ($faker->numberBetween(1, 10) < 3) {
                $jefe = new Jefe();
                $jefe->ciudadano_id = $ciudadano->id;
                $jefe->save();

                $jefe->ciudadanos()->attach($ciudadano->id, [
                    'jefe_id' => $jefe->id,
                ]);

                $familia[] = $jefe->id;                

                for ($i=0; $i < $faker->numberBetween(1, 2); $i++) { 
                    $ciudadano = Ciudadano::all()->whereNotIn('id', $familia)->random()->id;
                    $familia[] = $ciudadano;
                    $jefe->ciudadanos()->attach($ciudadano, [
                        'jefe_id' => $jefe->id,
                    ]);
                }
                
                for ($i=0; $i < $faker->numberBetween(1, 2); $i++) { 
                    $infante = Infante::all()->whereNotIn('id', $hijos)->random()->id;
                    $hijos[] = $infante;
                    $jefe->infantes()->attach($infante, [
                        'jefe_id' => $jefe->id,
                    ]);
                }
            }
            
        }
    }
}
