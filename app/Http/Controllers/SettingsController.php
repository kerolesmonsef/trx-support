<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:settings");
    }

    public function index()
    {
        return view('settings');
    }

    public function update()
    {
        Settings::sync('coupon_privacy_policy', request('coupon_privacy_policy'));
        Settings::sync('account_privacy_policy', request('account_privacy_policy'));
        Settings::sync('complain_terms_and_conditions', request('complain_terms_and_conditions'));
        Settings::sync('whatsapp', request('whatsapp'));
        Settings::sync('telegram', request('telegram'));

        return redirect()->route("settings.index");
    }
}
