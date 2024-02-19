<?php

namespace App\Models;

use App\Traits\SLogActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperOrder
 */
class Order extends Model
{
    use HasFactory, SLogActivity;

    protected $guarded = [];

    public static function findByOrderId($order_id): ?Model
    {
        return self::where("order_id", $order_id)->first();
    }

    public function complains(): HasMany
    {
        return $this->hasMany(OrderComplain::class,'order_id');
    }

    public function hasPendingComplain(): bool
    {
        return $this->complains()->where("order_complains.status", "pending")->exists();
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function hasSecurity(): bool
    {
        return $this->secure_phone || $this->secure_password;
    }

    public function coupons_price()
    {
        return $this->coupons->sum("price");
    }

    public function account(): HasOne
    {
        return $this->hasOne(Account::class);
    }

    public function hasAccount(): bool
    {
        return !!$this->account;
    }

    public function hasCoupons(): bool
    {
        return $this->coupons->isNotEmpty();
    }
}
