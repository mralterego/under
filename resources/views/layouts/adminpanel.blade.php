<!DOCTYPE html>
<html lang="ru">
<head>
    <!--head common-->
    @include('include._head')
    <!--head common-->

    <!--head page-->
    @yield('head')
    <!--head page-->
</head>
<body>
    <div class="wrapper">
        @yield('view')
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