<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Ciudadano;
use App\Models\Comuna;
use App\Models\Concejo;
use App\Models\Infante;
use App\Models\Jefe;
use App\Models\Parroquia;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        Comuna::factory(50)->create();
        Concejo::factory(200)->create();
        $this->call(ParroquiaSeeder::class);
        $this->call(CiudadanoSeeder::class);
        
    }
}
