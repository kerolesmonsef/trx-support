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

    public function show()
    {
        $order_id = request('order_id');
        $order = Order::where('order_id', $order_id)->first();
        if (!$order) {
            return redirect()->to("/")->with("error", "رقم الطلب خاطئ");
        }
        $order->update([
            'seen_at' => now()
        ]);

        return view('show_order', compact('order'));
    }
}
