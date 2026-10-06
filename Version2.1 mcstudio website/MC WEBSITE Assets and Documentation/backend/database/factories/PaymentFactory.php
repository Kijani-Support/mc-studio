<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Payment>
 */
final class PaymentFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Payment::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::factory(),
            'reference' => fake()->word,
            'provider' => fake()->word,
            'method' => fake()->word,
            'amount' => fake()->randomFloat(),
            'currency' => fake()->currencyCode,
            'phone' => fake()->optional()->phoneNumber,
            'name' => fake()->optional()->name,
            'number' => fake()->optional()->word,
        ];
    }
}
