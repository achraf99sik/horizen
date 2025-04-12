<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->sentence,
            "descrition" => $this->faker->paragraph,
            "subtitle" => $this->faker->filePath(),
            "media" => $this->faker->filePath(),
            "thumbnail" => $this->faker->filePath(),
            "user_id" => User::factory(),
            "category_id" => Category::factory(),
        ];
    }
}
