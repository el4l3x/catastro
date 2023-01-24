<?php

namespace Database\Seeders;

use App\Models\Ciudadano;
use App\Models\Infante;
use App\Models\Jefe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class JefeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();
        $jefes = Jefe::factory(800)->create();

        foreach ($jefes as $jefe) {
            $jefe->ciudadanos()->attach($jefe->id, [
                'jefe_id' => $jefe->id,
            ]);
            for ($i=0; $i < $faker->numberBetween(1, 2); $i++) { 
                $jefe->ciudadanos()->attach(Ciudadano::all()->unique()->random()->id, [
                    'jefe_id' => $jefe->id,
                ]);
            }
            
            for ($i=0; $i < $faker->numberBetween(1, 2); $i++) { 
                $jefe->infantes()->attach(Infante::all()->unique()->random()->id, [
                    'jefe_id' => $jefe->id,
                ]);
            }
        }
    }
}
