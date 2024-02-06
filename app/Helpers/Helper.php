<?php

namespace App\Helpers;

use Illuminate\Validation\Rule;

class Helper
{

    public static function removeCaptchaSession()
    {
        $keys = session()->all();

        $prefixToRemove = 'captcha_order';

        foreach ($keys as $key => $value) {
            if (str_starts_with($key, $prefixToRemove)) {
                session()->forget($key);
            }
        }

    }

    public static function validateCaptcha($order_id)
    {

        request()->validate([
            'captcha' => 'required|captcha',
        ], [
            'captcha.required' => "من فضلك ادخل الرمز بشكل صحيح",
            "captcha.captcha" => "الرمز الذي قمت بادخاله غير صحيح",
        ]);

        session()->put("captcha_order_{$order_id}","pass");
    }

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
