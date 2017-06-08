@extends("layouts.adminpanel")


@section("title", "Страница создания альбома")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")
    <script type="text/javascript" src="/front/main/VueLeftMenu.js"></script>
    <script type="text/javascript" src="/common/js/initLeftDialog.js"></script>
    <script type="text/javascript" src="/front/admin/VueAlbumsItem.js"></script>
    <script>
        $('.chips').material_chip();
        $('.chips-placeholder').material_chip({
            secondaryPlaceholder: '+Тэг',
        });
    </script>
    <script type="text/javascript">
        Vue.nextTick(function () {
            vm.id = '{{ $id }}';
            vm.title = '{{ $title }}';
            vm.description = '{{ $description }}';
            vm.tags = '{{ $tags }}';
            vm.poster = '{{ $poster }}';
            vm.published = '{{ $published }}';
            if (vm.poster != ""){
                vm.showPoster = true;
            }
            var audio = '{!! $audio !!}';
            vm.audio = JSON.parse(audio);
        });
    </script>
@endsection

@section("view")
    <div id="albums_item_page" class="container">
        <h4 class="center __margin-top_xxl">Aльбом id{{ $id }}</h4>
        <div class="row">
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_x ">
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
                <div class="card lime lighten-5 __margin-bottom_xl __padding-bottom_s">
                    <div class="row">

                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text">
                                    <div class="input-group">
                                        <div  v-if="showAudio" class="col s9">
                                            <div v-for="item in audio" class="audio_file">
                                                <i class="material-icons left music_icon">music_video</i>
                                                <p class="audio_name left">@{{ item.name }}</p>
                                                <audio class="controls right" controls="">
                                                    <source :src="item.path" type="audio/mpeg">
                                                    Тег audio не поддерживается вашим браузером.
                                                    <a :href="item.path">Скачайте музыку</a>.
                                                </audio>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="file-field input-field col s3">
                                            <div class="btn right">
                                                <span>Загрузить аудио</span>
                                                <input type="file" name="audio" accept="audio/*" enctype="multipart/form-data"  v-on:change="uploadAudio($event)">
                                            </div>
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
                                    <div class="input-group">
                                        <div class="input-group" v-if="showPoster">
                                            <div class="file-field input-field col s6">
                                                <img class="responsive-img" v-bind:src="poster">
                                            </div>
                                        </div>
                                        <div class="file-field input-field col s6">
                                            <div class="btn right">
                                                <span>Загрузить постер</span>
                                                <input type="file" name="image"  accept="image/*"  v-on:change="uploadImage($event)">
                                            </div>
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
                                <a class="right waves-effect waves-light btn-large  __margin-left_l" v-on:click="update">
                                    &nbsp;&nbsp;Обновить
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