@extends("layouts.adminpanel")


@section("title", "Страница с событиями")

@section("head")
    <link rel="stylesheet" href="/addons/datepicker/css/bootstrap-datepicker3.min.css">
    <!--editor assets-->
    <script type="text/javascript" src="/addons/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/addons/ckeditor/sample.js"></script>
    <link rel="stylesheet" href="/addons/ckeditor/css/samples.css">
    <link rel="stylesheet" href="/addons/ckeditor/css/neo.css">
    <!--end editor assets-->
@endsection

@section("foot")
    <script src="/common/js/ckeditor-helper.js"></script>
@endsection

@section("vue")
    <script type="text/javascript" src="/front/VueEvents.js"></script>
@endsection

@section("view")
    <div id="events_page" class="container">
        <h4 class="center __margin-top_xxl">Добавить событие</h4>
        <div class="row">
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl __padding-bottom_xl">
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="card-content black-text">
                                    <div class="input-group">
                                        <div class="input-field col s6">
                                            <input type="text" class="form-control" v-model="title">
                                            <label class="active">Название</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s6">
                                            <input type="text" class="form-control" v-model="place">
                                            <label class="active">Место</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s6">
                                            <input type="text" class="form-control" v-model="price">
                                            <label class="active">Цена</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s6">
                                            <input type="text" class="form-control" v-model="link">
                                            <label class="active">Ссылка</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-field col s12">
                                            <textarea class="materialize-textarea"></textarea>
                                            <label class="active">Статья</label>
                                        </div>
                                    </div>

                                    <!--skeditor--->

                                    <!--div id="main">
                                        <div>
                                            <div class="grid-container">
                                                <div class="grid-width-100">
                                                    <div id="editor">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="editor-content" class="__hidden">
                                        </div>
                                    </div-->

                                    <!--skeditor--->

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

                    <div class="card-action">
                        <a class="right blue darken-2 waves-effect waves-light btn " >
                            <i class="material-icons right dp48">add_circle</i>
                            &nbsp;&nbsp;Добавить
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection