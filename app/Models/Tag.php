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
     * The videos that belong to the tag.
     * @return BelongsToMany<Video>
     */
    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class);
    }
}
