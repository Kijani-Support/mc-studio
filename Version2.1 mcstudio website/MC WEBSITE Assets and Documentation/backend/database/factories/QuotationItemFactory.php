<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use App\Models\QuotationItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\QuotationItem>
 */
final class QuotationItemFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = QuotationItem::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'sort' => fake()->randomNumber(),
            'quotation_id' => fake()->optional()->randomNumber(),
            'product_id' => Product::factory()->make(),
            'qty' => fake()->randomNumber(),
            'unit_price' => fake()->randomFloat(),
        ];
    }
}
