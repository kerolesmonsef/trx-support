<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function hasSecurity(): bool
    {
        return $this->secure_phone || $this->secure_password;
    }
}
