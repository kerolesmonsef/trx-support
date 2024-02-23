<button class="btn btn-sm btn-info" wire:click="$dispatch('openModal', { component: 'order-notes-component' , arguments :{order_id:'{{ $order->id }}'} },)">
    عرض الملاحظات
    {{ $order->notes_count ?? $order->notes->count() }}
</button>
