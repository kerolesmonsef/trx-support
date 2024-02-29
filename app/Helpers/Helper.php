<?php

namespace App\Helpers;

use Illuminate\Database\Events\QueryExecuted;
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

    public static function onUpdateValidationArray($coupons): array
    {
        $couponIds = array_map(function ($coupon) {
            return $coupon['id'] ?? null;
        }, $coupons);

        $couponIds = array_filter($couponIds);
        return [
            'order_id' => "required",
            'price' => ['required'],
            'coupons.*.code' => ['required', Rule::unique('coupons', 'code')->where(function ($query) use ($couponIds) {
                $query->whereNotIn('id', $couponIds);
                return $query;
            })],
        ];
    }

    public static function onCreateCouponValidationArray(): array
    {
        return [
            'order_id' => 'required',
            'coupons.*.code' => ['required', 'unique:coupons,code'],
        ];
    }

    public static function  getQueries($builder)
    {
        if ($builder instanceof QueryExecuted){
            $addSlashes = str_replace('?', "'?'", $builder->sql);
            return vsprintf(str_replace('?', '%s', $addSlashes), $builder->bindings);
        }
        $addSlashes = str_replace('?', "'?'", $builder->toSql());
        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }
}
