@extends("layouts.adminpanel")


@section("title", "Страница cписка альбомов")

@section("head")

@endsection

@section("foot")

@endsection

@section("vue")
    <script type="text/javascript" src="/front/admin/VueAlbumsList.js"></script>

@endsection

@section("view")
    <div id="albums_list_page" class="container">
        <h4 class="center __margin-top_xxl">Твои альбомы</h4>
        <div class="row">
            <div class="col s12">
                <table v-if="showTable" class="centered bordered __margin-top_xxl __border __margin-bottom_xxl">
                    <thead>
                    <tr>
                        <th><h6>ID</h6></th>
                        <th><h6>Название</h6></th>
                        <th><h6>Тэги</h6></th>
                        <th><h6>Опубликован</h6></th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="(item, key) in items" >
                        <tr class="hovered-row"  :id="key + '_' + item.id">
                            <td><a :href="'/admin/albums/' + item.id" target="_blank">id@{{ item.id }}</a></td>
                            <td class="__width_850">@{{item.title}}</td>
                            <td>@{{ item.tags }}</td>
                            <td>@{{ item.published }}</td>
                        </tr>
                    </template>
                    </tbody>
                </table>
                <p v-if="!showTable" class="center __margin-top_xxl __margin-bottom_xxl">Ничего нет!</p>
            </div>
        </div>
    </div>
@endsection