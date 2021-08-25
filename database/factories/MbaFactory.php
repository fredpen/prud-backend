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
            'price_per_unit' => $this->faker->randomFloat(2, 100, 10000),
            'available_unit' => $this->faker->numberBetween(2, 10),
            'term' => $this->faker->randomElement([12, 24, 36]),
            'status' => $this->faker->randomElement([true, false])
        ];
    }
}
