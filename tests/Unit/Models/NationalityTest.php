<?php

declare(strict_types=1);

use App\Models\Nationality;
use App\Models\UserInfo;

test('Nationality to array', closure: function () {
    $nationality = Nationality::factory()->has(UserInfo::factory()->count(4))->create()->refresh();

    expect(array_keys($nationality->toArray()))
        ->toBe([
            'id',
            'name',
            'created_at',
            'updated_at',
        ]);
});
