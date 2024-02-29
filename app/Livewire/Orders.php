<?php

namespace App\Livewire;

use App\Helpers\Helper;
use App\Models\Coupon;
use App\Models\Order;
use App\Trait\UpdateOrderCanTicketTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination, UpdateOrderCanTicketTrait;

    public $order_id = "";
    public $price = "0";
    public $note = "";
    public $secure_phone = "";
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
            ->withWhereHas("coupons")
            ->withCount("notes")
            ->when($this->search, function (Builder $builder) {
                $builder->where('order_id', 'like', '%' . $this->search . '%')
                    ->orWhereHas("coupons", function ($q) {
                        $q->where('code', 'like', '%' . $this->search . '%');
                    });
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

            $this->validateBeforeUpdate();

        } else { // create
            $this->validateBeforeStore();
        }

        session()->flash('message', 'تم الحفظ بنجاح');
        $this->coupons = [];
        $this->order = "";
        $this->order_id = "";
        $this->price = "0";
        $this->note = "";
        $this->secure_phone = "";
    }

    public function validateBeforeUpdate()
    {
        $this->validate(Helper::onUpdateValidationArray($this->coupons, $this->order));

        $this->update();
    }

    public function validateBeforeStore()
    {
        $this->validate(Helper::onCreateCouponValidationArray($this->coupons));
        $this->store();
    }

    public function update(): \Illuminate\Database\Eloquent\Model|Order|\Illuminate\Database\Eloquent\Collection|array|null
    {
        $order = Order::find($this->order);
        $order->update([
            'order_id' => $this->order_id,
            'price' => $this->price,
            'note' => $this->note,
            'secure_phone' => $this->secure_phone,
        ]);
        $this->saveCoupons($order);

        return $order;
    }

    public function store(): void
    {
        $order =Order::create([
            'order_id' => $this->order_id,
            'price' => $this->price,
            'note' => $this->note,
            'secure_phone' => $this->secure_phone,
        ]);

        $this->saveCoupons($order);
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
        $this->secure_phone = $order->secure_phone;
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

    public function resetSeen($order_id)
    {
        Order::find($order_id)->update([
            'seen_at' => null
        ]);
    }

}
