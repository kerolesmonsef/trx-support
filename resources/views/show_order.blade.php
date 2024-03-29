@php
 use App\Helpers\OrderCollectionDto;
 use App\Models\Settings;
 use Carbon\Carbon;
 @endphp
<?php
/** @var $order \App\Models\Order */
$complainTypes = \App\Models\ComplainType::query();
if ($order->hasAccount()) {
    $complainTypes->where("type", "account");
} else {
    $complainTypes->where("type", "coupon");
}
$complainTypes = $complainTypes->get();
$orderDto = OrderCollectionDto::related($order);
?>
@extends("order_master")


@section("title")
    بيانات الطلب الخاص بك
@endsection
@push("styles")
    <link href="{{ asset("css/smart_wizard_all.min.css") }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset("css/counter_down.css") }}">

@endpush
@section("content")
    <title>{{ config("app.name") }} | order id {{ $orderDto->getOrderId() }}</title>
    <div class="container mt-4">
        <table class="table table-bordered" dir="rtl">
            <tr>
                <th class=" w-color">رقم الطلب</th>
                <td style="color: white">{{ $orderDto->getOrderId() }}</td>
            </tr>
            @include("components.order_details_tr")
            <tr>
                <th class="text-right w-color">اخر تحديث</th>
                <td>
                    <span class="badge bg-secondary">
                        {{ Carbon::parse($order->updated_at)->diffForHumans() }}
                    </span>
                    <span class="badge bg-secondary">
                        {{ $order->updated_at }} توقيت مكة
                    </span>
                </td>
            </tr>
            @if($order->warning_rank > 0)
                <tr>
                    <th class="text-right w-color">التحذير</th>
                    <td>
                        @if($order->warning_rank == 1)
                            <span class="text-white">لديك تحزير من الدرجة</span>
                            <span class="badge " style="background-color: yellow;color: black">1</span>
                        @elseif($order->warning_rank == 2)
                            <span class="text-white">لديك تحذير من الدرجة</span>
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

        <h5 class="card-title text-center w-color toggle-privacy" style="cursor: pointer"
            data-target=".privacy_content">

        </h5>


        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button w-color" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                            style=" background-color: #131416;"
                            dir="rtl"
                    >
                        السياسة والشروط
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body bg-dark border-white">

                        <div dir="rtl" style="color: white">
                            @if($order->hasAccount())
                                {!! Settings::valueByKey('account_privacy_policy') !!}
                            @else
                                {!! Settings::valueByKey('coupon_privacy_policy') !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

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
            <p class="w-color text-end">- يجب انتظار انتهاء معالجة التذكرة الحالية قبل فتح تذكرة جديدة في النظام</p>
            <p class="w-color text-end"> # - في حال مر على تذكرتك أكثر من 48 ساعه ولم يتم حل ,
                يمكنك التواصل معنا عبر قنوات الدعم لمتاجر تركس</p>
        @else
            @include("components.client_complain_modal")
        @endif
        @if($order->complains()->exists())
            @include("components.client_old_complains")
        @endif
    </div>
@endsection

@if($order->hasPendingComplain() && $order->isBefore48HourFromLastPendingComplain())
    @section("under_image")
        @include("components.contact_counter_down")
    @endsection
@elseif($order->hasPendingComplain())
    @section("under_image")
        @include("components.contact_support")
    @endsection
@endif
@push("scripts")
    <script src="{{ asset("js/jquery.smartWizard.min.js") }}" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            const max_chars = 100;
            const descriptionObject = $(".complain-description");

            $(".description-char-count").text(max_chars - descriptionObject.val().length);
            descriptionObject.on("input", function () {
                const current_allowed_length = max_chars - $(this).val().length;
                $(".description-char-count").text(current_allowed_length);
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


        function checkCaptcha(captcha){
            let check = false;
            $.ajax({
                url: `/captcha-check?captcha=${captcha}`,
                type: "GET",
                async: false,
                success: function (response) {
                    check = response.captcha;
                }
            });
            return check;
        }


        $('.smartwizard').smartWizard({
            selected: 0,
            theme: 'dots',
            keyboard: {
                keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
                keyLeft: [37], // Left key code
                keyRight: [39] // Right key code
            },
            lang: { // Language variables for button
                next: 'التالي',
                previous: 'السابق'
            },
            onLeaveStep: function (evt, stepNumber, message) {
                console.log("dsds")
            },
        });

        $(".smartwizard").on("leaveStep", function (e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
            // forward - backward
            let complainDescription = $("#complainDescription").val();
            let complainCaptcha = $("#complain-captcha").val();
            if (currentStepIndex === 1 && stepDirection === "forward" && complainDescription.length <= 0) {
                $(".complain-error").show();
                return false;
            }
            $(".invalid-feedback").hide();

            if (currentStepIndex === 1 && stepDirection === "forward" && complainCaptcha.length <= 0) {
                $(".complain-captcha-error").text("من فضلك ادخل الرمز");
                $(".complain-captcha-error").show();
                return false;
            }
            $(".invalid-feedback").hide();

            if (currentStepIndex === 1 && stepDirection === "forward" && !checkCaptcha(complainCaptcha)) {
                $(".complain-captcha-error").text("من فضلك ادخل الرمز صحيح");
                $(".complain-captcha-error").show();
                $('.reload-captcha').trigger("click");
                return false;
            }
            $(".invalid-feedback").hide();
            return true;
        });

        $(".toggle-privacy").click(function () {
            const target = $(this).data("target");
            $(target).toggle();
        });

        const countdownDate = new Date('{{ $order->lastPendingComplainDateForSupport() ?? now()->format("Y-m-d") }}');
    </script>

    <script src="{{ asset("js/counter_down.js") }}"></script>
@endpush
