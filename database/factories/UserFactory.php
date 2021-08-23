<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $valid = rand(0, 1) == 1;

        return [
            'surname' => $this->faker->name(),
            'first_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' =>  $this->faker->phoneNumber,
            "address" => $this->faker->address,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            "avatar" => $valid ? $this->faker->imageUrl() : null,
            "title" => $valid ?  $this->faker->sentence(10) : null,
        ];
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
