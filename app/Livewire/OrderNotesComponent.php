<?php

namespace App\Livewire;

use App\Models\Group;
use App\Models\Order;
use App\Models\OrderNote;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class OrderNotesComponent extends ModalComponent
{
    public Order $order;

    public $note = '';

    public function mount($order_id)
    {
        $this->order = Order::find($order_id);
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.order-notes-component');
    }

    public function save()
    {
        OrderNote::query()
            ->create([
                'order_id' => $this->order->id,
                'user_id' => auth()->id(),
                'note' => $this->note
            ]);

        $this->note = '';
    }
}
