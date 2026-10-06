<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Campaign>
 */
final class CampaignFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Campaign::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'number' => fake()->word,
            'customer_group_id' => \App\Models\CustomerGroups::factory(),
            'notes' => fake()->optional()->text,
        ];
    }
}
