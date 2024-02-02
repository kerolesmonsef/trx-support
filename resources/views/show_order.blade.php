@extends("order_master")
@section("title")
    بيانات الطلب الخاص بك <a href="/" class="text-decoration-none">طلب جديد</a>
@endsection
@section("content")
    <div class="container mt-4">
        <table class="table table-bordered">
            <tr>
                <th style="color: #fea84b" class="text-right">رقم الطلب</th>
                <td style="color: white">{{$order->order_id}}</td>
            </tr>
            @if($order->price)
                <tr>
                    <th style="color: #fea84b" class="text-right">سعر الطلب</th>
                    <td>
                        <span class="badge bg-secondary ">
                                {{ $order->price }} $
                        </span>
                    </td>
                </tr>
            @endif
            <tr>
                <th style="color: #fea84b" class="text-right">الكوبونات</th>
                <td>
                    <ul class="list-group" style="background-color: #131416">
                        @forelse($order->coupons as $coupon)
                            <li class="list-group-item" style="">
                                <span style="color: white;font-weight: bold;font-size: 20px">{{ $loop->index + 1  }} - {{ $coupon->code }}</span>
                                <span class="badge bg-secondary ms-5 me-5">{{ $coupon->price }} $</span>
                            </li>
                        @empty
                            <li class="list-group-item">لا توجد كوبونات</li>
                        @endforelse
                    </ul>
                </td>
            </tr>

            <tr>
                <th style="color: #fea84b" class="text-right">ملاحظات</th>
                <td style="color: white">
                    {{ empty($order->note) ? "لا يوجد" : $order->note }}
                </td>
            </tr>
        </table>
    </div>
@endsection
