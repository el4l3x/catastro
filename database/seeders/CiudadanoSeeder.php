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

        foreach ($ciudadanos as $ciudadano) {
            if ($faker->numberBetween(1, 10) < 3) {
                $jefe = new Jefe();
                $jefe->save();

                $ciudadano->jefe_id = $jefe->id;
                $ciudadano->save();

                $familia[] = $jefe->id;                

                for ($i=0; $i < $faker->numberBetween(1, 2); $i++) { 
                    $ciudadano = Ciudadano::all()->whereNotIn('id', $familia)->random()->id;
                    $familia[] = $ciudadano;
                    
                    $persona = Ciudadano::find($ciudadano);
                    $persona->jefe_id = $jefe->id;
                    $persona->save();

                    $jefe->familia()->attach($ciudadano, [
                        'jefe_id' => $jefe->id,
                    ]);
                }

            }
            
        }
    }
}
