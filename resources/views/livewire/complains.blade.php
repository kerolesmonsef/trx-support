<?php
/** @var \App\Models\OrderComplain[] $complains */
?>
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
                        <option value="non_solved">مرفوض</option>
                    </select>
                </div>
            </div>
            <table class="table table-bordered mt-5">
                <thead>
                <tr>
                    <th>تسلسل.</th>
                    <th>رقم الطلب</th>
                    <th>الحالة</th>
                    <th>تاريخ المشكلة</th>
                    <th>فعل</th>
                </tr>
                </thead>
                <tbody>
                @foreach($complains as $complain)
                    <tr>
                        <td>{{ $complain->id }}</td>
                        <td>{{ $complain->order->id }}</td>
                        <td>
                            @component("livewire.components.complainStatus")
                                @slot("orderComplain",$complain)
                            @endcomponent
                        </td>
                        <td>{{ $complain->created_at }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($complain->description) }}</td>
                        <td>
                            <button wire:click="showComplain({{ $complain->id }})" class="btn btn-primary btn-sm">عرض</button>
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
