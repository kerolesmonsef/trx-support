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

        if ($order->hasAccount() and $order->account->isSubscriptionExpired()) {
            return redirect()->to("/")->withInput(['order_id' => $order_id])->with("error_pup_up", " تم انتهاء اشتراكك ولايمكنك دخول الى طلبك");
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

//        if (!session()->has("captcha_order_{$order_id}")) {
//            return redirect()->to("/")->with("error", "الرمز الذي قمت بادخاله غير صحيح");
//        }


        if ($order->secure_phone != request('security')) {
            return redirect()->route("orders.security", ["order_id" => $order_id])->with("error", "رقم جوال غير صحيح");
        }

        $order->update([
            'seen_at' => now()
        ]);

        return view('show_order', compact('order'));
    }


    public function uuid_show($uuid)
    {
        $order = Order::where('uuid', $uuid)->first();

        if (!$order) {
            return redirect()->to("/")->with("error", "رقم الطلب خاطئ");
        }

        $order->timestamps = false;

        $order->update([
            'seen_at' => now()
        ]);

        $order->touch();

        return view('show_order', compact('order'));
    }

    public function show($order_id)
    {
        $order = Order::where('order_id', $order_id)->first();

        if (!$order) {
            return redirect()->to("/")->with("error", "رقم الطلب خاطئ");
        }


        $order->timestamps = false;

        if ($order->hasSecurity()) {
            return redirect()->route("orders.security", ["order_id" => $order_id]);
        }

        $order->update([
            'seen_at' => now()
        ]);

        $order->touch();

        return view('show_order', compact('order'));
    }
}
