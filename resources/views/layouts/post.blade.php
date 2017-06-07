<!DOCTYPE html>
<html lang="ru">
<head>
    <!--head common-->
@include('include._head')
<!--head common-->

    <!--head page-->
@yield('head')
<!--head page-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<nav class="grey darken-3">
    <div class="nav-wrapper container">
        <a href="#" class="brand-logo">Logo</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            @if (Auth::guest())
                <li><a href="{{ route('register') }}">Зарегистрироваться</a></li>
                <li><a href="{{ route('login') }}">Войти</a></li>
                <li class="__menu_icon"><a href="/login/vk"><img src="/images/icons/vk-128.png" class="responsive-img"></a></li>
            @else
                <li>Вы вошли как: <span id="username">{{ Auth::user()->name }}</span> </li>
                @include('include._top_menu')
            @endif

            @include('include._dialog_window')
        </ul>
    </div>
</nav>


<div class="wrapper">
    <div class="container">
        @yield('view')

        <!--rate functionality-->
        @if (Auth::user())
            @include('include._rate_field')
        @endif
        <!--rate functionality-->
    </div>

    @include('include._left_menu')
    @include('include._function_menu')
</div>


<!--head common-->
@include('include._js')
<!--head common-->

<!--vue-->
@yield('vue')
<!--vue-->

<!--foot user assets)-->
@yield('foot')
<!--foot user assets-->
</body>