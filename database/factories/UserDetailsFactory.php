<?php

namespace Database\Factories;

use App\Models\UserDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDetailsFactory extends Factory
{
    protected $model = UserDetails::class;

    public function definition()
    {
        return [
            'bank_name' => $this->faker->company,
            'sort_code' => $this->faker->numberBetween(3000, 5000),
            'account_number' => $this->faker->bankAccountNumber,
            'account_name' =>  $this->faker->name(),
            "kin_surname" => $this->faker->lastName,
            'kin_firstname' => $this->faker->firstName,
            "kin_email" => $this->faker->email,
            "kin_phone" => $this->faker->phoneNumber,
        ];
    }
}
