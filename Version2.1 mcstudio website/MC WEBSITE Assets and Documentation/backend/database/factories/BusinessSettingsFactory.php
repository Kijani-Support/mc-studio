<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BusinessSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\BusinessSettings>
 */
final class BusinessSettingsFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = BusinessSettings::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->safeEmail,
            'phone' => fake()->phoneNumber,
            'address' => fake()->address,
            'country' => fake()->country,
            'city' => fake()->city,
            'pobox' => fake()->word,
        ];
    }
}
