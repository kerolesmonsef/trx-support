<?php
/** @var $user \App\Models\User */

use Spatie\Permission\Models\Permission;

$allPermissions = Permission::all();
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ $user->exists ? route('users.update', $user->id) : route('users.store') }}" method="POST">

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header">{{ $user->exists ? 'تعديل مستخدم' : 'انشاء مستخدم' }}</div>
                        <div class="card-body">
                            @csrf
                            @if($user->exists)
                                @method('PUT')
                            @endif
                            <div class="mb-3">
                                <label for="name" class="form-label">الاسم</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الالكتروني</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ $user->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">كلمة المرور</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                        <div class="card-footer">
                            <h1 class="text-center">الصلاحيات</h1>
                            <div class="row">
                                @foreach($allPermissions as $permission)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label for="per-{{ $permission->id }}">{{ $permission->name_ar }}</label>
                                            <input
                                                name="permissions[]"
                                                @if($user->hasPermissionTo($permission)) checked @endif
                                                id="per-{{ $permission->id }}" class="form-check-input" type="checkbox" value="{{ $permission->id }}" >
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
