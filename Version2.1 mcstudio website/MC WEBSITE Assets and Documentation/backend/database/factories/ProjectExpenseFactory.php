<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ProjectExpense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ProjectExpense>
 */
final class ProjectExpenseFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = ProjectExpense::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'sort' => fake()->boolean,
            'project_id' => fake()->optional()->randomNumber(),
            'name' => fake()->optional()->name,
            'qty' => fake()->randomNumber(),
            'unit_price' => fake()->randomFloat(),
            'total' => fake()->randomFloat(),
            'currency' => fake()->currencyCode,
            'deleted_at' => fake()->optional()->dateTime(),
        ];
    }
}
