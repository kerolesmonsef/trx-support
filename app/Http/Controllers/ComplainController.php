<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderComplain;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    public function store(Order $order)
    {
        request()->validate([
            'description' => 'required|max:100',
            'complain_type_id' => 'required|exists:complain_types,id',
            'order_id' => 'required|exists:orders,order_id',
            'captcha' => 'required|captcha',
        ], [
            'description.required' => 'الوصف مطلوب . برجاء ادخال الوصف',
            'description.max' => 'الوصف يجب ان يكون اقل من 100 حرف',
            'complain_type_id.required' => 'النوع مطلوب . برجاء ادخال النوع',
            'complain_type_id.exists' => 'النوع غير موجود',
            'captcha.required' => "من فضلك ادخل الرمز بشكل صحيح",
            "captcha.captcha" => "الرمز الذي قمت بادخاله غير صحيح",
        ]);

        $order = Order::findByOrderId(request('order_id'));

        if ($order->hasPendingComplain()){
            return redirect()->back()->with('error', 'لقد قمت بإرسال الشكوى من قبل');
        }

        OrderComplain::create([
            'order_id' => $order->id,
            'complain_type_id' => request('complain_type_id'),
            'description' => request('description'),
        ]);

        return redirect()->back()->with('success', 'تم إرسال الشكوى بنجاح');
    }
}
