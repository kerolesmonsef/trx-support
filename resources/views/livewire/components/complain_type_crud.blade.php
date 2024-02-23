<div class="card">
    <div class="card-header">
        انواع المشاكل
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <td>اسم المشكلة</td>
                <td>نوع المشكلة</td>
                <td>العملية</td>
            </tr>
            @foreach($complain_types as $type)
                <tr>
                    <td>{{ $type->name }}</td>
                    <td>{{ $type->getTypeAr() }}</td>
                    <td>
                        <button wire:click="editComplainType({{ $type->id }})"
                                class="btn btn-primary btn-sm">تعديل
                        </button>
                        <button wire:confirm="هل انت متاكد من المسح"
                                wire:click="deleteComplainType({{ $type->id }})"
                                class="btn btn-danger btn-sm">حذف
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>
                        @if($complain_type_id)
                            تعديل
                            المشكلة: {{ \App\Models\ComplainType::find($complain_type_id)->name }}
                        @else
                            اسم نوع المشكلة
                        @endif
                    </label>
                    <input type="text" wire:model.live="complain_type_name" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <label>نوع المشكلة</label>
                <select class="form-control" wire:model.live="complain_type_type">
                    <option value="account">بروفايل</option>
                    <option value="coupon">كوبون</option>
                </select>
            </div>
        </div>
        <button wire:click="saveComplainType()" class="btn btn-primary btn-sm mt-2">حفظ</button>
        <button wire:click="cancelComplainType()" class="btn btn-dark btn-sm mt-2">الغاء</button>
    </div>
</div>


