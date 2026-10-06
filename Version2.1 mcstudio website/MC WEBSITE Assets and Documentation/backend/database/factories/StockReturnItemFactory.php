<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\StockReturnItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\StockReturnItem>
 */
final class StockReturnItemFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = StockReturnItem::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'sort' => fake()->randomNumber(),
            'stock_return_id' => fake()->optional()->randomNumber(),
            'product_id' => fake()->optional()->randomNumber(),
            'qty' => fake()->randomNumber(),
            'cost_price' => fake()->randomFloat(),
        ];
    }
}
