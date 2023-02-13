<?php

namespace Database\Seeders;

use App\Models\Ciudadano;
use App\Models\Infante;
use App\Models\Jefe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CiudadanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $ciudadanos = Ciudadano::factory(150000)->create();

        foreach ($ciudadanos as $ciudadano) {
            if (Jefe::all()->count() === 0 || $ciudadano->jefe == null && rand(1, 10) < 3) {
                $jefe = new Jefe();
                $jefe->ciudadano_id = $ciudadano->id;
                $jefe->save();

                $jefe->familia()->attach($ciudadano);

            } else {
                $ciudadano->familia()->attach(Jefe::all()->random()->id);
            }
            
        }

    }
}
