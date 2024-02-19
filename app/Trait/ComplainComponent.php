<?php

namespace App\Trait;

use App\Models\OrderComplain;

trait ComplainComponent
{
    public ?OrderComplain $orderComplain = null;

    public function showComplain($order_complain_id)
    {
        $this->orderComplain = OrderComplain::find($order_complain_id);
    }

    public function deleteComplain($order_complain_id)
    {
        OrderComplain::find($order_complain_id)->delete();
        $this->orderComplain = null;
    }

    public function updateStatus($status)
    {
        $this->orderComplain->update([
            'status' => $status,
        ]);
        session()->flash('message', "تم تحديث الحالة بنجاح");
    }

}
