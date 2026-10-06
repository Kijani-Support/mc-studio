<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Transaction>
 */
final class TransactionFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Transaction::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'number' => 'TR-'. str_pad((string)fake()->randomNumber(), 8, (string)0, STR_PAD_LEFT),
            'payment_reference' => fake()->optional()->word,
            'order_id' => \App\Models\Order::factory(),
            'purchase_order_id' => \App\Models\PurchaseOrder::factory(),
            'type' => fake()->randomElement(['expense', 'income']),
            'method' => fake()->randomElement(['cash', 'mpesa', 'bank']),
            'amount' => fake()->randomFloat(),
            'currency' => fake()->currencyCode,
            'note' => fake()->optional()->sentence,
        ];
    }
}
