@extends("layouts.adminpanel")


@section("title", "Домашняя страница пользователя")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")
    <script type="text/javascript" src="/front/admin/VueHomepage.js"></script>
    <script type="text/javascript">
        Vue.nextTick(function (){
            vm.social.vk = "{{ $social['vk'] }}";
            vm.social.fb = "{{ $social['fb'] }}";
            vm.social.sc = "{{ $social['sc'] }}";
            vm.social.site = "{{ $social['site'] }}";
            $(".button-collapse").sideNav();
        });
    </script>
@endsection

@section("view")
    <div id="homepage" class="container">


        <div class="row">
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl ">

                    @if ($social == null)

                        <div class="row">
                            <div class="col s12">
                                <div class="row">
                                    <div class="card-content black-text">
                                        <span class="card-title">&nbsp;&nbsp;Заполните свой профиль</span>
                                        <div class="input-group">
                                            <div class="input-field col s3">
                                                <input type="text" v-model="social.site">
                                                <label class="active">сайт</label>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-field col s3">
                                                <input type="text"  v-model="social.vk" >
                                                <label class="active">vk</label>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-field col s3">
                                                <input type="text" v-model="social.fb" >
                                                <label class="active">facebook</label>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-field col s3">
                                                <input type="text" v-model="social.sc">
                                                <label class="active">soundcloud</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else

                        <div class="row">
                            <div class="col s12">
                                <div class="row">
                                    <div class="card-content black-text">
                                        <span class="card-title">&nbsp;&nbsp;Социальные ссылки</span>
                                        <div class="input-group">
                                            <div class="input-field col s3">
                                                <input type="text" v-model="social.site">
                                                <label class="active">сайт</label>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-field col s3">
                                                <input type="text"  v-model="social.vk" >
                                                <label class="active">vk</label>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-field col s3">
                                                <input type="text" v-model="social.fb" >
                                                <label class="active">facebook</label>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-field col s3">
                                                <input type="text" v-model="social.sc">
                                                <label class="active">soundcloud</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif
                        <div class="row __padding-bottom_l">
                            <div class="col s12">
                                <div class="__padding-right_l ">
                                    <a class="right waves-effect waves-light btn-large  __margin-left_l" v-on:click="update">
                                        &nbsp;&nbsp;обновить
                                        <i class="material-icons right dp48">note_add</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <!---left menu--->
        <ul id="slide-out" class="side-nav">
            <li><div class="userView">
                    <div class="background">
                        <img src="images/office.jpg">
                    </div>
                    <a href="#!user"><img class="circle" src="images/yuna.jpg"></a>
                    <a href="#!name"><span class="black-text name">{{ Auth::user()->name }}</span></a>
                    <a href="#!email"><span class="black-text email">{{ Auth::user()->email }}</span></a>
                </div></li>
            <li v-on:click="openField" ><a href="#!"><i class="material-icons">chat</i>Написать сообщение</a></li>
            <li v-if="showUsersField" class="__padding-left_xl __padding-right_xl">
                <div class="input-group">
                    <div class="input-field user-search">
                        <input type="text">
                        <label>кому</label>
                    </div>
                </div>
                <ul class="__select_users">
                    <li><a href="#!">Серега</a></li>
                    <li><a href="#!">Петр</a></li>
                    <li><a href="#!">Вася</a></li>
                    <li><a href="#!">Лаврентий</a></li>
                </ul>
            </li>
            <li><a href="#!">Second Link</a></li>
            <li><div class="divider"></div></li>
            <li><a class="subheader">Subheader</a></li>
            <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
        </ul>
        <!---left menu--->

    </div>
@endsection