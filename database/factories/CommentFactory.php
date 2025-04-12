<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "text" => $this->faker->sentence,
            "video_id" => Video::factory(),
            "comment_id" => Comment::factory(),
            "user_id" => User::factory(),
        ];
    }
}
