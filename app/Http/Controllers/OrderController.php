<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function security_show($order_id)
    {
        $order = Order::where('order_id', $order_id)->first();
        if (!$order) {
            return redirect()->to("/")->with("error", "رقم الطلب خاطئ");
        }

        if (!$order->secure_phone && !$order->secure_password) {
            return redirect()->route("orders.orders.show")->with("order_id", $order_id);
        }

        return view('order_security', [
            'order' => $order,
        ]);
    }


    public function show()
    {
        $order_id = request('order_id');
        $order = Order::where('order_id', $order_id)->first();
        if (!$order) {
            return redirect()->to("/")->with("error", "رقم الطلب خاطئ");
        }

        if ($order->secure_phone || $order->secure_password) {
            if (!request('security') || ($order->secure_phone != request('security') && $order->secure_password != request('security'))) {
                return redirect()->route('orders.security', ['order_id' => $order_id])->with('error', 'الرقم السري خاطئ');
            }
        }

        $order->update([
            'seen_at' => now()
        ]);

        return view('show_order', compact('order'));
    }
}
