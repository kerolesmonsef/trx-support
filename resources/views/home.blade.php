@extends('layouts.app')
@push("styles")
    @livewireStyles
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @livewire("orders")
        </div>
    </div>
</div>
@endsection

@push("scripts")
    @livewireScripts
@endpush
