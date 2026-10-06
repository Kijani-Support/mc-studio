<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name       = fake()->name();
        $slug       = Str::slug($name);
        $price      = fake()->numberBetween(500, 2999);
        $cost       = (0.8 * $price);
        $type       = fake()->randomElement(['deliverable', 'downloadable']);
        $requires_shipping = $type === 'deliverable' ? true : false;

        return [
            'name'           => $name,
            'slug'           => $slug,
            'sku'            => $slug.'-'.fake()->numberBetween(11, 999),
            'barcode'        => fake()->ean8(),
            'description'    => fake()->paragraph(),
            'qty'            => fake()->numberBetween(15, 99),
            'security_stock' => 15,
            'featured'       => fake()->boolean(),
            'is_visible'       => fake()->boolean(),
            'price'            => $price,
            'cost'             => $cost,
            'type'             => $type,
            'backorder'        => fake()->boolean(20),
            'requires_shipping'=> $requires_shipping,
            'published_at'      => now(),
            'seo_title'         => fake()->title(),    
            'seo_description'   => fake()->text(160),
            'weight_value'      => fake()->randomFloat(1, 0.5, 10.0),
            'weight_unit'       => 'kg',
            'height_value'      => fake()->randomFloat(1, 0.2, 3.0),
            'height_unit'       => 'cm',
            'width_value'       => fake()->randomFloat(1, 0.2, 2.0),
            'width_unit'        => 'cm',
            'depth_value'       => fake()->randomFloat(1, 0.2, 5.0),
            'depth_unit'        => 'cm',
            'volume_value'      => fake()->randomFloat(1, 5, 20),
            'volume_unit'       => 'l',

        ];
    }
}
