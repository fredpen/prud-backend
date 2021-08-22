<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run()
    {
        // Country::factory()
        //     ->count(10)
        //     ->has(Region::factory()->count(5), 'regions')
        //     ->has(City::factory()->count(5), 'cities')
        //     ->create();
    }
}
