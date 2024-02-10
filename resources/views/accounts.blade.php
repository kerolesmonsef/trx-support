@extends('layouts.app')
@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css" />
    @livewireStyles
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
    @livewireScripts
@endpush
