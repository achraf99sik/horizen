<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class Like extends Model
{
    /** @use HasFactory<\Database\Factories\LikeFactory> */
    use HasFactory;

    /**
     * Get the video who owns this like
     * @return HasOne<Video, Like>
     */
    public function video(): HasOne
    {
        return $this->HasOne(Video::class);
    }
    /**
     * Get the user who give this like
     * @return BelongsTo<User, Like>
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
