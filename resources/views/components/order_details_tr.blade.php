<?php
/** @var \App\Helpers\OrderCollectionDto $orderDto */
?>

@if($orderDto->haveAccount())
    <tr>
        <td class="text-right w-color">
            الحسابات
        </td>
        <td>
            @foreach($orderDto->accounts() as $account)
                <div class="card mt-5 ">
                    <div class="card-header bg-warning text-center fw-bolder">
                        {{ $account->group->name }}
                    </div>
                    <div class="card-body" style="background-color: #131416">
                        <ul class="list-group p-0">
                            <li class="list-group-item" style="background-color: #131416">
                                <span class="w-color">ايميل الدخول:</span>
                                <span class="code text-white">{{ $account->group->username ?: "لا يوجد" }}</span>
                                <span class="float-start badge bg-warning copy mt-2" style="cursor: pointer">نسخ </span>
                            </li>
                            <li class="list-group-item" style="background-color: #131416">
                                <span class="w-color">الرقم السري : </span>
                                <span class="code text-white">{{ $account->group->password ?: "لا يوجد" }}</span>
                                <span class="float-start badge bg-warning copy mt-2" style="cursor: pointer">نسخ </span>
                            </li>
                            <li class="list-group-item" style="background-color: #131416">
                                <span class="w-color">البروفايل :</span>
                                <span class="code text-white">{{ $account->profile ?: "لا يوجد" }}</span>
                            </li>
                            <li class="list-group-item" style="background-color: #131416">
                                <span class="w-color">الوصف :</span>
                                <span
                                    class="code text-white d-inline">{!!  $account->group->description ?: "لا يوجد"  !!}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </td>
    </tr>
@endif
@if($orderDto->haveCoupons())
    <tr>
        <td class="text-right w-color">
            الكوبونات
        </td>
        <td>
            <div class="card ">
                <div class="card-header bg-warning text-center fw-bolder">
                    الكوبونات
                </div>
                <div class="card-body" style="background-color: #131416">
                    <ul class="list-group p-0">
                        @forelse($orderDto->coupons() as $coupon)
                            <li class="list-group-item" style="background-color: #131416">
                                <span class="w-color">{{ $loop->index + 1 }}</span>
                                <span class="code text-white">{{ $coupon->code  }}</span>
                                <span class="float-start badge bg-warning copy mt-2" style="cursor: pointer">نسخ </span>
                            </li>
                        @empty
                            <li class="list-group-item" style="background-color: #131416;color: white">لا توجد كوبونات
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </td>
    </tr>
@endif

@if(!$orderDto->haveAny())
    <tr>
    <td colspan="2" class="w-color text-center">لا توجد بيانات</td>
    </tr>
@endif

