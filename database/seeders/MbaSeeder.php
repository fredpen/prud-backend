<?php

namespace Database\Seeders;

use App\Models\Mba;
use Illuminate\Database\Seeder;

class MbaSeeder extends Seeder
{
    public function run()
    {
        Mba::factory()
            // ->has(UserDetails::factory()->count(1), 'details')
            ->count(10)
            ->create();
    }
}
