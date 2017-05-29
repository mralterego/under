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
            vm.social.vk = "{{ $vk }}";
            vm.social.fb = "{{ $fb }}";
            vm.social.sc = "{{ $sc }}";
            vm.social.site = "{{ $site }}";
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
    </div>
@endsection