<?php

declare(strict_types=1);

use App\Models\Tag;
use App\Models\Video;

test('Tag to array', function () {
    $video = Video::factory()->create();
    $tag = Tag::factory()->create();

    $tag->videos()->attach($video->id);

    $tag->videos;

    expect(array_keys($tag->toArray()))
        ->toBe([
            'name',
            'updated_at',
            'created_at',
            'id',
            'videos',
        ]);
});
