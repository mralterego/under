<li class="__menu_item">
    <a title="Меню" href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
</li>
<li class="__menu_messages">
    <message v-on:dialog="openDialog"></message>
</li>
<li>
    <a title="Выход" href="{{ route('logout') }}"
       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
        <i class="material-icons">exit_to_app</i>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</li>