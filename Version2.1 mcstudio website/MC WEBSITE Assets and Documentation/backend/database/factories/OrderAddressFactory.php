<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\OrderAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\OrderAddress>
 */
final class OrderAddressFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = OrderAddress::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'addressable_type' => fake()->word,
            'addressable_id' => fake()->randomNumber(),
            'country' => fake()->optional()->country,
            'street' => fake()->optional()->streetName,
            'city' => fake()->optional()->city,
            'state' => fake()->optional()->state,
            'zip' => fake()->optional()->postcode,
        ];
    }
}
