<div class="card">
    <div class="card-header">
        @if($order)
            تعديل الطلب رقم {{ \App\Models\Order::find($order)?->order_id }}
        @else
            طلب جديد
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>رقم الطلب</label>
                    <input type="number" class="form-control" wire:model.live="order_id">
                </div>
            </div>
            <div class="form-group">
                <label>السعر</label>
                <input type="number" class="form-control" wire:model.live="price">
            </div>
            <div class="form-group">
                <label>ملاحظة</label>
                <input type="text" class="form-control" wire:model.live="note">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اضافة حماية رقم هاتف</label>
                        <input type="text" class="form-control" wire:model.live="secure_phone">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <h2 class="text-center">الكوبونات</h2>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>كود</td>
                        <td>سعر</td>
                        <td>
                            حذف
                            <button class="btn btn-info btn-sm" wire:click="addCoupon">اضافة كوبون</button>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coupons as $key => $coupon)
                        <tr>
                            <td>
                                <input type="text" class="form-control" wire:model.live="coupons.{{ $key }}.code">
                            </td>
                            <td>
                                <input type="number" class="form-control" wire:model.live="coupons.{{ $key }}.price">
                            </td>
                            <td>
                                <button class="btn btn-danger" wire:click="deleteCoupon({{ $key }})">حذف</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <div>
                    <button class="btn btn-primary" wire:click="save">حفظ</button>
                </div>
            </div>
        </div>
    </div>
</div>
