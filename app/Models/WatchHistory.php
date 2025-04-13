<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class WatchHistory extends Model
{
    /** @use HasFactory<\Database\Factories\WatchHistoryFactory> */
    use HasFactory;

    /**
     * The video associated with this watch history.
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * The user who watched the video.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
