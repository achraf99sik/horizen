<?php

declare(strict_types=1);

use App\Models\Nationality;
use App\Models\UserInfo;

test('Like to array', closure: function () {
    $like = Nationality::factory()->has(UserInfo::factory()->count(4))->create()->refresh();

    expect(array_keys($like->toArray()))
        ->toBe([
            'id',
            'name',
            'created_at',
            'updated_at',
        ]);
});
