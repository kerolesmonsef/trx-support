<div class="card">
    <div class="card-header">
        @if($group_id)
            تعديل المجموعة رقم {{ $group_id }}
        @else
            طلب جديد
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group">
                <label>اسم المجموعة</label>
                <input type="text" class="form-control" wire:model.live="name" placeholder="اختياري">
            </div>

            <div class="form-group">
                <label>
                    اسم المستخدم / البريد الإلكتروني
                </label>
                <input type="text" class="form-control" wire:model.live="username">
            </div>
            <div class="form-group">
                <label>
                    كلمة المرور
                </label>
                <input type="text" class="form-control" wire:model.live="password">
            </div>
            <div class="form-group">
                <label>
                   الوصف
                </label>
                @livewire('trix', ['value' => $description])
            </div>
            <div class="col-md-12">
                <h2 class="text-center">الحسابات</h2>
                <div>
                    <button class="btn btn-sm btn-info" wire:click="addAccount()">
                        اضافة حساب
                    </button>
                </div>
                <div class="row">
                    @foreach($accounts_array as $key => $account)
                        <div class="col-md-4 mt-3">
                            <div class="card shadow-lg">
                                <div class="card-header">
                                    حساب {{ $key + 1 }}
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>
                                            رقم الطلب
                                            <input type="text" class="form-control" wire:model.live="accounts_array.{{ $key }}.order_id">
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            رقم البروفايل
                                            <input type="text" class="form-control" wire:model.live="accounts_array.{{ $key }}.profile">
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            أضافة حماية رقم هاتف
                                            <input type="text" class="form-control" wire:model.live="accounts_array.{{ $key }}.secure_phone">
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            ملاحظة
                                            <input type="text" class="form-control" wire:model.live="accounts_array.{{ $key }}.note">
                                        </label>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-danger"
                                            wire:confirm="هل انت متأكد من المسح"
                                            wire:click="removeAccount({{ $key }})">حذف</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <div class="col-md-12 mt-1">
                <div>
                    <button class="btn btn-primary" wire:click="save">حفظ</button>
                </div>
            </div>
        </div>
    </div>
</div>
