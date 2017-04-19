@extends("layouts.adminpanel")


@section("title", "Страница с парсерами")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")
    <script type="text/javascript" src="/front/VueParser.js"></script>
@endsection

@section("view")
    <div id="parser_page" class="container">
        <h2 class="center">Настройки парсеров</h2>
        <div class="row">
            <div class="col s12">
                <div class="card lime lighten-5 __margin-top_xl __margin-bottom_xl __padding-bottom_xl">
                    <div class="row">

                        <div class="card-content black-text">
                            <span class="card-title">&nbsp;&nbsp;Создание парсера</span>
                            <div class="input-group">
                                <div class="input-field col s4">
                                    <input v-model="alias" type="text" class="form-control">
                                    <label>alias</label>
                                </div>
                                <div class="input-field col s4">
                                    <input v-model="url" type="text" class="form-control">
                                    <label>url откуда парсить</label>
                                </div>
                                <div class="input-field col s4">
                                    <input v-model="events_path" type="text" class="form-control">
                                    <label>dom путь к событиям</label>
                                </div>
                                <div class="input-field col s3">
                                    <input v-model="title_path" type="text" class="form-control">
                                    <label>путь заголовка</label>
                                </div>
                                <div class="input-field col s2">
                                    <input v-model="link_path" type="text" class="form-control">
                                    <label>путь на полную ссылку</label>
                                </div>
                                <div class="input-field col s2">
                                    <input v-model="date_path"  type="text" class="form-control">
                                    <label>путь к дате</label>
                                </div>
                                <div class="input-field col s3">
                                    <input v-model="img_path"  type="text" class="form-control">
                                    <label>путь к изображению</label>
                                </div>
                                <div class="input-field col s2">
                                    <input  v-model="article_path"  type="text" class="form-control">
                                    <label>путь к тексту</label>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-action">
                        <a class="right waves-effect waves-light btn" v-on:click="create">
                            <i class="material-icons right dp48" >add_box</i>
                            &nbsp;&nbsp;Добавить парсер
                        </a>
                        <a class="right blue darken-2 waves-effect waves-light btn __margin-right_xl" v-on:click="test">
                            <i class="material-icons right dp48">build</i>
                            &nbsp;&nbsp;Протестировать
                        </a>

                    </div>
                </div>
            </div>
            <div class="col s12">

            </div>
        </div>

        <h2 class="center">Кофинурация текущих парсеров</h2>
        <div class="row">
            <template v-for="item in parsers" >
                <div class="__margin-top_xl">
                    <event-parser  v-bind:p_url="item.url" v-bind:p_alias="item.alias"  v-bind:p_events_path="item.events_path" v-bind:p_title_path="item.title_path"  v-bind:p_date_path="item.date_path" v-bind:p_img_path="item.img_path"  v-bind:p_link_path="item.link_path" v-bind:p_article_path="item.article_path" v-bind:p_is_active="item.isActive" ></event-parser>
                </div>
            </template>
        </div>
    </div>
@endsection