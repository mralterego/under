@if (Auth::user())
    <!---left menu--->
<div id="left-menu">
    <ul id="slide-out" class="side-nav">
        <li><div class="userView">
                <div class="background">
                    <img src="images/office.jpg">
                </div>
                <a href="#!user"><img class="circle" src="{{ Auth::user()->avatar }}"></a>
                <a href="#!name"><span class="black-text name">{{ Auth::user()->name }}</span></a>
                <a href="#!email"><span class="black-text email">{{ Auth::user()->email }}</span></a>
            </div>
        </li>
        <li><div class="divider"></div></li>
        <li v-on:click="openField" ><a class="waves-effect" href="#!"><i class="material-icons">chat</i>Написать сообщение</a></li>
        <li v-if="showUsersField" class="__padding-left_xl __padding-right_xl">
            <div class="input-group">
                <div class="input-field user-search">
                    <input type="text" v-on:click="getUsers" v-on:keyup="search($event)" v-model="getter.name">
                    <label>кому</label>
                </div>
            </div>
            <ul class="__select_users" :class="{ __overflow_y: showScroll }">
                <li v-for="user in users"><a :id="user.id" href="#!" v-on:click="selectGetter($event)">@{{ user.name }}</a></li>
            </ul>
        </li>
        <li v-if="showUsersField"><div class="divider"></div></li>

        @if (Auth::user()->role == 5)
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="posts">
                    <i class="material-icons">description</i>
                    Записи
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="events">
                    <i class="material-icons">event</i>
                    События
                    <i class="material-icons right">arrow_drop_down</i></a>
            </li>
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="places">
                    <i class="material-icons">store_mall_directory</i>
                    Места
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="collectives">
                    <i class="material-icons">people</i>
                    Коллективы
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="albums">
                    <i class="material-icons">library_music</i>
                    Альбом
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
            <li>
                <a class="dropdown-button waves-effect" href="{{ route('admin.rubric.index') }} ">
                    <i class="material-icons">format_list_numbered</i>
                    Рубрики

                </a>
            </li>

        @elseif (Auth::user()->role == 4)
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="posts">
                    <i class="material-icons">description</i>
                    Записи
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="events">
                    <i class="material-icons">event</i>
                    События
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
        @elseif (Auth::user()->role == 3)
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="posts">
                    <i class="material-icons">description</i>
                    Записи
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="places">
                    <i class="material-icons right">store_mall_directory</i>
                    Места
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="collectives">
                    <i class="material-icons">people</i>
                    Коллективы
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
        @elseif (Auth::user()->role == 2)
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="posts">
                    <i class="material-icons">description</i>
                    Записи
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="albums">
                    <i class="material-icons">library_music</i>
                    Альбом
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="collectives">
                    <i class="material-icons">people</i>
                    Коллективы
                    <i class="material-icons right">arrow_drop_down</i></a>
            </li>
        @elseif (Auth::user()->role == 1)
            <li>
                <a class="dropdown-button waves-effect" href="#!" data-activates="posts">
                    <i class="material-icons">description</i>
                    Записи
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
        @endif

        <li><div class="divider"></div></li>
        <li><a class="subheader">Subheader</a></li>
    </ul>
    <!---left menu--->

    <div id="left_message_window" class="modal">
        <div class="modal-content">
            <h4>Диалог с <span class="purple-text text-darken-4">@{{getter.name}}</span></h4>
            <div class="dialog-field">
                <div class="row">
                    <div class="col s12">

                    </div>
                </div>
            </div>
            <div class="row">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea class="materialize-textarea" v-model="message"></textarea>
                            <label>Ваше сообщение</label>
                        </div>
                    </div>
                </form>
            </div>

            <a class="right waves-effect waves-light btn-large  __margin-left_l" v-on:click="sendMessage">
                &nbsp;&nbsp;Отправить
                <i class="material-icons right dp48">send</i>
            </a>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close __close-btn black-text"><i class="material-icons right dp48">clear</i></a>
        </div>
    </div>
</div>
@endif