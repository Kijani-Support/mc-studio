<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\StockReturn;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\StockReturn>
 */
final class StockReturnFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = StockReturn::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'number' => 'SR-' . str_pad((string)fake()->randomNumber(), 8, (string)0, STR_PAD_LEFT),
            'user_id' => \App\Models\User::factory(),
            'purchase_order_id' => \App\Models\PurchaseOrder::factory(),
            'order_id' => \App\Models\Order::factory(),
            'product_id' => fake()->optional()->randomNumber(),
            'total_price' => fake()->optional()->randomFloat(),
            'currency' => fake()->optional()->currencyCode,
            'status' => fake()->randomElement(['new', 'processing', 'returned', 'cancelled']),
            'notes' => fake()->optional()->text,
        ];
    }
}
