<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ProjectTask;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ProjectTask>
 */
final class ProjectTaskFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = ProjectTask::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'sort' => fake()->boolean,
            'user_id' => \App\Models\User::factory(),
            'project_id' => fake()->optional()->randomNumber(),
            'status' => fake()->word,
            'priority' => fake()->word,
            'title' => fake()->title,
            'content' => fake()->text,
            'deleted_at' => fake()->optional()->dateTime(),
        ];
    }
}
