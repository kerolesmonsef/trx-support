<?php

namespace App\Models;

use App\Traits\SLogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCoupon
 */
class Coupon extends Model
{
    use HasFactory , SLogActivity;
    protected $guarded = [];
}
