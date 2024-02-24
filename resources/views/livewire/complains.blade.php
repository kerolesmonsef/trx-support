@php use App\Models\OrderComplain; @endphp
<?php
/** @var OrderComplain[] $complains */
?>
<div>
    <div class="card mt-3">
        <div class="card-header">
            المشاكل
        </div>
        <div class="card-body">


            <div class="row mt-5 align-items-center">
                <div class="col-md-4">
                    <div class="card bg-warning rounded shadow-sm text-white">
                        <div class="card-body py-5 text-center">
                            <i class="fa fa-users fa-3x mb-3"></i> <h5 class="card-title font-weight-bold">مشاكل قيد
                                المراجعة</h5>
                            <h1 class="card-text display-4" data-toggle="counter">
                                {{ OrderComplain::query()->where("status","pending")->count() }}
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success rounded shadow-sm text-white">
                        <div class="card-body py-5 text-center">
                            <i class="fa fa-shopping-cart fa-3x mb-3"></i> <h5 class="card-title font-weight-bold">
                                مشاكل تم الحل</h5>
                            <h1 class="card-text display-4" data-toggle="counter">
                                {{ OrderComplain::query()->where("status", "solved")->count() }}
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger rounded shadow-sm text-dark">
                        <div class="card-body py-5 text-center">
                            <i class="fa fa-money-bill fa-3x mb-3"></i> <h5 class="card-title font-weight-bold">
                                مشاكل لم تتم الحل
                            </h5>
                            <h1 class="card-text display-4" data-toggle="counter">
                                {{ OrderComplain::query()->where("status", "not_solved")->count() }}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-5">
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
            <div class="row">
                <div class="col-md-6">
                    @include("livewire.components.complain_type_crud")
                </div>
                <div class="col-md-6">
                    @if($orderComplain)
                        @include("livewire.components.show_complain")
                    @endif
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <label for="">بحث</label>
                    <input type="search" wire:model.live="search" class="form-control" placeholder="بحث">
                </div>
                <div class="col-md-3">
                    <label for="">لحالة</label>
                    <select wire:model.live="status" class="form-control">
                        <option value="">الكل</option>
                        <option value="pending">جار المعالجة</option>
                        <option value="solved">تم الحل</option>
                        <option value="not_solved">مرفوض</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="">نوع المشكلة</label>
                    <select wire:model.live="type" class="form-control">
                        <option value="">الكل</option>
                        @foreach($complain_types as $complainType)
                            <option value="{{ $complainType->id }}">
                                {{ $complainType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table class="table table-bordered mt-5">
                <thead>
                <tr>
                    <th>تسلسل.</th>
                    <th>رقم الطلب</th>
                    <th>الحالة</th>
                    <th>نوع المشكلة</th>
                    <th>اخر معدل</th>
                    <th>تاريخ المشكلة</th>
                    <th>الوصف</th>
                    <th>تعيين</th>
                    <th>فعل</th>
                </tr>
                </thead>
                <tbody>
                @foreach($complains as $complain)
                    <tr>
                        <td>{{ $complain->id }} | {{ $complain->code }}</td>
                        <td>{{ $complain->order->id }}</td>
                        <td>
                            @component("livewire.components.complainStatus")
                                @slot("orderComplain",$complain)
                            @endcomponent
                        </td>
                        <td>{{ $complain->type->name }}</td>
                        <td>{{ $complain->lastUpdatedUser?->name }}</td>
                        <td>{{ $complain->created_at }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($complain->description) }}</td>
                        <td>
                            @if($complain->assignee)
                                {{ $complain->assignee->name }}
                            @else
                                غير معيا بعد
                            @endif
                        </td>
                        <td>
                            <button wire:click="showComplain({{ $complain->id }})" class="btn btn-primary btn-sm">عرض
                            </button>
                            <button
                                wire:confirm="هل انت متأكد من المسح"
                                wire:click="deleteComplain({{ $complain->id }})" class="btn btn-danger btn-sm">مسح
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
