<?php

declare(strict_types=1);

use App\Models\Video;

test('Video to array', function () {
    $video = Video::factory()->create()->refresh();

    expect(array_keys($video->toArray()))
        ->toBe([
            'id',
            'title',
            'subtitle',
            'media',
            'slug',
            'thumbnail',
            'description',
            'user_id',
            'category_id',
            'created_at',
            'updated_at',
        ]);
});

test('Video relationships', function () {
    $video = Video::factory()->create();

    expect($video->user)->not()->toBeNull();
    expect($video->category)->not()->toBeNull();
    expect($video->tags)->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class);
    expect($video->viewer)->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class);
});
