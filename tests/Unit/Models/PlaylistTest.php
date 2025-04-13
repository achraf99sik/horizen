<?php

declare(strict_types=1);

use App\Models\Playlist;
use App\Models\User;

test('Like to array', closure: function () {
    $like = Playlist::factory()->has(User::factory()->count(4))->create()->refresh();

    expect(array_keys($like->toArray()))
        ->toBe([
            'id',
            'title',
            'description',
            'user_id',
            'created_at',
            'updated_at',
        ]);
});
