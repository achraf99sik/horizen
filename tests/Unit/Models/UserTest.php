<?php

declare(strict_types=1);

use App\Models\User;

it('user to array', function () {
    $user = User::factory()->create()->refresh();
    $user->payload();

    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'name',
            'email',
            'email_verified_at',
            'role',
            'created_at',
            'updated_at',
        ]);
});
