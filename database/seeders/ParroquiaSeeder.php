<?php

namespace Database\Seeders;

use App\Models\Parroquia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParroquiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parroquia = new Parroquia();
        $parroquia->nombre = "Villa de Cura";
        $parroquia->slug = Str::slug("Villa de Cura");
        $parroquia->save();
        
        $parroquia = new Parroquia();
        $parroquia->nombre = "Magdaleno";
        $parroquia->slug = Str::slug("Magdaleno");
        $parroquia->save();
        
        $parroquia = new Parroquia();
        $parroquia->nombre = "San Francisco de Asis";
        $parroquia->slug = Str::slug("San Francisco de Asis");
        $parroquia->save();
        
        $parroquia = new Parroquia();
        $parroquia->nombre = "Tucutunemo";
        $parroquia->slug = Str::slug("Tucutunemo");
        $parroquia->save();
        
        $parroquia = new Parroquia();
        $parroquia->nombre = "Augusto Mijares";
        $parroquia->slug = Str::slug("Augusto Mijares");
        $parroquia->save();
    }
}
