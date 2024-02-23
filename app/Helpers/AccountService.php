<?php

namespace App\Helpers;

use App\Models\Group;
use App\Models\Order;

class AccountService
{
    public function store(Group $group, array $accountArray): void
    {
        $order = Order::create([
            'order_id' => $accountArray['order_id'],
            'secure_phone' => $accountArray['secure_phone'],
            'note' => $accountArray['note'],
        ]);
        $group->accounts()->create([
            'order_id' => $order->id,
            'profile' => $accountArray['profile'],
            'subscription_expire_at' => $accountArray['subscription_expire_at'],
        ]);
    }
}
