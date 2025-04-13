<?php

declare(strict_types=1);

use App\Models\UserInfo;

test('UserInfo to array', function () {
    $userInfo = UserInfo::factory()->create()->refresh();

    $userInfo->user;
    $userInfo->nationality;

    expect(array_keys($userInfo->toArray()))
        ->toBe([
            'id',
            'user_id',
            'nationality_id',
            'about',
            'date_birth',
            'sex',
            'created_at',
            'updated_at',
            'user',
            'nationality',
        ]);
});

