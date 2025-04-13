<?php

declare(strict_types=1);

use App\Models\Like;
use App\Models\User;
use App\Models\Video;

test('Like to array', function () {
    $video = Video::factory()->create();
    $user = User::factory()->create();

    $like = Like::factory()
        ->for($video)
        ->for($user)
        ->create();

    $like->video;
    $like->user;

    expect(array_keys($like->toArray()))
        ->toBe([
            'video_id',
            'user_id',
            'updated_at',
            'created_at',
            'id',
            'video',
            'user',
        ]);
});
