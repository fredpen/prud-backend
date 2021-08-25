<?php

namespace Database\Seeders;

use App\Models\Mba;
use App\Models\MbaBenefits;
use App\Models\MbaPhoto;
use Illuminate\Database\Seeder;

class MbaSeeder extends Seeder
{
    public function run()
    {
        Mba::factory()
            ->has(MbaPhoto::factory()->count(2), 'photos')
            ->has(MbaBenefits::factory()->count(4), 'benefits')
            ->count(10)
            ->create();
    }
}
