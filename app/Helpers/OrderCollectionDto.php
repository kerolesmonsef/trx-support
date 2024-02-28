<?php

namespace App\Helpers;

use App\Models\Order;
use Illuminate\Support\Collection;
use function Laravel\Prompts\select;

class OrderCollectionDto
{
    /**
     * @param \Illuminate\Database\Eloquent\Collection| array<int, Order>|Collection $orders
     */
    public function __construct(private $orders)
    {
    }

    public static function related(Order $order): OrderCollectionDto
    {
        $orders = Order::where("order_id", $order->order_id)
            ->with("account", "coupons")
            ->get();

        return new self($orders);
    }

    public function getOrderId(): ?string
    {
        return $this->orders->first()->order_id;
    }



    public function haveAccount(): bool
    {
        foreach ($this->orders as $order) {
            if ($order->account) {
                return true;
            }
        }
        return false;
    }

    public function haveCoupons(): bool
    {
        foreach ($this->orders as $order) {
            if ($order->coupons->isNotEmpty()) {
                return true;
            }
        }
        return false;
    }

    public function haveAny(): bool
    {
        return $this->haveAccount() || $this->haveCoupons();
    }

    public function coupons()
    {
        return $this->orders->pluck("coupons")->flatten();
    }

    /**
     * @return Collection<int, \App\Models\Account>|\Illuminate\Database\Eloquent\Collection|array<int, \App\Models\Account>
     */
    public function accounts()
    {
        return $this->orders->pluck("account")->filter(function ($account){
            return !!$account;
        });
    }
}
