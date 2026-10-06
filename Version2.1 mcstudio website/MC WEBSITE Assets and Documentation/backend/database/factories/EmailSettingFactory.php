<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\EmailSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\EmailSetting>
 */
final class EmailSettingFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = EmailSetting::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'host' => fake()->word,
            'port' => fake()->word,
            'auth' => fake()->word,
            'authtype' => fake()->word,
            'email-address' => fake()->word,
            'password' => bcrypt(fake()->password),
            'sender' => fake()->word,
        ];
    }
}
