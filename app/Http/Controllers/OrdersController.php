<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function welcome()
    {
        Helper::removeCaptchaSession();

        return view('welcome');
    }

    public function check_if_order_has_security()
    {
        $order_id = request('order_id');
        $order = Order::where('order_id', $order_id)->first();
        if (!$order) {
            return redirect()->to("/")->with("error", "رقم الطلب خاطئ");
        }

        Helper::validateCaptcha($order_id);

        if (!$order->hasSecurity()) {
            return redirect()->route("orders.show", ['order_id' => $order_id]);
        }

        return redirect()->route("orders.security", ["order_id" => $order_id]);
    }


    public function show_security($order_id)
    {
        $order = Order::where('order_id', $order_id)->first();
        if (!$order) {
            return redirect()->to("/")->with("error", "رقم الطلب خاطئ");
        }

        return view('order_security', [
            'order' => $order,
        ]);
    }


    public function validate_security($order_id)
    {
        $order = Order::where('order_id', $order_id)->first();

        if (!$order) {
            return redirect()->route("orders.security", ["order_id" => $order_id])->with("error", "رقم الطلب خاطئ");
        }

        if (!session()->has("captcha_order_{$order_id}")) {
            return redirect()->to("/")->with("error", "الرمز الذي قمت بادخاله غير صحيح");
        }


        if ($order->secure_phone != request('security') && $order->secure_password != request('security')) {
            return redirect()->route("orders.security", ["order_id" => $order_id])->with("error", "رقم السري خاطئ");
        }

        $order->update([
            'seen_at' => now()
        ]);

        return view('show_order', compact('order'));
    }

    public function show($order_id)
    {
        $order = Order::where('order_id', $order_id)->first();

        if (!$order) {
            return redirect()->to("/")->with("error", "رقم الطلب خاطئ");
        }

        if ($order->hasSecurity()) {
            return redirect()->route("orders.security", ["order_id" => $order_id]);
        }

        $order->update([
            'seen_at' => now()
        ]);

        return view('show_order', compact('order'));
    }
}
