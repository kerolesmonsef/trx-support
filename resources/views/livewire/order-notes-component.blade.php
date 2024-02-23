<?php
/** @var \App\Models\Order $order */
$notes = $order->notes()->orderByDesc("id")->get();
?>
<div>
    <div class="card">
        <div class="card-header">
            ملاحظات الطلب رقم {{ $order->order_id }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>تسلسل</th>
                        <th>اسم المستخدم</th>
                        <th>الملاحظات</th>
                    </tr>
                    @foreach($notes as $note)
                        <tr>
                            <td>{{ $note->id }} </td>
                            <td>{{ $note->user->name }} </td>
                            <td>{{ $note->note }} </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-group">
                <label>اكتب ملاحظاتك</label>
                <textarea name="note" class="form-control" rows="5" wire:model.live="note"></textarea>
            </div>
            <button class="btn btn-primary" wire:click="save">حفظ</button>
        </div>
    </div>
</div>
