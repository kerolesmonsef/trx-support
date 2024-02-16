<div>
    <div class="card mt-3">
        <div class="card-header">
            المشاكل
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
            <div class="row ">
                <div class="col-md-6">
                   <div class="card">
                       <div class="card-header">
                           انواع المشاكل
                       </div>
                       <div class="card-body">
                           <table class="table">
                               <tr>
                                   <td>اسم المشكلة</td>
                                   <td>العملية</td>
                               </tr>
                               @foreach($complain_types as $type)
                                   <tr>
                                       <td>{{ $type->name }}</td>
                                       <td>
                                           <button wire:click="editComplainType({{ $type->id }})" class="btn btn-primary btn-sm">تعديل</button>
                                           <button wire:confirm="هل انت متاكد من المسح" wire:click="deleteComplainType({{ $type->id }})" class="btn btn-danger btn-sm">حذف</button>
                                       </td>
                                   </tr>
                               @endforeach
                           </table>
                       </div>
                       <div class="card-footer">
                           <div class="row">
                               <div class="form-group">
                                   <label>
                                       @if($complain_type_id)
                                           تعديل المشكلة: {{ \App\Models\ComplainType::find($complain_type_id)->name }}
                                       @else
                                       اسم نوع المشكلة
                                       @endif
                                   </label>
                                   <input type="text" wire:model.live="complain_type_name" class="form-control">
                               </div>
                           </div>
                           <button wire:click="saveComplainType()" class="btn btn-primary btn-sm mt-2">حفظ</button>
                           <button wire:click="cancelComplainType()" class="btn btn-dark btn-sm mt-2">الغاء</button>
                       </div>
                   </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <label for="">بحث</label>
                    <input type="search" wire:model.live="search" class="form-control" placeholder="بحث">
                </div>
                <div class="col-md-4">

                </div>
            </div>
            <table class="table table-bordered mt-5">
                <thead>
                <tr>
                    <th>تسلسل.</th>
                    <th>رقم الطلب</th>
                    <th>عدد الكوبونات</th>
                    <th>تاريخ الطلب</th>
                    <th> المشاهدة</th>
                    <th>سعر الكوبونات</th>
                    <th>فعل</th>
                </tr>
                </thead>
                <tbody>
                @foreach($complains as $complain)
                    <tr>
                        <td>{{ $complain->id }}</td>
                        <td>{{ $complain->order_id }}</td>
                        <td>{{ $complain->coupons_count }}</td>
                        <td>{{ $complain->created_at }}</td>
                        <td>{{ $complain->seen_at }}</td>
                        <td>{{ $complain->coupons_price() }}</td>
                        <td>
                            <button wire:click="edit({{ $complain->id }})" class="btn btn-primary btn-sm">تعديل</button>
                            <button
                                wire:confirm="هل انت متأكد من المسح"
                                wire:click="delete({{ $complain->id }})" class="btn btn-danger btn-sm">مسح
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $complains->links() }}
        </div>
    </div>
</div>
