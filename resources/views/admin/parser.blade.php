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
        <h4 class="center __margin-top_xxl">Конфигурация текущих парсеров</h4>
        <div class="row">
            <template v-for="item in parsers" >
                <div class="__margin-top_xl">
                    <event-parser v-bind:p_url="item.url" v-bind:p_alias="item.alias" v-bind:p_place="item.place"   v-bind:p_events_path="item.events_path" v-bind:p_title_path="item.title_path"  v-bind:p_date_path="item.date_path" v-bind:p_img_path="item.img_path"  v-bind:p_link_path="item.link_path" v-bind:p_article_path="item.article_path" v-bind:p_is_active="item.isActive" ></event-parser>
                </div>
            </template>
        </div>
    </div>
@endsection