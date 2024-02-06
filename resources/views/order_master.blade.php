<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
{{--  icon  --}}
    <link rel="icon" href="{{ asset("images/dark-logo.png") }}" type="image/x-icon">
    <title>Trx Support</title>
</head>
<body class="" style="background-color: #131416" dir="rtl">

<div class="container" >
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="">
                <div class="">
                    <h1 class="mb-0 " style="color: #fea84b">@yield("title")</h1>
                </div>
                <div class="">
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    {{-- show laraval validation error --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                    @yield("content")
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="text-center">
                <img style="width: 140px;" src="{{ asset("/images/logo.png") }}" class="m-2">
            </div>
            <div class="text-start">
                <img  src="{{ asset("/images/hello.png") }}" class="m-2">
            </div>
        </div>

    </div>
</div>

<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
</body>
@stack("scripts")
</html>
