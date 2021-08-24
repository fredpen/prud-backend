<?php

namespace Database\Factories;

use App\Models\Mba;
use Illuminate\Database\Eloquent\Factories\Factory;

class MbaFactory extends Factory
{
    protected $model = Mba::class;

    public function definition()
    {
        return [
            'name' => $this->faker->city(),
            'status' => $this->faker->randomElement([true, false])
        ];
    }
}
