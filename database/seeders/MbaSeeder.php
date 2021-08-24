<?php

namespace Database\Seeders;

use App\Models\Mba;
use App\Models\MbaPhoto;
use Illuminate\Database\Seeder;

class MbaSeeder extends Seeder
{
    public function run()
    {
        Mba::factory()
            ->has(MbaPhoto::factory()->count(2), 'photos')
            ->count(10)
            ->create();
    }
}
