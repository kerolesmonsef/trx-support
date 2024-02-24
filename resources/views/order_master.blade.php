<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
{{--    <link href="{{ asset("css/bootstrap.rtl.min.css") }}" rel="stylesheet">--}}
    <link href="{{ asset("css/main_style.css") }}" rel="stylesheet">
    {{--  icon  --}}
    <link rel="icon" href="{{ asset("images/dark-logo.png") }}" type="image/x-icon">
    <title>{{ config("app.name") }}</title>
    @stack("styles")
</head>
<body class="" style="background-color: #131416">

<div class="container">
    <div class="row mt-5 d-flex">
        <div class="col-md-6 order-md-2">
            <div class="">
                <div class="">
                    <h1 class="mb-0 text-end" style="color: #fea84b">@yield("title")</h1>
                </div>
                <div class="">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @elseif($errors->first())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @yield("content")
                </div>
            </div>
        </div>
        <div class="col-md-6 order-md-1">
            <div class="text-center">
                <img style="width: 140px;" src="{{ asset("/images/logo.png") }}" class="m-2">
            </div>
            <div class="text-start ">
                <img src="{{ asset("/images/hello.png") }}" class="m-2">
            </div>
            @yield("under_image")
        </div>
    </div>
</div>

<script
    src="{{ asset("js/jquery-3.7.1.min.js") }}"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
</body>
<script src="{{ asset("js/sweetalert2@11.js") }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

@stack("scripts")
<script>
    $(".reload-captcha").click(function () {
        // send ajax request to refresh captcha
        $.ajax({
            url: "{{ route("captcha.refresh") }}",
            type: "GET",
            success: function (response) {
                $("#captcha-image").html(response.captcha);
            }
        });
    });

    @if (session('error_pup_up'))
        Swal.fire({
            title: 'حدث خطء',
            text: '{{ session('error_pup_up') }}',
            icon: 'error',
            //showCancelButton: true,
            confirmButtonText: 'حسنا',
            //cancelButtonText: 'لا الغاء!',
            reverseButtons: true
        });
    @endif

    function errorMessage(message){
        Swal.fire({
            title: 'حدث خطء',
            text: message,
            icon: 'error',
            confirmButtonText: 'حسنا',
            reverseButtons: true
        });
    }

</script>

</html>
