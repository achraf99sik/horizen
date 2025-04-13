<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Video;
use App\Models\Comment;

it('comment to array', function () {
    $comment = Comment::factory()
        ->for(Video::factory())
        ->for(User::factory())
        ->has(Comment::factory(), 'comment')
        ->create();

    // Trigger the relationships so they're counted in coverage
    $comment->video;
    $comment->user;
    $comment->comment;

    expect(array_keys($comment->toArray()))
        ->toBe([
            'text',
            'video_id',
            'comment_id',
            'user_id',
            'updated_at',
            'created_at',
            'id',
            'video',
            'user',
            'comment',
        ]);
});
