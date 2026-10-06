<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $slug = str()->slug($name);

        return [
            'name'          => $name,
            'slug'          => $slug,
            'description'   => fake()->paragraph(),
            'position'      => fake()->numberBetween(0, 15),
            'is_visible'    => fake()->boolean(70),
            'seo_title'     => fake()->title(),
            'seo_description'  => fake()->text(160),
        ];
    }
}
