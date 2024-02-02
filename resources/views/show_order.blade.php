@extends("order_master")
@section("title")
    بيانات الطلب الخاص بك
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
                            <li class="list-group-item" style="color: black">
                                <span style="font-weight: bold;font-size: 20px">{{ $loop->index + 1  }} - {{ $coupon->code }}</span>
                                <span class="badge bg-secondary ms-5 me-5"> سعر الكوبون{{ $coupon->price }} $</span>
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

        <a style="display: block;
    text-align: center;
    margin-top: 32px;
    border: 1px solid #fea84b;
    border-radius: 5px;
    color: #fea84b;
    padding: 14px;
    font-size: 18px;" href="/" class="text-decoration-none">ادخال رقم طلب جديد</a>
    </div>
@endsection
