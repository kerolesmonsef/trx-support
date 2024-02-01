<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
    @livewireStyles
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @livewire('orders')
        </div>
    </div>
</div>
@livewireScripts
</body>
</html>
