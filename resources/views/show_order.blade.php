@php use App\Models\Settings; @endphp
<?php
/** @var $order \App\Models\Order */
$complainTypes = \App\Models\ComplainType::query();
if ($order->hasAccount()) {
    $complainTypes->where("type", "account");
} else {
    $complainTypes->where("type", "coupon");
}
$complainTypes = $complainTypes->get();
?>
@extends("order_master")
@push("styles")
    <style>
        .w-color {
            color: #fea84b
        }

        .complain-input {
            background-color: #131416;
            color: #fea84b;
            border: 1px solid #fea84b;
        }

        .complain-input:focus {
            background-color: #131416;
            color: #fea84b;
        }
    </style>
@endpush

@section("title")
    بيانات الطلب الخاص بك
@endsection
@section("content")
    <title>Trx Support | order id {{ $order->order_id }}</title>
    <div class="container mt-4">
        <table class="table table-bordered">
            <tr>
                <th class="text-right w-color">رقم الطلب</th>
                <td style="color: white">{{$order->order_id}}</td>
            </tr>
            @if($order->price)
                <tr>
                    <th class="text-right w-color">سعر الطلب</th>
                    <td>
                        <span class="badge bg-secondary ">
                                {{ $order->price }} $
                        </span>
                    </td>
                </tr>
            @endif
            <tr>
                <th class="text-right w-color">
                    @if($order->hasAccount())
                        الحساب
                    @else
                        الكوبونات
                    @endif
                </th>
                <td>
                    <ul class="list-group" style="background-color: #131416">
                        @if($order->hasAccount())
                            <li class="list-group-item" style="color: black">
                                ايميل الدخول : <span
                                        class="code">{{ $order->account->group->username }}</span>
                                <span class="float-start badge bg-warning copy mt-2" style="cursor: pointer">نسخ </span>
                            </li>
                            <li class="list-group-item" style="color: black">
                                الرقم السري : <span class="code">{{ $order->account->group->password }}</span>
                                <span class="float-start badge bg-warning copy mt-2" style="cursor: pointer">نسخ </span>
                            </li>
                            <li class="list-group-item" style="color: black">
                                البروفايل : <span class="code">{{ $order->account->profile }}</span>
                            </li>
                        @else
                            @forelse($order->coupons as $coupon)
                                <li class="list-group-item" style="color: black">
                                    <span style="font-weight: bold;font-size: 20px">
                                        {{ $loop->index + 1  }} - <span class="code">{{ $coupon->code }}</span>
                                    </span>
                                    <span
                                            class="float-start badge bg-secondary"> سعر الكوبون{{ $coupon->price }} $</span>
                                    <br>
                                    <span class="float-start badge bg-warning copy mt-2" style="cursor: pointer">نسخ الكود</span>
                                </li>
                            @empty
                                <li class="list-group-item">لا توجد كوبونات</li>
                            @endforelse
                        @endif

                    </ul>
                </td>
            </tr>

            @if($order->warning_rank > 0)
                <tr>
                    <th class="text-right w-color">التحذير</th>
                    <td>
                        @if($order->warning_rank == 1)
                            <span class="text-white">لديك تحزير من الدرجة</span>
                            <span class="badge " style="background-color: yellow">1</span>
                        @elseif($order->warning_rank == 2)
                            <span class="text-white">لديك تحزير من الدرجة</span>
                            <span class="badge bg-warning">2</span>
                        @elseif($order->warning_rank == 3)
                            <span class="text-white">لديك تحزير من الدرجة</span>
                            <span class="badge bg-danger">3</span>
                        @endif
                        <span class="badge bg-secondary">
                            {{ $order->warning_message }}
                        </span>
                    </td>
                </tr>
            @endif

            <tr>
                <th class="text-right w-color">
                    @if($order->hasAccount())
                        الوصف
                    @else
                        ملاحظات
                    @endif
                </th>
                <td style="color: white">
                    @if($order->hasAccount())
                        {!!  $order->account->group->description !!}
                    @else
                        {{ empty($order->note) ? "لا يوجد" : $order->note }}
                    @endif
                </td>
            </tr>
        </table>

        <h5 class="card-title text-center w-color">السياسة والشروط</h5>
        <div style="color: white">
            @if($order->hasAccount())
                {!! Settings::valueByKey('account_privacy_policy') !!}
            @else
                {!! Settings::valueByKey('coupon_privacy_policy') !!}
            @endif
        </div>


        <a style="display: block;
    text-align: center;
    margin-top: 32px;
    border: 1px solid #fea84b;
    border-radius: 5px;
    color: #fea84b;
    padding: 14px;
    font-size: 18px;" href="/" class="text-decoration-none">ادخال رقم طلب جديد</a>

        @if($order->hasPendingComplain())
            <p class="w-color">لديك تذكرة قيد الانتظار برجاء الانتظار و سوف يتم التواصل معك خلال 48 ساعة</p>
        @else
            @include("components.client_complain_modal")
        @endif
        @if($order->complains()->exists())
            @include("components.client_old_complains")
        @endif

    </div>

    {{--    jquery cdn--}}

@endsection

@push("scripts")
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            const max_chars = 100;
            const descriptionObject = $(".complain-description");

            $(".description-char-count").text(max_chars - descriptionObject.val().length);
            descriptionObject.on("input", function () {
                const current_allowed_length =max_chars -  $(this).val().length;
                $(".description-char-count").text( current_allowed_length);
                if (current_allowed_length <= 1) {
                    $(this).val($(this).val().slice(0, max_chars));
                }
            });
        });
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

        $('a').click(function (event) {
            event.preventDefault(); // Prevent the default behavior of the <a> tag

            // Get the URL from the <a> tag's href attribute
            const url = $(this).attr('href');

            Swal.fire({
                title: 'هل انت متاكد?',
                text: 'سيتم نقلك الى صفحة ثاني هل ترغب في متابع',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم!',
                cancelButtonText: 'لا الغاء!',
                reverseButtons: true
            }).then((result) => {
                // If user confirms, proceed with the action
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });

        });
    </script>
@endpush
