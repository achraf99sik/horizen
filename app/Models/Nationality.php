<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Nationality extends Model
{
    /** @use HasFactory<\Database\Factories\NationalityFactory> */
    use HasFactory;

    /**
     * Get all the users with this nationality
     *
     * @return HasMany<UserInfo, $this>
     */
    public function userInfo(): HasMany
    {
        return $this->hasMany(UserInfo::class);
    }
}
