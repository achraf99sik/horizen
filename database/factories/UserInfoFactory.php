<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Nationality;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
final class UserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nationality_id' => Nationality::factory(),
            'sex' => $this->faker->randomElement(['M', 'F']),
            'about' => $this->faker->paragraph,
            'date_birth' => $this->faker->date,
        ];
    }
}
