<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AccountDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\AccountDetails>
 */
final class AccountDetailsFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = AccountDetails::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'bank_details' => fake()->optional()->text,
            'mpesa_details' => fake()->optional()->word,
            'additional_notes' => fake()->optional()->text,
        ];
    }
}
