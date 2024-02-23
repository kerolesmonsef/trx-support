<?php

namespace App\Models;

use App\Traits\SLogActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperAccount
 */
class Account extends Model
{
    use HasFactory, SLogActivity;

    protected $table = "accounts";
    protected $guarded = [];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function isSubscriptionExpired(): bool
    {
        if (!$this->subscription_expire_at) {
            return false;
        }

        return Carbon::parse($this->subscription_expire_at)->isPast();
    }
}
