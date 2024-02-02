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
                                <span style="font-weight: bold;font-size: 20px">
                                    {{ $loop->index + 1  }} - <span class="code">{{ $coupon->code }}</span>
                                </span>
                                <span class="float-start badge bg-secondary"> سعر الكوبون{{ $coupon->price }} $</span>
                                <br>
                                <span class="float-start badge bg-warning copy mt-2" style="cursor: pointer">نسخ الكود</span>
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

{{--    jquery cdn--}}

@endsection

@push("scripts")
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(".copy").click(function () {
            let code = $(this).parent().find(".code").text();
            navigator.clipboard.writeText(code);
            Swal.fire({
                toast: true,
                icon: 'success',
                title: 'تم النسخ بنجاح',
                animation: false,
                position: 'bottom-left',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            })
        });
    </script>
@endpush
