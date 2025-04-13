<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    /**
     * Summary of video
     * @return BelongsToMany<Video, Tag, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function video(): BelongsToMany
    {
        return $this->belongsToMany(Video::class);
    }
}
