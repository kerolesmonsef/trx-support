@php use Carbon\Carbon; @endphp
<?php
/** @var $group \App\Models\Group */
?>
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

            <div class="container mt-3">
                <div class="row">
                    <div class="accordion" wire:ignore>
                        @foreach ($groups as $group)
                                <?php $accordion_id = "accordion-group-{$group->id}"; ?>

                            <div class="accordion-item mb-4 card border border-dark">
                                <div class="accordion-header" id="headingOne">
                                    <div class="overflow-hidden pt-1" >
                                        <h1 data-bs-toggle="collapse" data-bs-target="#{{ $accordion_id }}" style="cursor: pointer;display: inline">{{ $group->id }} - {{ $group->name }}</h1>
                                        <button wire:confirm="هل انت متأكد من الحذف" wire:click="removeGroup({{ $group->id }})" class="btn btn-danger float-end m-1">
                                            <i class="fa fa-trash"></i> حذف المجموعة
                                        </button>
                                        <button wire:click="edit({{ $group->id }})" class="btn btn-primary float-end m-1">
                                            <i class="fa fa-edit"></i> تعديل المجموعة
                                        </button>
                                    </div>
                                </div>
                                <div id="{{ $accordion_id }}" class="accordion-collapse collapse" aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <div class="card">
                                            <div class="card-header bg-primary text-white">
                                                بيانات المجموعة
                                            </div>
                                            <div class="card-body">
                                                <div class="row ">
                                                    <div class="col-md-6 offset-md-6">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 text-end">
                                                                <span class="badge bg-secondary">{{ $group->accounts_count }}</span> : عدد البروفايلات
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <span class="badge bg-secondary">{{ $group->username }}</span> : البريد الالكتروني
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 text-end">
                                                                <span class="badge bg-secondary">{{ $group->password }}</span> : الرقم السري
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <span class="badge bg-secondary">{{ Carbon::parse($group->updated_at)->diffForHumans() }}</span> : اخر تحديث
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <table class="table">
                                                    <tr>
                                                        <th>رقم الطلب</th>
                                                        <th>تاريخ الطلب</th>
                                                        <th>رقم البروفايل</th>
                                                        <th>ملاحظات</th>
                                                        <th>المشاهدة</th>
                                                        <th>تاريخ اخر تحديث</th>
                                                    </tr>
                                                    @foreach ($group->accounts as $account)
                                                        <tr>
                                                            <td>{{ $account->order->order_id }}</td>
                                                            <td>{{ $account->order->created_at }}</td>
                                                            <td>{{ $account->profile }}</td>
                                                            <td>{{ $account->order->note }}</td>
                                                            <td>{{ $account->order->seen_at }}</td>
                                                            <td>{{ $account->order->updated_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>


            {{ $groups->links() }}
        </div>
    </div>
</div>
