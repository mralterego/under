@extends("layouts.adminpanel")


@section("title", "Страница с коллективами")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")
    <script type="text/javascript" src="/front/admin/VueCollective.js"></script>

@endsection

@section("view")
    <div id="collective_page" class="container">
        <h4 class="center __margin-top_xxl">Добавить коллектив, лэйбл, промо-группу</h4>
        <div class="row">
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl ">
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text">
                                    <div class="input-group">
                                        <div class="input-field col s6">
                                            <input type="text" v-model="name">
                                            <label class="active">Название</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s6">
                                            <input type="text" v-model="place">
                                            <label class="active">Место</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s12">
                                            <input type="text" v-model="tags">
                                            <label class="active">Тэги через запятую</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s12">
                                            <textarea type="text" v-model="description" class="materialize-textarea"></textarea>
                                            <label class="active">Описание</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text">
                                    <span class="card-title">Социальные ссылки</span>
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
                </div>
            </div>
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl __padding-bottom_s">
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text">
                                    <div class="input-group">
                                        <div class="file-field input-field col s6">
                                            <div class="btn">
                                                <span>Загрузить постер</span>
                                                <input type="file" name="image"  accept="image/*"  v-on:change="uploadImage($event)">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" v-bind:value="image">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group" v-if="showPoster">
                                        <div class="file-field input-field col s6">
                                            <img class="responsive-img" v-bind:src="image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="__padding-right_l">
                                <a class="right waves-effect waves-light btn-large  __margin-left_l" v-on:click="create">
                                    &nbsp;&nbsp;Добавить коллектив
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