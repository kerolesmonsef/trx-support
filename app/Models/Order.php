<?php

namespace App\Models;

use App\Traits\SLogActivity;
use Carbon\Carbon;
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

    public static function findByOrderId($order_id): null|Model|Order
    {
        return self::where("order_id", $order_id)->first();
    }

    public function complains(): HasMany
    {
        return $this->hasMany(OrderComplain::class, 'order_id');
    }

    public function hasPendingComplain(): bool
    {
        return $this->complains()->where("order_complains.status", "pending")->exists();
    }

    public function isBefore48HourFromLastPendingComplain(): bool
    {
        $lastComplain = $this->complains()->where("order_complains.status", "pending")->latest('id')->first();
        if (!$lastComplain) {
            return false;
        }
        return Carbon::parse($lastComplain->created_at)->diffInHours(now()) < 48;
    }

    public function lastPendingComplainDateForSupport(): ?string
    {
        $lastComplain = $this->complains()->where("order_complains.status", "pending")->latest('id')->first();
        if (!$lastComplain) {
            return now()->format("Y-m-d");
        }
        return Carbon::parse($lastComplain->created_at)->addDays(2)->format("Y-m-d H:i");
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(OrderNote::class);
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

    public function lastNoteUserName(): string
    {
        if ($this->notes->isNotEmpty()) {
            return $this->notes->last()->user->name;
        }
        return "";
    }
}
