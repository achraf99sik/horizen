<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
final class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'text' => $this->faker->sentence,
            'video_id' => Video::factory(),
            'comment_id' => null,
            'user_id' => User::factory(),
        ];
    }

    public function withParent(Comment $parent): static
    {
        return $this->state([
            'comment_id' => $parent->id,
        ]);
    }
}

