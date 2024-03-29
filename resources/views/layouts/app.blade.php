<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
    <link rel="icon" href="{{ asset("images/dark-logo.png") }}" type="image/x-icon">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <!-- Scripts -->
    @stack("styles")

    @auth()
        <script src="{{ asset("js/main.js") }}"></script>
        <link href="{{ asset("css/tailwind.min.css") }}" rel="stylesheet">
        <link href="{{ asset("css/admin-main.css") }}" rel="stylesheet">
        <link href="{{ asset("css/all.min.css") }}" rel="stylesheet">
    @endauth
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        @can("coupons")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route("coupons.index") }}">الكوبونات</a>
                            </li>
                        @endcan
                        @can("accounts")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route("accounts.index") }}">البروفايلات</a>
                            </li>
                        @endcan
                        @can("settings")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route("settings.index") }}">الاعدادات</a>
                            </li>
                        @endcan
                        @can("users")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route("users.index") }}">المشرفين</a>
                            </li>
                        @endcan
                        @can("complains")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route("complains.index") }}">
                                    الشكاوي
                                    <span class="badge bg-danger">{{ \App\Models\OrderComplain::query()->where("status","pending")->count() }}</span>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
@auth()
    @livewire('wire-elements-modal')
    @livewireScripts
@endauth
@stack("scripts")
</html>
