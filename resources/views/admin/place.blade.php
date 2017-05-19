@extends("layouts.adminpanel")


@section("title", "Страница с местами")

@section("head")
    <style>
        #map {
            height: 500px;
        }
    </style>

@endsection

@section("foot")

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAafNNNfqmsn7VHcU0rg1uw8BO0daZrj6Q"></script>

@endsection

@section("vue")
    <script type="text/javascript" src="/front/admin/VuePlaces.js"></script>
@endsection

@section("view")
<div id="places_page">
    <div class="container">
        <h4 class="center __margin-top_xxl">Добавить место</h4>
        <div class="row">
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl __padding-bottom_xs">
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text">
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="title">
                                            <label class="active">Название</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="alias">
                                            <label class="active">Алиас</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text"  v-model="site">
                                            <label class="active">Ссылка на сайт</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="address">
                                            <label class="active">Адрес</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="worktime">
                                            <label class="active">Время работы</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s4">
                                            <input type="text" v-model="coordinates" v-on:click="showModal = !showModal">
                                            <label class="active">Координаты</label>
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
                                            <textarea class="materialize-textarea" v-model="description"></textarea>
                                            <label class="active">Описание  места</label>
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
                                        <div class="file-field input-field col s6">
                                            <div class="btn">
                                                <span>Загрузить изображение</span>
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
                    <div class="row ">
                        <div class="col s6">
                            <div class=" __padding-left_l __padding-top_m">
                                <input type="checkbox" id="published"  v-model="published" />
                                <label for="published">Опубликовано</label>
                            </div>
                        </div>
                        <div class="col s6">

                            <div class="__padding-right_l ">
                                <a class="right waves-effect waves-light btn-large  " v-on:click="create">
                                    &nbsp;&nbsp;Создать
                                    <i class="material-icons right dp48">note_add</i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="overlay " v-bind:class="{ __hidden : !showModal }">
    </div>
    <div class="modal-win" v-bind:class="{ __hidden : !showModal }">
        <div class="modal-close" v-on:click="showModal = !showModal">
            <span>X</span>
        </div>
        <div id="map"></div>
    </div>
</div>
@endsection