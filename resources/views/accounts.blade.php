@extends('layouts.app')
@push("styles")

    @livewireStyles
    <script src="{{ asset("js/ckeditor.js") }}"></script>

@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @livewire("accounts")
        </div>
    </div>
</div>
@endsection

@push("scripts")

@endpush
