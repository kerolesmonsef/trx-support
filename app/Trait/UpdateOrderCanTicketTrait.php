<?php

namespace App\Trait;

use App\Models\Order;

trait UpdateOrderCanTicketTrait
{
    public function updateOrderCanTicket($order_id)
    {
        $order = Order::query()->find($order_id);
        $order?->update([
            'can_ticket' => !$order?->can_ticket,
        ]);
        session()->flash('message', 'تم تحديث الحالة بنجاح');
    }
}
