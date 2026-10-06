<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Project>
 */
final class ProjectFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Project::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'number' => fake()->word,
            'user_id' => \App\Models\User::factory(),
            'budget' => fake()->optional()->randomFloat(),
            'balance' => fake()->optional()->randomFloat(),
            'currency' => fake()->currencyCode,
            'notes' => fake()->optional()->text,
            'status' => fake()->optional()->word,
            'sort' => fake()->boolean,
            'deleted_at' => fake()->optional()->dateTime(),
        ];
    }
}
