<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quotation>
 */
class QuotationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => 'QO-' . str_pad(fake()->randomNumber(), 8, 0, STR_PAD_LEFT),
            'total_price' => fake()->randomNumber(),
            'currency' => fake()->currencyCode,
            'status'  => 'new'
        ];
    }
}
