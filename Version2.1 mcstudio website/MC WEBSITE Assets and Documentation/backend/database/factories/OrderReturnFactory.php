<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\OrderReturn;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\OrderReturn>
 */
final class OrderReturnFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = OrderReturn::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'number' => 'OR-' . str_pad((string)fake()->randomNumber(), 8, (string)0, STR_PAD_LEFT),
            'customer_id' => \App\Models\User::factory(),
            'order_id' => \App\Models\Order::factory(),
            'reason' => fake()->text,
            'status' => fake()->randomElement(['new', 'processing', 'returned', 'cancelled']),
        ];
    }
}
