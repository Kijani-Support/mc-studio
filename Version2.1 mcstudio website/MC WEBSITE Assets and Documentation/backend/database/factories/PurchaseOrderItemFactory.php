<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PurchaseOrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\PurchaseOrderItem>
 */
final class PurchaseOrderItemFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = PurchaseOrderItem::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'sort' => fake()->randomNumber(),
            'purchase_order_id' => fake()->optional()->randomNumber(),
            'product_id' => fake()->optional()->randomNumber(),
            'qty' => fake()->randomNumber(),
            'cost_price' => fake()->randomFloat(),
        ];
    }
}
