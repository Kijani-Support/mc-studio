<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->company();
        $slug = Str::slug($name);

        return [
            'name'          => $name,
            'slug'          => $slug,
            'website'       => fake()->url(),
            'description'   => fake()->paragraph(),
            'position'      => fake()->numberBetween(0, 20),
            'is_visible'    => fake()->boolean(),
            'seo_title'     => fake()->title(),
            'seo_description' => fake()->text(160),
            'sort'          => fake()->randomDigit()
        ];
    }
}
