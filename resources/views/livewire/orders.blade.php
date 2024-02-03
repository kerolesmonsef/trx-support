<div>

    @include("livewire.components.add_edit_order")

    <div class="card mt-3">
        <div class="card-header">
            الطلبات
        </div>
        <div class="card-body">
            <div class="row">
                <div>
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>

                {{--                show errros from $errors--}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>

            <hr>
            <div class="row">
                <div class="col-md-4">
                    <label for="">بحث</label>
                    <input type="search" wire:model.live="search" class="form-control" placeholder="بحث">
                </div>
                <div class="col-md-4">
                    <label for="">تمة مشاهدة الطلب</label>
                    <select wire:model.live="seen_type" class="form-control">
                        <option value="all">الكل</option>
                        <option value="seen">تم مشاهدته</option>
                        <option value="unseen">لم تتم مشاهدته</option>
                    </select>
                </div>
            </div>
            <table class="table table-bordered mt-5">
                <thead>
                <tr>
                    <th>تسلسل.</th>
                    <th>رقم الطلب</th>
                    <th>عدد الكوبونات</th>
                    <th>تاريخ الطلب</th>
                    <th>تاريخ المشاهدة</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->coupons_count }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->seen_at }}</td>
                        <td>
                            <button wire:click="edit({{ $order->id }})" class="btn btn-primary btn-sm">تعديل</button>
                            <button
                                wire:confirm="هل انت متأكد من المسح"
                                wire:click="delete({{ $order->id }})" class="btn btn-danger btn-sm">مسح</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $orders->links() }}
        </div>
    </div>
</div>
