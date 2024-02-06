@extends("order_master")
@section("title","أدخل رقم الطلب الخاص بك")
@section("content")
    <form action="{{ route("order.check.has.security") }}" method="get">
        <div class="form-group">
            <label style="color: gray" for="order_id" class="font-weight-bold">رقم الطلب</label>
            <input type="text" class="form-control" id="order_id" name="order_id"
                   style="background: #131416; color: gray"
                   placeholder="رقم الطلب" required value="{{ old("order_id") }}">
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label style="color: gray" for="order_id" class="font-weight-bold">
                        من فضلك ادخل الكود التالي
                    </label>
                    <input type="text" class="form-control" name="captcha"
                           style="background: #131416; color: gray"
                           placeholder="الرمز" required>
                </div>
            </div>
            <div class="col-md-5">
                <label style="color: gray" for="order_id" class="font-weight-bold">
                    الرمز
                </label>
                <div class="">
                    <span id="captcha-image">
                        {!!  captcha_img()  !!}
                    </span>
                    <button id="reload-captcha" type="button"
                            style="background: #fea84b;padding: 3px 15px;;font-weight: bold;font-size: 15px;"
                            class="btn ">اعادة تحميل
                    </button>
                </div>
            </div>
        </div>

        <button type="submit" style="background: #fea84b;padding: 10px;font-weight: bold;font-size: 15px"
                class="btn btn-sm form-control mt-3 text-center">اظهر
        </button>
    </form>
@endsection
@push("scripts")
    <script>
        $("#reload-captcha").click(function () {
            // send ajax request to refresh captcha
            $.ajax({
                url: "{{ route("captcha.refresh") }}",
                type: "GET",
                success: function (response) {
                    $("#captcha-image").html(response.captcha);
                }
            });
        });
    </script>
@endpush
