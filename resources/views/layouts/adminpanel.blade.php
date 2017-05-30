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
    <nav>
        <div class="nav-wrapper container">
            <a href="#" class="brand-logo">Logo</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Войти</a></li>
                    <li><a href="{{ route('register') }}">Зарегистрироваться</a></li>
                @else
                        <li>Вы вошли как: <span id="username">{{ Auth::user()->name }}</span> </li>

                        @include('include._left_menu')

                    @if (Auth::user()->role == 5)
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="posts">Записи<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="events">События<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="places">Места<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="collectives">Коллективы<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                    @elseif (Auth::user()->role == 4)
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="posts">Записи<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="events">События<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                    @elseif (Auth::user()->role == 3)
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="posts">Записи<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="places">Места<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="collectives">Коллективы<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                    @elseif (Auth::user()->role == 2)
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="posts">Записи<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="collectives">Коллективы<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                    @elseif (Auth::user()->role == 1)
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="posts">Записи<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                    @endif

                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Выйти
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>

                @endif
            </ul>
        </div>
    </nav>

    <ul id="events" class="dropdown-content">
        <li><a href="{{ route('admin.events.index') }}">Создать</a></li>
        <li><a href="{{ route('admin.events.list') }}">Список</a></li>
    </ul>
    <ul id="places" class="dropdown-content">
        <li><a href="{{ route('admin.places.index') }}">Создать</a></li>
        <li><a href="{{ route('admin.places.list') }}">Список</a></li>
    </ul>
    <ul id="posts" class="dropdown-content">
        <li><a href="{{ route('admin.posts.index') }}">Создать</a></li>
        <li><a href="{{ route('admin.posts.list') }}">Список</a></li>
    </ul>
    <ul id="collectives" class="dropdown-content">
        <li><a href="{{ route('admin.collectives.index') }}">Создать</a></li>
        <li><a href="{{ route('admin.collectives.list') }}">Список</a></li>
    </ul>

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