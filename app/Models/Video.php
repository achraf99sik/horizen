<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Video extends Model
{
    /** @use HasFactory<\Database\Factories\VideoFactory> */
    use HasFactory;

    /**
     * Get the category this video belong to
     * @return BelongsTo<Category, Video>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get this video owner
     * @return BelongsTo<user, Video>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class);
    }
}
