<?php

namespace Database\Factories;

use App\Models\MbaPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class MbaPhotoFactory extends Factory
{

    protected $model = MbaPhoto::class;

    public function definition()
    {
        return [
            'url' => $this->faker->imageUrl(),
        ];
    }
}
