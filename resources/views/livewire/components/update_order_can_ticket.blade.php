<span>
    حالة التذاكر
    @if($order->can_ticket)
        <span class="badge bg-success">يمكن انشاء</span>
    @else
        <span class="badge bg-danger">لا يمكن انشاء</span>
    @endif
    <button type="button" wire:click="updateOrderCanTicket({{ $order->id }})" class="btn btn-info btn-sm">
        تغيير الحالة
    </button>
</span>
