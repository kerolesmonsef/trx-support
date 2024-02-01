<?php

namespace App\Livewire;

use App\Models\Coupon;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $order_id = "";
    public $price = "0";
    public $order = ""; // create or update
    public $coupons = [];

    public function render()
    {
        return view('livewire.orders', [
            'orders' => Order::query()->withCount("coupons")->orderByDesc('id')->paginate(20),
            'order' => Order::find($this->order),
        ]);
    }

    public function save()
    {
        if ($this->order) {
            $this->validate([
                'order_id' => "required|unique:orders,order_id,{$this->order}",
                'price' => ['required'],
            ]);

            $order = Order::find($this->order);
        } else { // create
            $this->validate([
                'order_id' => 'required|unique:orders'
            ]);
            $order = Order::create([
                'order_id' => $this->order_id,
                'price' => $this->price
            ]);
        }

        session()->flash('message', 'تم الحفظ بنجاح');
        $this->saveCoupons($order);
        $this->coupons = [];
        $this->order = "";
        $this->order_id = "";
        $this->price = "0";
    }

    public function delete($order_id){
        Order::find($order_id)->delete();
        session()->flash('message', 'تم الحذف بنجاح');
    }

    public function edit($order_id)
    {
        $order = Order::find($order_id);
        $this->order = $order->id;
        $this->order_id = $order->order_id;
        $this->price = $order->price;
        $this->coupons = Coupon::where('order_id', $order_id)->get()->toArray();
    }
    protected function saveCoupons(Order $order)
    {
        $order->coupons()->delete();
        foreach ($this->coupons as $coupon) {
            Coupon::create([
                'order_id' => $order->id,
                'price' => $coupon['price'],
                'code' => $coupon['code'],
            ]);
        }
    }

    public function addCoupon()
    {
        $this->coupons[] = [
            'price' => 0,
            'code' => ''
        ];
    }

    public function deleteCoupon($index)
    {
        array_splice($this->coupons, $index, 1);
    }
}
