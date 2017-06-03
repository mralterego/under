@extends("layouts.adminpanel")


@section("title", "Страница создания альбома")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")
    <script type="text/javascript" src="/front/admin/VueAlbum.js"></script>

@endsection

@section("view")
    <div id="album_page" class="container">
        <h4 class="center __margin-top_xxl">Добавить альбом</h4>
        <div class="row">
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl ">
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text">
                                    <div class="input-group">
                                        <div class="input-field col s6">
                                            <input type="text" v-model="title">
                                            <label class="active">Название</label>
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
                                            <textarea type="text" class="materialize-textarea" v-model="description"></textarea>
                                            <label class="active">Описание</label>
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
                                        <div class="col s9">
                                            <div v-if="showAudio">
                                                <div v-for="item in audio" class="audio_file">
                                                    <i class="material-icons left music_icon">music_video</i>
                                                    <p class="audio_name left">@{{ item.name }}</p>
                                                    <audio class="right controls" controls="">
                                                        <source :src="item.path" type="audio/mpeg">
                                                        Тег audio не поддерживается вашим браузером.
                                                        <a :href="item.path">Скачайте музыку</a>.
                                                    </audio>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="file-field input-field col s3">
                                            <div class="btn right __margin-top_xl">
                                                <span>Загрузить аудиo</span>
                                                <input type="file" name="audio" accept="audio/*" enctype="multipart/form-data"  v-on:change="uploadAudio($event)">
                                            </div>
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
                                                <input class="file-path validate" type="text" v-bind:value="poster">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group" v-if="showPoster">
                                        <div class="file-field input-field col s6">
                                            <img class="responsive-img" v-bind:src="poster">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <div class=" __padding-left_l __padding-top_m">
                                <input type="checkbox" id="published"  v-model="published" />
                                <label for="published">Опубликовано</label>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="__padding-right_l">
                                <a class="right waves-effect waves-light btn-large  __margin-left_l" v-on:click="create">
                                    &nbsp;&nbsp;Добавить альбом
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