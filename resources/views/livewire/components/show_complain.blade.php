<?php
/** @var \App\Models\OrderComplain $orderComplain */
?>
<div class="card">
    <div class="card-header">
        عرض المشكلة رقم {{ $orderComplain->id }}
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>رقم الطلب</th>
                <td>{{ $orderComplain->order->order_id }}</td>
            </tr>

            <tr>
                <th>حالة المشكلة</th>
                <td>
                    @component("livewire.components.complainStatus")
                        @slot("orderComplain",$orderComplain)
                    @endcomponent
                </td>
            </tr>
            <tr>
                <th>نوع المشكلة</th>
                <td>{{ $orderComplain->type->name }}</td>
            </tr>

            @if($orderComplain->order->hasAccount())
                <tr>
                    <td> رقم البروفايل</td>
                    <td>{{ $orderComplain->order->account->profile }}
                </tr>
                <tr>
                    <td>لمجموعة</td>
                    <td>{{ $orderComplain->order->account->group->id }} | {{ $orderComplain->order->account->group->name }} </td>
                </tr>
            @endif

            @if($orderComplain->order->hasCoupons())
                <tr>
                    <td>الكوبونات</td>
                    <td>
                        <ul class="list-group">
                            @foreach($orderComplain->order->coupons as $coupon)
                                <li class="list-group-item">{{ $coupon->code }}</li>
                            @endforeach
                        </ul>
                    </td>
            @endif
            <tr>
                <th>المشكلة</th>
                <td>{{ $orderComplain->description }}</td>
            </tr>
            <tr>
                <th>تعديل الحالة</th>
                <th>
                    <button class="btn btn-sm btn-warning" wire:click="updateStatus('pending')">جار المعالجة</button>
                    <button class="btn btn-sm btn-success" wire:click="updateStatus('solved')">تم الحل</button>
                    <button class="btn btn-sm btn-danger" wire:click="updateStatus('not_solved')">رفض</button>
                </th>
            </tr>
        </table>
    </div>
</div>

