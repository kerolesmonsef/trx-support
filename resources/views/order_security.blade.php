@extends("order_master")
@section("title")
    هذا الطلب <span class="text-white">{{ $order->order_id }}</span> محمي
@endsection
@section("content")
    <style>
        .border-button {
            display: block;
            text-align: center;
            margin-top: 32px;
            border: 1px solid #fea84b;
            border-radius: 5px;
            color: #fea84b;
            padding: 14px;
            font-size: 18px;
        }
    </style>
    <div class="container mt-4">
        <form action="{{ route('orders.security.validate',['order_id'=>$order->order_id]) }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="security" style="color: #fea84b">
                            <?php
                            $text = "سجل اخر ٤ ارقام من جوال مسجل في طلبك";
                            ?>
                            {{ $text }}
                        </label>
                        <input
                                style="background: black;border: 1px solid #fea84b;color: #fea84b;"
                                type="text"  class="form-control" id="security" name="security"
                                pattern="[0-9]{4}"
                                placeholder="{{ $text }}"
                                oninput="validateInput(this)"
                                value="">
                    </div>
                    <div class="form-group">
                        <button style="padding: 5px;background: black;" type="submit" class="border-button form-control">اظهر الطلب</button>
                    </div>
                </div>
            </div>
        </form>

        <a style="" href="/" class="text-decoration-none border-button">ادخال رقم طلب جديد</a>
    </div>
<script>
    function validateInput(inputElement) {
        // Remove any non-numeric characters
        inputElement.value = inputElement.value.replace(/\D/g, '');

        if (inputElement.value.length > 4) {
            inputElement.value = inputElement.value.substring(0, 4);
        }
    }
</script>
@endsection

