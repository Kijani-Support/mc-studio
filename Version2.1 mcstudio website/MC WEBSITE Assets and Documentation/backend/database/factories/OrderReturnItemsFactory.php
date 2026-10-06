<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\OrderReturnItems;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\OrderReturnItems>
 */
final class OrderReturnItemsFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = OrderReturnItems::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'order_return_id' => fake()->optional()->randomNumber(),
            'product_id' => fake()->optional()->randomNumber(),
            'qty' => fake()->randomNumber(),
            'unit_price' => fake()->randomFloat(),
        ];
    }
}
