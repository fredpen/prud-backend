<?php

namespace Database\Factories;

use App\Models\MbaBenefits;
use Illuminate\Database\Eloquent\Factories\Factory;

class MbaBenefitsFactory extends Factory
{
    protected $model = MbaBenefits::class;

    public function definition()
    {
        return [
            "body" => $this->faker->sentence(12)
        ];
    }
}
