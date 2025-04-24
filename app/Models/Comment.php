<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    /**
     * Get the video that has the comment
     *
     * @return BelongsTo<Video, $this>
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * Get the comments of the comment
     *
     * @return HasMany<Comment, $this>
     */
    public function comment(): HasMany
    {
        return $this->hasMany(self::class);
    }

    /**
     * Get the commentator
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
