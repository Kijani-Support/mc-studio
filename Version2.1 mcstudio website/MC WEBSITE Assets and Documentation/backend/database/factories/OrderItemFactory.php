<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\OrderItem>
 */
final class OrderItemFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = OrderItem::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'sort' => fake()->randomNumber(),
            'order_id' => fake()->optional()->randomNumber(),
            'product_id' => fake()->optional()->randomNumber(),
            'qty' => fake()->randomNumber(),
            'unit_price' => fake()->randomFloat(),
        ];
    }
}
