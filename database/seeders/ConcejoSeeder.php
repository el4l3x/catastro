<?php

namespace Database\Seeders;

use App\Models\Comuna;
use App\Models\Concejo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ConcejoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Concejo::factory(200)->create();
    }
}
