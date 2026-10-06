<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CampaignItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\CampaignItem>
 */
final class CampaignItemFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = CampaignItem::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'campaign_id' => fake()->optional()->randomNumber(),
            'product_id' => fake()->optional()->randomNumber(),
            'qty' => fake()->randomNumber(),
            'unit_price' => fake()->randomFloat(),
            'deleted_at' => fake()->optional()->dateTime(),
        ];
    }
}
