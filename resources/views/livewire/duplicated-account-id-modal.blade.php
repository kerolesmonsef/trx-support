<div>
    <div class="card">
        <div class="card-header">
            هام
        </div>
        <div class="card-body">
            @if(!empty($orderIds))
                <h5 class=" h5">هذه الاوردرات بها تكرار هل تريد المتابعة</h5>
                <ul class="list-group">
                    @foreach ($orderIds as $orderId)
                        <li class="list-group-item">{{ $loop->iteration }} {{ $orderId }}</li>
                    @endforeach
                </ul>
            @endif

            @if(!empty($username))
                <h5 class="h5">{{ $username }}</h5>
                <h5 class="h5">البريد الالكتروني به تكرار هل تريد المتابعة</h5>
            @endif

        </div>
        <div class="card-footer">
            <button wire:click="cancel" class="btn btn-primary">الغاء و تراجع</button>
            <button wire:click="accept" class="btn btn-primary">حفظ</button>
        </div>
    </div>
</div>
