<?php

namespace Database\Factories;

use App\Models\SubTask;
use App\Models\Tasks;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubTaskFactory extends Factory
{
    protected $model = SubTask::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->jobTitle(),
            'task_id' => Tasks::inRandomOrder()->first(),
        ];

    }
}
