<?php

namespace App\Livewire;

use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $order_id = "";
    public $price = "0";
    public $note = "";
    public $order = ""; // create or update
    public $coupons = [];

    public $search = '';
    public $seen_type = 'all';
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.orders', [
            'orders' => $this->getOrders(),
            'order' => Order::find($this->order),
        ]);
    }

    protected function getOrders()
    {
        $query = Order::query()
            ->when($this->search, function (Builder $builder) {
                $builder->where('order_id', 'like', '%' . $this->search . '%');
            })
            ->withCount("coupons")
            ->orderByDesc('id');

        if ($this->seen_type == "seen") {
            $query->whereNotNull('seen_at');
        } elseif ($this->seen_type == "unseen") {
            $query->whereNull('seen_at');
        }
        return $query->paginate(20);
    }

    public function save()
    {
        if ($this->order) {// update

            $couponIds = array_map(function ($coupon) {
                return $coupon['id'] ?? null;
            }, $this->coupons);

            $couponIds = array_filter($couponIds);


            $this->validate([
                'order_id' => "required|unique:orders,order_id,{$this->order}",
                'price' => ['required'],
                'coupons.*.code' => ['required', Rule::unique('coupons', 'code')->where(function ($query) use ($couponIds) {
                    $query->whereNotIn('id', $couponIds);
                    return $query;
                })
                ],
            ]);


            $order = Order::find($this->order);
            $order->update([
                'order_id' => $this->order_id,
                'price' => $this->price,
                'note' => $this->note,
            ]);
        } else { // create
            $this->validate([
                'order_id' => 'required|unique:orders'
            ]);
            $order = Order::create([
                'order_id' => $this->order_id,
                'price' => $this->price,
                'note' => $this->note,
            ]);
        }

        session()->flash('message', 'تم الحفظ بنجاح');
        $this->saveCoupons($order);
        $this->coupons = [];
        $this->order = "";
        $this->order_id = "";
        $this->price = "0";
        $this->note = "";
    }

    public function delete($order_id)
    {
        Order::find($order_id)->delete();
        session()->flash('message', 'تم الحذف بنجاح');
    }

    public function edit($order_id)
    {
        $order = Order::find($order_id);
        $this->order = $order->id;
        $this->order_id = $order->order_id;
        $this->price = $order->price;
        $this->note = $order->note;
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
