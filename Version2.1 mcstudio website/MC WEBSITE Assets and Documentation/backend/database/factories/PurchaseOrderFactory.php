<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\PurchaseOrder>
 */
final class PurchaseOrderFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = PurchaseOrder::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'number' => fake()->word,
            'total_price' => fake()->optional()->randomFloat(),
            'status' => fake()->randomElement(['new', 'processing', 'fulfilled', 'cancelled']),
            'currency' => fake()->currencyCode,
            'notes' => fake()->optional()->text,
        ];
    }
}
