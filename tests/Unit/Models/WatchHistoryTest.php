<?php

declare(strict_types=1);

use App\Models\WatchHistory;

test('WatchHistory to array', function () {
    $watchHistory = WatchHistory::factory()->create()->refresh();

    expect(array_keys($watchHistory->toArray()))
        ->toBe([
            'id',
            'user_id',
            'video_id',
            'created_at',
            'updated_at',
        ]);
});

test('WatchHistory relationships', function () {
    $watchHistory = WatchHistory::factory()->create();

    expect($watchHistory->video)->not()->toBeNull();
    expect($watchHistory->user)->not()->toBeNull();
});
