@extends("order_master")
@section("title","أدخل رقم الطلب الخاص بك")
@section("content")
    <form action="{{ route("orders.show") }}" method="get">
        <div class="form-">
            <label style="color: gray" for="order_id" class="font-weight-bold">رقم الطلب</label>
            <input type="text" class="form-control" id="order_id" name="order_id"
                   style="background: #131416; color: gray"
                   placeholder="رقم الطلب" required>
        </div>

        <button type="submit" style="background: #fea84b;padding: 10px;font-weight: bold;font-size: 15px" class="btn btn-sm form-control mt-3 text-center">اظهر</button>
    </form>
@endsection
