@php use App\Models\User; @endphp
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
                    <td>المجموعة</td>
                    <td>{{ $orderComplain->order->account->group->id }}
                        | {{ $orderComplain->order->account->group->name }} </td>
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
                </tr>
            @endif
            <tr>
                <th>الموظف</th>
                <td>
                    <select class="form-control" wire:model.live="assignee_id" wire:change="updateAssignee">
                        <option value="">غير معين</option>
                        @foreach(User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <th>الرد علي التذكرة</th>
                <td>
                    <textarea class="form-control" placeholder="اكتب الرد علي التذكرة للعميل" rows="3"
                              wire:model.live="complain_answer"></textarea>
                    <button class="btn btn-sm btn-primary mt-2" wire:click="updateAnswer">حفظ الرد</button>
                </td>
            </tr>

            <tr>
                <th>التاريخ</th>
                <td>{{ $orderComplain->created_at }}</td>
            </tr>

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

