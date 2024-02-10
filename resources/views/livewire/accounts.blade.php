<div>

    @include("livewire.components.add_edit_account")

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

            <div class="container">
                @foreach ($groups as $group)
                    <div class="row mb-2 mt-2 card border-5 border-dark">
                        <div class="card-header">
                            <h1>{{ $group->id }} - {{ $group->name }}</h1>
                            <button
                                wire:confirm="هل انت متأكد من الحذف"
                                wire:click="removeGroup({{ $group->id }})" class="btn btn-danger float-end m-1">
                                <i class="fa fa-trash"></i>
                                حذف المجموعة
                            </button>
                            <button wire:click="edit({{ $group->id }})" class="btn btn-primary float-end m-1">
                                <i class="fa fa-edit"></i>
                                تعديل المجموعة
                            </button>
                        </div>
                        <div class="card-body">
                           <table class="table">
                            <tr>
                                <th>رقم الطلب</th>
                                <th>تاريخ الطلب</th>
                                <th> المشاهدة</th>
                            </tr>
                                @foreach ($group->accounts as $account)
                                    <tr>
                                        <td>{{ $account->order->order_id }}</td>
                                        <td>{{ $account->order->created_at }}</td>
                                        <td>{{ $account->order->seen_at }}</td>
                                    </tr>
                               @endforeach
                           </table>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $groups->links() }}
        </div>
    </div>
</div>
