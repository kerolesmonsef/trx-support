<?php

namespace App\Helpers;

use Illuminate\Validation\Rule;

class CouponValidationHelper
{
    public static function onUpdateValidationArray($coupons, $order_id): array
    {
        $couponIds = array_map(function ($coupon) {
            return $coupon['id'] ?? null;
        }, $coupons);

        $couponIds = array_filter($couponIds);
        return [
            'order_id' => "required|unique:orders,order_id,{$order_id}",
            'price' => ['required'],
            'coupons.*.code' => ['required', Rule::unique('coupons', 'code')->where(function ($query) use ($couponIds) {
                $query->whereNotIn('id', $couponIds);
                return $query;
            })],
        ];
    }

    public static function onCreateValidationArray(): array
    {
        return [
            'order_id' => 'required|unique:orders',
            'coupons.*.code' => ['required', 'unique:coupons,code'],
        ];
    }
}
