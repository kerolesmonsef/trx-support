<?php

namespace App\Models;

use App\Traits\SLogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperGroup
 */
class Group extends Model
{
    use HasFactory, SLogActivity;

    protected $table = 'groups_a';

    protected $guarded = [];

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function lastUpdatedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_updated_user_id');
    }
}
