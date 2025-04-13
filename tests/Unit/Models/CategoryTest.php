<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Video;

it('category to array', function () {
    $category = Category::factory()->has(Video::factory()->count(3))->create()->refresh();

    expect(array_keys($category->toArray()))
        ->toBe([
            'id',
            'name',
            'created_at',
            'updated_at',
        ]);
});
