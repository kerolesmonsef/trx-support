<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function refresh()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    public function check()
    {
        return response()->json(['captcha' => captcha_check(request('captcha',''))]);
    }
}
