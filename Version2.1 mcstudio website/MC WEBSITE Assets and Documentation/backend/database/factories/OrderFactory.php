<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Order>
 */
final class OrderFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Order::class;

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
            'status' => fake()->randomElement(['new', 'processing', 'shipped', 'delivered', 'cancelled']),
            'currency' => fake()->currencyCode,
            'shipping_price' => fake()->optional()->randomFloat(),
            'shipping_method' => fake()->optional()->word,
            'notes' => fake()->optional()->text,
            'quotation_id' => \App\Models\Quotation::factory(),
        ];
    }
}
