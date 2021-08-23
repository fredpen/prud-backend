<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        // super Admins
        User::factory()
            ->has(UserDetails::factory()->count(1), 'details')
            ->create(
                [
                    'surname' => "Super",
                    'first_name' => "Admin",
                    'email' => "fredricksola@gmail.com",
                    'role_id' => 1,
                    "isActive" => true
                ]
            );

        //Basic Admins
        User::factory()->create(
            [
                'surname' => "Basic",
                'first_name' => "Admin",
                'email' => "BasicAdmin@gmail.com",
                'role_id' => 2,
                "isActive" => true
            ]
        );

        // Trustees
        User::factory()->create(
            [
                'surname' => "Trustees",
                'first_name' => "Admin",
                'email' => "TrusteesAdmin@gmail.com",
                'role_id' => 3,
                "isActive" => true
            ]
        );

        // users
        User::factory()
            // ->has(UserDetails::factory()->count(1), 'details')
            ->count(20)
            ->create();
    }
}
